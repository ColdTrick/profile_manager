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

$result = [];
$field = get_input('name');

switch ($field) {
	case 'username':
		$username = get_input('username');
		if ($username) {
			$result['status'] = true;
		
			try {
				if (validate_username($username)) {
					$hidden = access_show_hidden_entities(true);
		
					if (get_user_by_username($username)) {
						$result['status'] = false;
						$result['text'] = elgg_echo('registration:userexists');
					}
		
					access_show_hidden_entities($hidden);
				} else {
					$result['status'] = false;
					$result['text'] = elgg_echo('registration:usernamenotvalid');
				}
			} catch (Exception $e) {
				$result['status'] = false;
				$result['text'] = $e->getMessage();
			}
		}
		break;
	case 'email':
		$email = get_input('email');
		if ($email) {
			
			$result['status'] = true;
		
			try {
				if (validate_email_address($email)) {
					$hidden = access_show_hidden_entities(true);
		
					if (get_user_by_email($email)) {
						$result['status'] = false;
						$result['text'] = elgg_echo('registration:dupeemail');
					}
		
					access_show_hidden_entities($hidden);
				} else {
					$result['status'] = false;
					$result['text'] = elgg_echo('registration:notemail');
				}
			} catch (Exception $e) {
				$result['status'] = false;
				$result['text'] = $e->getMessage();
			}
		}
		break;
	case 'password':
		$password = get_input('password', null, false);
		if ($password) {
			$result['status'] = true;
		
			try {
				if (!validate_password($password)) {
					$result['status'] = false;
					$result['text'] = elgg_echo('registration:passwordnotvalid');
				}
			} catch (Exception $e) {
				$result['status'] = false;
				$result['text'] = $e->getMessage();
			}
		}
		break;
}

echo json_encode($result);
