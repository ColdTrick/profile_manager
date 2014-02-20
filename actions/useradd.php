<?php
/**
 * Elgg add action
 *
 * @package Elgg
 * @subpackage Core
 */

elgg_make_sticky_form('useradd');

// Get variables
$username = get_input('username');
$password = get_input('password');
$password2 = get_input('password2');
$email = get_input('email');
$name = get_input('name');

$admin = get_input('admin');
if (is_array($admin)) {
	$admin = $admin[0];
}

$notify = get_input('notify', false);
if (is_array($notify)) {
	$notify = $notify[0];
}

$use_default_access = get_input('use_default_access', false);
if (is_array($use_default_access)) {
	$use_default_access = $use_default_access[0];
}

$custom_profile_fields = get_input("custom_profile_fields");

// For now, just try and register the user
try {
	$guid = register_user($username, $password, $name, $email, TRUE);

	if (((trim($password) != "") && (strcmp($password, $password2) == 0)) && ($guid)) {
		$new_user = get_entity($guid);
		if (($guid) && ($admin)) {
			$new_user->makeAdmin();
		}

		elgg_clear_sticky_form('useradd');

		$new_user->admin_created = TRUE;
		// @todo ugh, saving a guid as metadata!
		$new_user->created_by_guid = elgg_get_logged_in_user_guid();

		$subject = elgg_echo('useradd:subject');
		$body = elgg_echo('useradd:body', array(
			$name,
			elgg_get_site_entity()->name,
			elgg_get_site_entity()->url,
			$username,
			$password,
		));
		
		if (!empty($notify)) {
			notify_user($new_user->guid, elgg_get_site_entity()->guid, $subject, $body);
		}
		
		// add all optional extra userdata
		if (is_array($custom_profile_fields)) {
			foreach ($custom_profile_fields as $metadata_name => $metadata_value) {
				if (!empty($metadata_value) || $metadata_value === 0) {
					if (!empty($use_default_access)) {
						// use create_metadata to listen to ACCESS_DEFAULT
						if (is_array($metadata_value)) {
							$i = 0;
							foreach ($metadata_value as $interval) {
								$i++;
								if ($i == 1) {
									$multiple = false;
								} else {
									$multiple = true;
								}
								create_metadata($new_user->guid, $metadata_name, $interval, 'text', $new_user->guid, get_default_access($new_user), $multiple);
							}
						} else {
							create_metadata($new_user->guid, $metadata_name, $metadata_value, 'text', $new_user->guid, get_default_access($new_user));
						}
					} else {
						$new_user->$metadata_name = $metadata_value;
					}
				}
			}
		}

		system_message(elgg_echo("adduser:ok", array(elgg_get_site_entity()->name)));
	} else {
		register_error(elgg_echo("adduser:bad"));
	}
} catch (RegistrationException $r) {
	register_error($r->getMessage());
}

forward(REFERER);
