<?php

namespace ColdTrick\ProfileManager;

use Elgg\Http\OkResponse;

/**
 * Users
 */
class Users {

	/**
	 * Saves extra user information when user registers on the site
	 *
	 * @param \Elgg\Event $event 'create', 'user'
	 *
	 * @return void
	 */
	public static function createUserByRegister(\Elgg\Event $event) {
		$custom_profile_fields = [];
		
		/* @var \ElggUser $user */
		$user = $event->getObject();
	
		// retrieve all field that were on the register page
		foreach ($_POST as $key => $value) {
			if (str_starts_with($key, 'custom_profile_fields_')) {
				$key = substr($key, 22);
				$custom_profile_fields[$key] = get_input("custom_profile_fields_{$key}");
			}
		}
	
		if (count($custom_profile_fields) > 0) {
			$categorized_fields = profile_manager_get_categorized_fields(null, true, true);
			$configured_fields = $categorized_fields['fields'];
	
			elgg_call(ELGG_IGNORE_ACCESS, function() use ($user, $configured_fields, $custom_profile_fields) {
				$user_default_access = elgg_get_default_access($user);
				
				foreach ($custom_profile_fields as $shortname => $value) {
					// determine if $value should be an array
					if (!is_array($value) && !empty($configured_fields)) {
						foreach ($configured_fields as $configured_field_category) {
							foreach ($configured_field_category as $configured_field) {
								if ($configured_field->metadata_name !== $shortname) {
									continue;
								}
								
								if ($configured_field->metadata_type !== 'tags' && $configured_field->output_as_tags !== 'yes') {
									continue;
								}
								
								$value = elgg_string_to_array((string) $value);
								
								// no need to continue this foreach
								break(2);
							}
						}
					}
					
					if (empty($value) && $value !== 0) {
						continue;
					}
					
					$user->setProfileData($shortname, $value, $user_default_access);
				}
			});
		}
	
		if (elgg_get_uploaded_file('profile_icon')) {
			if (!$user->saveIconFromUploadedFile('profile_icon')) {
				elgg_register_error_message(elgg_echo('avatar:upload:fail'));
				// return false to delete the user
				return false;
			}
		}
	
		$terms = elgg_get_plugin_setting('registration_terms', 'profile_manager');
		if ($terms) {
			// already checked for acceptance in middleware
			$user->general_terms_accepted = time();
		}
	
		elgg_clear_sticky_form('profile_manager_register');
	}

	/**
	 * Saves extra user information when user is created with admin useradd form
	 *
	 * @param \Elgg\Event $event 'create', 'user'
	 *
	 * @return void
	 */
	public static function createUserByAdmin(\Elgg\Event $event) {
		if (elgg_get_current_route_name() !== 'action:useradd') {
			// only add fields during useradd action
			return;
		}
		
		$custom_profile_fields = get_input('custom_profile_fields');
		if (!is_array($custom_profile_fields)) {
			return;
		}
			
		/* @var \ElggUser $user */
		$user = $event->getObject();
		
		$user_default_access = elgg_get_default_access($user);
		
		foreach ($custom_profile_fields as $shortname => $value) {
			if (!empty($value) || $value === 0) {
				$user->setProfileData($shortname, $value, $user_default_access);
			}
		}
	}
	
	/**
	 * Validates the register action
	 *
	 * @param \Elgg\Request $request request
	 * @return void|\Elgg\Http\OkResponse
	 */
	public static function validateRegisterAction(\Elgg\Request $request) {
		elgg_make_sticky_form('register');
		elgg_make_sticky_form('profile_manager_register');
		
		$valid_icon = self::validateRegisterProfileIcon($request);
		if ($valid_icon instanceof OkResponse) {
			return $valid_icon;
		}
		
		$valid_terms = self::validateRegisterTerms($request);
		if ($valid_terms instanceof OkResponse) {
			return $valid_terms;
		}
	
		// generate username
		if (empty(get_input('username')) && (elgg_get_plugin_setting('generate_username_from_email', 'profile_manager') == 'yes')) {
			set_input('username', self::generateUsernameFromEmail(get_input('email')));
		}
	}
	
	/**
	 * Validates the existence of a required profile icon when a user registers
	 *
	 * @param \Elgg\Request $request request
	 * @return \Elgg\Http\OkResponse
	 */
	protected static function validateRegisterProfileIcon(\Elgg\Request $request) {
		
		$profile_icon = elgg_get_plugin_setting('profile_icon_on_register', 'profile_manager');
		
		if ($profile_icon !== 'yes') {
			return;
		}
		
		$file = elgg_get_uploaded_file('profile_icon', false);
		
		if (empty($file)) {
			return elgg_error_response(elgg_echo('profile_manager:register_pre_check:missing', ['profile_icon']));
		}
		
		if (!$file->isValid()) {
			return elgg_error_response(elgg_echo('profile_manager:register_pre_check:profile_icon:error'));
		}
	
		// test if we can handle the image
		if (strpos($file->getMimeType(), 'image/') !== 0) {
			return elgg_error_response(elgg_echo('profile_manager:register_pre_check:profile_icon:nosupportedimage'));
		}
	}
	
	/**
	 * Validates if terms are required to be accepted when a user registers
	 *
	 * @param \Elgg\Request $request request
	 * @return \Elgg\Http\OkResponse
	 */
	protected static function validateRegisterTerms(\Elgg\Request $request) {
		
		$terms = elgg_get_plugin_setting('registration_terms', 'profile_manager');
		
		if (empty($terms)) {
			return;
		}
		
		if (get_input('accept_terms') === 'yes') {
			return;
		}
		
		return elgg_error_response(elgg_echo('profile_manager:register_pre_check:terms'));
	}
	
	/**
	 * Validates if required fields are submitted on the user registration form
	 *
	 * @param \Elgg\Request $request request
	 * @return \Elgg\Http\OkResponse
	 */
	protected static function validateRegisterRequiredFields(\Elgg\Request $request) {

		$profile_type_guid = get_input('custom_profile_fields_custom_profile_type', false);
		$categorized_fields = profile_manager_get_categorized_fields(null, true, true, true, $profile_type_guid);
		
		$fields = elgg_extract('fields', $categorized_fields);
		$categories = elgg_extract('categories', $categorized_fields);
		if (empty($categories)) {
			return;
		}
		
		foreach ($categories as $cat_guid => $cat) {
			$cat_fields = elgg_extract($cat_guid, $fields, []);
			foreach ($cat_fields as $field) {
				if ($field->show_on_register !== 'yes' || $field->mandatory !== 'yes') {
					continue;
				}
				
				$value = get_input("custom_profile_fields_{$field->metadata_name}");
				if (!empty($value)) {
					continue;
				}
				
				return elgg_error_response(elgg_echo('profile_manager:register_pre_check:missing', [$field->getDisplayName()]));
			}
		}
	}
	
	/**
	 * Generates username based on emailaddress
	 *
	 * @param string $email Email address
	 *
	 * @return false|string
	 */
	protected static function generateUsernameFromEmail($email) {
		if (empty($email) || !elgg_is_valid_email((string) $email)) {
			return false;
		}
		
		list($username) = explode('@', $email);
		
		// strip unsupported chars from the usernam
		// using same blacklist as in validate_username() function
		// not using a preg_replace as otherwise the event can not be used (as the syntax is different)
		$blacklist = '\'/\\"*& ?#%^(){}[]~?<>;|¬`@+=';
		$blacklist = elgg_trigger_event_results('username:character_blacklist', 'user', ['blacklist' => $blacklist], $blacklist);
		$blacklist = str_split($blacklist);
		
		foreach ($blacklist as $unwanted_character) {
			$username = str_replace($unwanted_character, '', $username);
		}
		
		// check if minimal length is matched
		$min_length = elgg_get_config('minusername') ?: 4;
		if ($min_length) {
			$username = str_pad($username, $min_length, 0);
		}
	
		return elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use ($username) {
			// check if username is unique
			$original_username = $username;
			
			$i = 1;
			while (elgg_get_user_by_username($username)) {
				$username = $original_username . $i;
				$i++;
			}
			
			return $username;
		});
	}
}
