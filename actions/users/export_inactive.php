<?php

set_time_limit(0);

$last_login = sanitise_int(get_input("last_login"), false);

if(!empty($last_login)){
	$dbprefix = elgg_get_config("dbprefix");
	
	$options = array(
		"type" => "user",
		"limit" => false,
		"relationship" => "member_of_site",
		"relationship_guid" => elgg_get_site_entity()->getGUID(),
		"inverse_relationship" => true,
		"site_guids" => false,
		"joins" => array("JOIN " . $dbprefix . "users_entity ue ON e.guid = ue.guid"),
		"wheres" => array("ue.last_login <= " . $last_login),
		"order_by" => "ue.last_login"
	);
	
	if($users = elgg_get_entities_from_relationship($options)){
		$fields = array("username", "name", "email", "last_login", "banned");
		$fielddelimiter = ",";
		// We'll be outputting a CSV
		header("Content-Type: text/plain; charset: UTF-8");
		
		// It will be called export_inactive.csv
		header('Content-Disposition: attachment; filename="export_inactive.csv"');
		
		$headers = "";
		foreach($fields as $field){
			if(!empty($headers)){
				$headers .= $fielddelimiter;
			}
			$headers .= $field;
		}
		echo $headers . PHP_EOL;
		
		foreach($users as $user){
			$row = "";
			foreach($fields as $field){
				if(!empty($row)){
					$row .= $fielddelimiter;
				}
				$row .=  $user->$field;
			}
			echo $row . PHP_EOL;
		}

		exit();
	} else {
		system_message(elgg_echo("InvalidParameterException:NoDataFound"));
		forward(REFERER);
	}
} else {
	register_error(elgg_echo("InvalidParameterException:NoDataFound"));
	forward(REFERER);
}
