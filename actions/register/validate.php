<?php
/**
* Profile Manager
*
* Action to validate register form data
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$result = array();
$field = get_input("name");

switch ($field) {
	case "username":
		// check username
		$result["name"] = "username";
		
		if ($username = get_input("username")) {
			$result["status"] = true;
		
			try {
				if (validate_username($username)) {
					$hidden = access_get_show_hidden_status();
					access_show_hidden_entities(true);
		
					if (get_user_by_username($username)) {
						$result["status"] = false;
						$result["text"] = elgg_echo("registration:userexists");
					}
		
					access_show_hidden_entities($hidden);
				} else {
					$result["status"] = false;
					$result["text"] = elgg_echo("registration:usernamenotvalid");
				}
			} catch (Exception $e) {
				$result["status"] = false;
				$result["text"] = $e->getMessage();
			}
		}
		break;
	case "email":
		// check email
		$result["name"] = "email";
		if ($email = get_input("email")) {
			
			$result["status"] = true;
		
			try {
				if (validate_email_address($email)) {
					$hidden = access_get_show_hidden_status();
					access_show_hidden_entities(true);
		
					if (get_user_by_email($email)) {
						$result["status"] = false;
						$result["text"] = elgg_echo("registration:dupeemail");
					}
		
					access_show_hidden_entities($hidden);
				} else {
					$result["status"] = false;
					$result["text"] = elgg_echo("registration:notemail");
				}
			} catch (Exception $e) {
				$result["status"] = false;
				$result["text"] = $e->getMessage();
			}
		}
		break;
	case "password":
		// check password
		$result["name"] = "password";
		if ($password = get_input("password", null, false)) {
			
			$result["status"] = true;
		
			try {
				if (!validate_password($password)) {
					$result["status"] = false;
					$result["text"] = elgg_echo("registration:passwordnotvalid");
				}
			} catch (Exception $e) {
				$result["status"] = false;
				$result["text"] = $e->getMessage();
			}
		}
		break;
}

// return results
echo json_encode($result);
