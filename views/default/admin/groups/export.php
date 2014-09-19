<?php
/**
* Profile Manager
*
* Export of profile fields
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

echo elgg_view("profile_manager/admin/tabs");
echo elgg_echo('profile_manager:export:description:' . CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE);

$form = elgg_view_form("profile_manager/export", array(), array("fieldtype" => CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE));

echo elgg_view_module("inline", elgg_echo("profile_manager:export:list:title"), $form);
