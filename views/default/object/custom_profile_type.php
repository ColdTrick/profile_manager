<?php
/**
* Profile Manager
*
* Object view of a custom profile field type
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$entity = $vars["entity"];

// get title
$title = $entity->getTitle();
	
echo "<div class='custom_profile_type' id='custom_profile_type_" . $entity->guid . "'>";
echo $title;

// edit link
echo elgg_view("output/url", array(
	"href" => "ajax/view/forms/profile_manager/type?guid=" .  $entity->guid,
	"class" => "elgg-lightbox",
	"title" => elgg_echo("edit"),
	"text" => elgg_view_icon("settings-alt")
));

// delete link
echo elgg_view("output/url", array(
	"href" => "action/profile_manager/profile_types/delete?guid=" . $entity->guid,
	"title" => elgg_echo("delete"),
	"text" => elgg_view_icon("delete"),
	"confirm" => elgg_echo("profile_manager:profile_types:delete:confirm")
));

echo "</div>";
