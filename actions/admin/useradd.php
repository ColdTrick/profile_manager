<?php

	/**
	 * Elgg add action
	 * 
	 * @package Elgg
	 * @subpackage Core
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */

	admin_gatekeeper(); // Only admins can make someone an admin
	
	// Get variables
	global $CONFIG;
	$username = get_input('username');
	$password = get_input('password');
	$password2 = get_input('password2');
	$email = get_input('email');
	$name = get_input('name');
	
	$admin = get_input('admin');
	if (is_array($admin)) $admin = $admin[0];
	
	$notify = get_input('notify', false);
	if (is_array($notify)) $notify = $notify[0];
	
	$use_default_access = get_input('use_default_access', false);
	if (is_array($use_default_access)) $use_default_access = $use_default_access[0];
	
	$mark_as_validated = get_input('mark_as_validated', false);
	if (is_array($mark_as_validated)) $mark_as_validated = $mark_as_validated[0];
	
	
	$custom_profile_fields = get_input("custom_profile_fields"); 
	// For now, just try and register the user
	try {
		if (
			(
				(trim($password)!="") &&
				(strcmp($password, $password2)==0) 
			) &&
			($guid = register_user($username, $password, $name, $email, true))
		) {
			$new_user = get_entity($guid);
			
			
			if (($guid) && ($admin)){
				$new_user->makeAdmin();
			}
			
			$new_user->admin_created = true;
			if($mark_as_validated){
				set_user_validation_status($new_user->getGUID(), true, "profile_manager");
			} else {
				$new_user->disable("new_user", false);
				access_show_hidden_entities(true); // this is needed otherwise setting metadata would fail
			}
			
			if(!empty($notify)){
				notify_user($new_user->guid, $CONFIG->site->guid, elgg_echo('useradd:subject'), sprintf(elgg_echo('useradd:body'), $name, $CONFIG->site->name, $CONFIG->site->url, $username, $password));
			}
			
			// add all optional extra userdata
			if(is_array($custom_profile_fields)){
				foreach($custom_profile_fields as $metadata_name => $metadata_value){
					if(!empty($metadata_value) || $metadata_value === 0){
						if(!empty($use_default_access)){
							// use create_metadata to listen to ACCESS_DEFAULT
							if (is_array($metadata_value)) {
								$i = 0;
								foreach($metadata_value as $interval) {
									$i++;
									if ($i == 1) { $multiple = false; } else { $multiple = true; }
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
			
			system_message(sprintf(elgg_echo("adduser:ok"),$CONFIG->sitename));
		} else {
			register_error(elgg_echo("adduser:bad"));
		}
	} catch (RegistrationException $r) {
		register_error($r->getMessage());
	}

	forward($_SERVER['HTTP_REFERER']);
	exit;
?>