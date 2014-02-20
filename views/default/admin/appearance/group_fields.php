<?php
/**
* Profile Manager
*
* Group Profile Fields Config page
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$fields = elgg_view("profile_manager/group_fields/list");
$actions = elgg_view("profile_manager/group_fields/actions");

$page_data = $fields . $actions;

echo elgg_view("profile_manager/admin/tabs", array("group_fields_selected" => true));
echo $page_data;
