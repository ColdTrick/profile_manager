<?php

namespace ColdTrick\ProfileManager;

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
	 * Adds uploaded files to your profile
	 *
	 * @param string   $event       Event name
	 * @param string   $object_type Event type
	 * @param ElggUser $user        User being updated
	 *
	 * @return void
	 */
	public static function updateProfile($event, $object_type, $user) {
		if (!elgg_instanceof($user, 'user')) {
			return;
		}

		// upload a file to your profile
		$accesslevel = get_input('accesslevel');
		if (!is_array($accesslevel)) {
			$accesslevel = [];
		}

		$configured_fields = elgg_get_entities_from_metadata([
			'type' => 'object',
			'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
			'limit' => false,
			'metadata_name_value_pairs' => [
				'name' => 'metadata_type',
				'value' => 'pm_file',
			],
		]);

		if (empty($configured_fields)) {
			return;
		}
		
		foreach ($configured_fields as $field) {
			// check for uploaded files
			$metadata_name = $field->metadata_name;
			$current_file_guid = $user->$metadata_name;

			if (isset($accesslevel[$metadata_name])) {
				$access_id = (int) $accesslevel[$metadata_name];
			} else {
				// this should never be executed since the access level should always be set
				$access_id = ACCESS_PRIVATE;
			}

			if (isset($_FILES[$metadata_name]) && $_FILES[$metadata_name]['error'] == 0) {
				// uploaded file exists so, save it to an ElggFile object
				// use current_file_guid to overwrite previously uploaded files
				$filehandler = new ElggFile($current_file_guid);
				$filehandler->owner_guid = $user->getGUID();
				$filehandler->container_guid = $user->getGUID();
				$filehandler->subtype = "file";
				$filehandler->access_id = $access_id;
				$filehandler->title = $field->getTitle();
					
				$filehandler->setFilename("profile_manager/" .  $_FILES[$metadata_name]["name"]);
				$filehandler->setMimeType($_FILES[$metadata_name]["type"]);
					
				$filehandler->open("write");
				$filehandler->write(get_uploaded_file($metadata_name));
				$filehandler->close();
					
				if ($filehandler->save()) {
					$filehandler->profile_manager_metadata_name = $metadata_name; // used to retrieve user file when deleting
					$filehandler->originalfilename = $_FILES[$metadata_name]["name"];
						
					create_metadata($user->guid, $metadata_name, $filehandler->getGUID(), 'text', $user->guid, $access_id);
				}
			} else {
				// if file not uploaded should it be deleted???
				if (empty($current_file_guid)) {
					// find the previously uploaded file and if exists... delete it
					$files = elgg_get_entities_from_metadata([
						"type" => "object",
						"subtype" => "file",
						"owner_guid" => $user->getGUID(),
						"limit" => 1,
						"metadata_name_value_pairs" => [
							"name" => "profile_manager_metadata_name",
							"value" => $metadata_name,
						],
					]);
					
					if ($files) {
						$file = $files[0];
						$file->delete();
					}
				} else {
					if ($file = get_entity($current_file_guid)) {
						// maybe we need to update the access id
						$file->access_id = $access_id;
						$file->save();
					}
				}
			}
		}
		// update profile completeness
		profile_manager_profile_completeness($user);
	}
	
	/**
	 * Function to add custom profile fields to user on register
	 *
	 * @param string   $event       Event name
	 * @param string   $object_type Event type
	 * @param ElggUser $object      User being created
	 *
	 * @return array
	 */
	public static function create($event, $object_type, $object) {
		$custom_profile_fields = [];
	
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
			$ia = elgg_get_ignore_access();
			elgg_set_ignore_access(true);
	
			foreach ($custom_profile_fields as $shortname => $value) {
					
				// determine if $value should be an array
				if (!is_array($value) && !empty($configured_fields)) {
					// only do something if it not is already an array
					foreach ($configured_fields as $configured_field) {
						if ($configured_field->metadata_name == $shortname) {
							if ($configured_field->metadata_type == 'tags' || $configured_field->output_as_tags == 'yes') {
								$value = string_to_tag_array($value);
								// no need to continue this foreach
								break;
							}
						}
					}
				}
					
				// use create_metadata to listen to default access
				if (is_array($value)) {
					$i = 0;
					foreach ($value as $interval) {
						$i++;
						if ($i == 1) {
							$multiple = false;
						} else {
							$multiple = true;
						}
						create_metadata($object->guid, $shortname, $interval, 'text', $object->guid, get_default_access($object), $multiple);
					}
				} else {
					create_metadata($object->guid, $shortname, $value, 'text', $object->guid, get_default_access($object));
				}
			}
	
			// restore ignore access
			elgg_set_ignore_access($ia);
		}
	
		if (isset($_FILES['profile_icon'])) {
			if (!profile_manager_add_profile_icon($object)) {
				// return false to delete the user
				return false;
			}
		}
	
		$terms = elgg_get_plugin_setting('registration_terms', 'profile_manager');
		if ($terms) {
			$object->setPrivateSetting('general_terms_accepted', time());
		}
	
		elgg_clear_sticky_form('profile_manager_register');
	}
	
	/**
	 * Function to check if custom fields on register have been filled (if required)
	 * Also generates a username if needed
	 *
	 * @param string  $hook_name    name of the hook
	 * @param string  $entity_type  type of the hook
	 * @param unknown $return_value return value
	 * @param unknown $parameters   hook parameters
	 *
	 * @return void
	 */
	public static function actionRegister($hook_name, $entity_type, $return_value, $parameters) {
	
		elgg_make_sticky_form('register');
		elgg_make_sticky_form('profile_manager_register');
	
		// validate mandatory profile fields
		$profile_icon = elgg_get_plugin_setting('profile_icon_on_register', 'profile_manager');
	
		// general terms
		$terms = elgg_get_plugin_setting('registration_terms', 'profile_manager');
	
		// new
		$profile_type_guid = get_input('custom_profile_fields_custom_profile_type', false);
		$fields = profile_manager_get_categorized_fields(null, true, true, true, $profile_type_guid);
		$required_fields = [];
	
		if (!empty($fields['categories'])) {
			foreach ($fields['categories'] as $cat_guid => $cat) {
				$cat_fields = $fields['fields'][$cat_guid];
				foreach ($cat_fields as $field) {
					if ($field->show_on_register == 'yes' && $field->mandatory == 'yes') {
						$required_fields[] = $field;
					}
				}
			}
		}
	
		if ($terms || $required_fields || $profile_icon == 'yes') {
	
			$custom_profile_fields = [];
	
			foreach ($_POST as $key => $value) {
				if (strpos($key, 'custom_profile_fields_') == 0) {
					$key = substr($key, 22);
					$custom_profile_fields[$key] = $value;
				}
			}
	
			foreach ($required_fields as $entity) {
				$passed_value = $custom_profile_fields[$entity->metadata_name];
				if (is_array($passed_value)) {
					if (!count($passed_value)) {
						register_error(elgg_echo('profile_manager:register_pre_check:missing', [$entity->getTitle()]));
						forward(REFERER);
					}
				} else {
					$passed_value = trim($passed_value);
					if (strlen($passed_value) < 1) {
						register_error(elgg_echo('profile_manager:register_pre_check:missing', [$entity->getTitle()]));
						forward(REFERER);
					}
				}
			}
	
			if ($profile_icon == 'yes') {
				$profile_icon = $_FILES['profile_icon'];
	
				$error = false;
				if (empty($profile_icon['name'])) {
					register_error(elgg_echo('profile_manager:register_pre_check:missing', ['profile_icon']));
					$error = true;
				} elseif ($profile_icon['error'] != 0) {
					register_error(elgg_echo('profile_manager:register_pre_check:profile_icon:error'));
					$error = true;
				} else {
					// test if we can handle the image
					$image = get_resized_image_from_uploaded_file('profile_icon', '10', '10', true, false);
					if (!$image) {
						register_error(elgg_echo('profile_manager:register_pre_check:profile_icon:nosupportedimage'));
						$error = true;
					}
				}
	
				if ($error) {
					forward(REFERER);
				}
			}
	
			if ($terms) {
				$terms_accepted = get_input('accept_terms');
				if ($terms_accepted !== 'yes') {
					register_error(elgg_echo('profile_manager:register_pre_check:terms'));
					forward(REFERER);
				}
			}
		}
	
		// generate username
		$username = get_input('username');
		$email = get_input('email');
		if (empty($username) && (elgg_get_plugin_setting('generate_username_from_email', 'profile_manager') == 'yes')) {
			set_input('username', self::generateUsernameFromEmail($email));
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
	
	/**
	 * If possible change the username of a user
	 *
	 * @param string  $hook_name    name of the hook
	 * @param string  $entity_type  type of the hook
	 * @param unknown $return_value return value
	 * @param unknown $parameters   hook parameters
	 *
	 * @return void
	 */
	public static function usernameChange($hook_name, $entity_type, $return_value, $parameters) {
		$user_guid = (int) get_input('guid');
		$new_username = get_input('username');
	
		if (empty($user_guid) || empty($new_username)) {
			return;
		}
		
		$enable_username_change = elgg_get_plugin_setting('enable_username_change', 'profile_manager', 'no');
		if ($enable_username_change == 'no' || ($enable_username_change == 'admin' && !elgg_is_admin_logged_in())) {
			return;
		}
		
		if (!self::validateUsername($new_username)) {
			return;
		}
		
		$user = get_user($user_guid);
		if (empty($user)) {
			return;
		}

		if (!$user->canEdit()) {
			return;
		}
		
		if ($user->username == $new_username) {
			return;
		}
		
		$user->username = $new_username;
		if ($user->save()) {
			elgg_register_plugin_hook_handler('forward', 'system', '\ColdTrick\ProfileManager\Users::usernameChangeForward');

			system_message(elgg_echo('profile_manager:action:username:change:succes'));
		}
	}
	
	/**
	 * Validates a username
	 *
	 * @param string $username Username
	 *
	 * @return boolean
	 */
	protected static function validateUsername($username) {
		$result = false;
		if (empty($username)) {
			return $result;
		}
		
		// make sure we can check every user (even unvalidated)
		$access_status = access_show_hidden_entities(true);
		
		// check if username exists
		try {
			if (validate_username($username)) {
				if (!get_user_by_username($username)) {
					$result = true;
				}
			}
		} catch (Exception $e) {
		}
		
		// restore access settings
		access_show_hidden_entities($access_status);
		
		return $result;
	}
	
	/**
	 * Directs user to correct settings links after changing a username
	 *
	 * @param string  $hook_name    name of the hook
	 * @param string  $entity_type  type of the hook
	 * @param unknown $return_value return value
	 * @param unknown $parameters   hook parameters
	 *
	 * @return string
	 */
	public static function usernameChangeForward($hook_name, $entity_type, $return_value, $parameters) {
		$username = get_input('username');
		if (!empty($username)) {
			return elgg_normalize_url("settings/user/{$username}");
		}
	}
}