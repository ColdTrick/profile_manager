<?php
/**
* Profile Manager
*
* Group Fields actions
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$header = '<h3>';
$header .= elgg_echo('profile_manager:actions:title');
$header .= elgg_format_element('span', ['class' => 'custom_fields_more_info', 'id' => 'more_info_actions']);
$header .= '</h3>';

$body = '<div class="pvm">';
$body .= elgg_view("output/url", array("text" => elgg_echo("reset"), "title" => elgg_echo("profile_manager:actions:reset:description"), "href" => "action/profile_manager/reset?type=group", "confirm" => elgg_echo("profile_manager:actions:reset:confirm"), "class" => "elgg-button elgg-button-action"));
$body .= elgg_view("output/url", array("text" => elgg_echo("profile_manager:actions:import:from_default"), "title" => elgg_echo("profile_manager:actions:import:from_default:description"), "href" => "action/profile_manager/importFromDefault?type=group", "confirm" => elgg_echo("profile_manager:actions:import:from_default:confirm"), "class" => "elgg-button elgg-button-action"));
$body .= elgg_view("output/url", array("title" => elgg_echo("profile_manager:actions:export:description"),"text" => elgg_echo("export"), "href" => "admin/groups/export", "class" => "elgg-button elgg-button-action"));
$body .= elgg_view("output/url", array("text" => elgg_echo("profile_manager:actions:configuration:backup"), "href" => "action/profile_manager/configuration/backup?fieldtype=" . CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE, "confirm" => elgg_echo("profile_manager:actions:configuration:backup:description"), "class" => "elgg-button elgg-button-action"));
$body .= elgg_view("output/url", array("text" => elgg_echo("profile_manager:actions:configuration:restore"), "onclick" => "$('#restoreForm').toggle();", "class" => "elgg-button elgg-button-action"));
		
$form_body = "<div class='mtm'>" . elgg_echo("profile_manager:actions:configuration:restore:description") . "</div>";
$form_body .= elgg_view("input/file", array("name" => "restoreFile"));
$form_body .= elgg_view("input/submit", array("value" => elgg_echo("profile_manager:actions:configuration:restore:upload")));

$body .= elgg_view("input/form", array("action" => "action/profile_manager/configuration/restore?fieldtype=" . CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE, "id" => "restoreForm", "body" => $form_body, "enctype" => "multipart/form-data", 'class' => 'hidden'));
$body .= '</div>';

$footer = elgg_format_element('div', ['class' => 'hidden', 'id' => 'text_more_info_actions'], elgg_echo("profile_manager:tooltips:actions"));

echo elgg_view_module('inline', null, $body, ['header' => $header, 'footer' => $footer]);
