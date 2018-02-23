<?php

namespace ColdTrick\ProfileManager;

use Elgg\Http\OkResponse;

/**
 * Users
 */
class Users {

	/**
	 * Changes the register form view vars so profile icons can be uploaded
	 *
 	 * @param string  $hook_name    name of the hook
	 * @param string  $entity_type  type of the hook
	 * @param unknown $return_value return value
	 * @param unknown $parameters   hook parameters
	 *
	 * @return void
	 */
	public static function registerViewVars($hook_name, $entity_type, $return_value, $parameters) {
		if (elgg_extract('action_name', $return_value) !== 'register') {
			return;
		}
		
		$return_value['enctype'] = 'multipart/form-data';
		return $return_value;
	}

	/**
	 * Saves extra user information when user registers on the site
	 *
	 * @param \Elgg\Event $event event
	 *
	 * @return void
	 */
	public static function createUserByRegister(\Elgg\Event $event) {
		$custom_profile_fields = [];
		
		$user = $event->getObject();
	
		// retrieve all field that were on the register page
		foreach ($_POST as $key => $value) {
			if (strpos($key, 'custom_profile_fields_') === 0) {
				$key = substr($key, 22);
				$custom_profile_fields[$key] = get_input("custom_profile_fields_{$key}");
			}
		}
	
		if (count($custom_profile_fields) > 0) {
			$categorized_fields = profile_manager_get_categorized_fields(null, true, true);
			$configured_fields = $categorized_fields['fields'];
	
			// set ignore access
			$ia = elgg_set_ignore_access(true);
			
			$user_default_access = get_default_access($user);
			
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
							
							$value = string_to_tag_array($value);
							
							// no need to continue this foreach
							break(2);
						}
					}
				}
				
				if (empty($value) && $value !== 0) {
					continue;
				}
				
				if (!is_array($value)) {
					$value = [$value];
				}
				foreach ($value as $interval) {
					$user->annotate("profile:$shortname", $interval, $user_default_access, $user->guid, 'text');
				}
		
				// for BC, keep storing fields in MD, but we'll read annotations only
				$user->$shortname = $value;
			}
	
			// restore ignore access
			elgg_set_ignore_access($ia);
		}
	
		if (elgg_get_uploaded_file('profile_icon')) {
			if (!$user->saveIconFromUploadedFile('profile_icon')) {
				register_error(elgg_echo('avatar:upload:fail'));
				// return false to delete the user
				return false;
			}
		}
	
		$terms = elgg_get_plugin_setting('registration_terms', 'profile_manager');
		if ($terms) {
			// already checked for acceptance in middleware
			$user->setPrivateSetting('general_terms_accepted', time());
		}
	
		elgg_clear_sticky_form('profile_manager_register');
	}

	/**
	 * Saves extra user information when user is created with admin useradd form
	 *
	 * @param \Elgg\Event $event event
	 *
	 * @return void
	 */
	public static function createUserByAdmin(\Elgg\Event $event) {
		
		$user = $event->getObject();
		
		$custom_profile_fields = get_input('custom_profile_fields');
		
		if (!is_array($custom_profile_fields)) {
			return;
		}
		
		$user_default_access = get_default_access($user);
		
		foreach ($custom_profile_fields as $shortname => $value) {
			if (!empty($value) || $value === 0) {
				if (!is_array($value)) {
					$value = [$value];
				}
				foreach ($value as $interval) {
					$user->annotate("profile:$shortname", $interval, $user_default_access, $user->guid, 'text');
				}
		
				// for BC, keep storing fields in MD, but we'll read annotations only
				$user->$shortname = $value;
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
	 * Adds a river event when a user is created
	 *
	 * @param \Elgg\Event $event event
	 *
	 * @return void
	 */
	public static function createUserRiverItem(\Elgg\Event $event) {
		
		$enable_river_event = elgg_get_plugin_setting('enable_site_join_river_event', 'profile_manager');
		if ($enable_river_event == 'no') {
			return;
		}

		elgg_create_river_item([
			'action_type' => 'join',
			'subject_guid' => $event->getObject()->guid,
			'object_guid' => elgg_get_site_entity()->guid,
		]);
	}
	
	/**
	 * Generates username based on emailaddress
	 *
	 * @param string $email Email address
	 *
	 * @return false|string
	 */
	protected static function generateUsernameFromEmail($email) {
		if (empty($email) || !is_email_address($email)) {
			return false;
		}
		
		list($username) = explode('@', $email);
		
		// strip unsupported chars from the usernam
		// using same blacklist as in validate_username() function
		// not using a preg_replace as otherwise the hook can not be used (as the syntax is different)
		$blacklist = '\'/\\"*& ?#%^(){}[]~?<>;|¬`@+=';
		$blacklist = elgg_trigger_plugin_hook('username:character_blacklist', 'user', ['blacklist' => $blacklist], $blacklist);
		$blacklist = str_split($blacklist);
		
		foreach ($blacklist as $unwanted_character) {
			$username = str_replace($unwanted_character, '', $username);
		}
		
		// check if minimal length is matched
		$min_length = elgg_get_config('minusername') ?: 4;
		if ($min_length) {
			$username = str_pad($username, $min_length, 0);
		}
	
		// show hidden entities (unvalidated users)
		$hidden = access_show_hidden_entities(true);
		
		// check if username is unique
		$original_username = $username;
		
		$i = 1;
		while (get_user_by_username($username)) {
			$username = $original_username . $i;
			$i++;
		}
		
		// restore hidden entities
		access_show_hidden_entities($hidden);
		
		return $username;
	}
}
