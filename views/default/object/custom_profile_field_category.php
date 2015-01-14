<?php
/**
* Profile Manager
*
* Object view of a custom profile field category
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$entity = $vars["entity"];

// get title
$title = $entity->getTitle();
	
echo "<div class='custom_fields_category' id='custom_profile_field_category_" . $entity->guid . "'>";
echo elgg_view_icon("drag-arrow");

// filter link
echo elgg_view("output/url", array(
	"href" => "javascript:elgg.profile_manager.filter_custom_fields(" . $entity->guid . ")",
	"text" => $title
));

// edit link
echo elgg_view("output/url", array(
	"href" => "ajax/view/forms/profile_manager/category?guid=" . $entity->guid,
	"class" => "elgg-lightbox",
	"title" => elgg_echo("edit"),
	"text" => elgg_view_icon("settings-alt")
));

// delete link
echo elgg_view("output/url", array(
	"href" => "action/profile_manager/categories/delete?guid=" . $entity->guid,
	"title" => elgg_echo("delete"),
	"text" => elgg_view_icon("delete"),
	"confirm" => elgg_echo("profile_manager:categories:delete:confirm")
));

echo "</div>";
