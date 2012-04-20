<?php

$last_login = strtotime("-3 months");

$date = sanitise_int(get_input("last_login"));
if($date > 0){
	$last_login = $date;
}

$form_body = elgg_echo("profile_manager:admin:users:inactive:last_login") . ": ";
$form_body .= elgg_view("input/date", array("name" => "last_login", "value" => $last_login, "timestamp" => true));
$form_body .= elgg_view("input/submit", array("value" => elgg_echo("search")));

echo elgg_view("input/form", array("disable_security" => true, "action" => "/admin/users/inactive", "method" => "GET", "body" => $form_body));

$dbprefix = elgg_get_config("dbprefix");

$limit =  max((int) get_input("limit", 50), 0);
$offset = sanitise_int(get_input("offset", 0), false);

$options = array(
	"type" => "user",
	"limit" => $limit,
	"offset" => $offset,
	"relationship" => "member_of_site",
	"relationship_guid" => elgg_get_site_entity()->getGUID(),
	"inverse_relationship" => true,
	"site_guids" => false,
	"joins" => array("JOIN " . $dbprefix . "users_entity ue ON e.guid = ue.guid"),
	"wheres" => array("ue.last_login <= " . $last_login),
	"order_by" => "ue.last_login"
	);

$users = elgg_get_entities_from_relationship($options);

if(!empty($users)){
	$content = "<table class='elgg-table'>";
	$content .= "<tr>";
	$content .= "<th>" . elgg_echo("user") . "</th>";
	$content .= "<th>" . elgg_echo("usersettings:statistics:label:lastlogin") . "</th>";
	$content .= "<th>" . elgg_echo("banned") . "</th>";
	$content .= "</tr>";
	
	foreach($users as $user){
		$content .= "<tr>";
		$content .= "<td>" . elgg_view("output/url", array("text" => $user->name, "href" => $user->getURL())) . "</td>";
		$last_login = $user->last_login;
		if(empty($last_login)){
			$content .= "<td>" . elgg_echo("profile_manager:admin:users:inactive:never") . "</td>";
		} else {
			$content .= "<td>" . elgg_view_friendly_time($last_login) . "</td>";
		}
		$content .= "<td>" . elgg_echo("option:" . $user->banned) . "</td>";
		$content .= "</tr>";
	}
	
	$content .= "</table>";
	
	$options["count"] = true;
	$count = elgg_get_entities_from_relationship($options);
	
	$content .= elgg_view("navigation/pagination", array("offset" => $offset, "limit" => $limit, "count" => $count));
	
	$download_link = elgg_add_action_tokens_to_url("/action/profile_manager/users/export_inactive?last_login=" . $last_login);
	
	$content .= "<br />" . elgg_view("input/button", array("value" => elgg_echo("profile_manager:admin:users:inactive:download"), "onclick" => "document.location.href='" . $download_link . "'", "class" => "elgg-button-action"));
	
} else {
	$content = elgg_echo("notfound");
}

echo elgg_view_module("inline", elgg_echo("profile_manager:admin:users:inactive:list"), $content);