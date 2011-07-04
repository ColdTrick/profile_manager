<?php
	/**
	 * Action to request a new password.
	 *
	 * @package Elgg
	 * @subpackage Core
	 */
	
	$email = get_input("email");
	
	$access_status = access_get_show_hidden_status();
	access_show_hidden_entities(true);
	
	if(($users = get_user_by_email($email)) && (count($users) == 1)) {
		$user = $users[0];
		
		if ($user->validated) {
			if (send_new_password_request($user->getGUID())) {
				system_message(elgg_echo('user:password:resetreq:success'));
			} else {
				register_error(elgg_echo('user:password:resetreq:fail'));
			}
		} elseif (!trigger_plugin_hook('unvalidated_requestnewpassword','user',array('entity'=>$user))) {
			// if plugins have not registered an action, the default action is to
			// trigger the validation event again and assume that the validation
			// event will display an appropriate message
			trigger_elgg_event('validate', 'user', $user);
		}
	} else {
		register_error(sprintf(elgg_echo('user:username:notfound'), $email));
	}
	
	access_show_hidden_entities($access_status);
	
	forward();
?>