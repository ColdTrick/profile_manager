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

$title = elgg_echo('profile_manager:actions:title');
$title .= elgg_view('output/pm_hint', [
	'id' => 'more_info_actions',
	'text' => elgg_echo('profile_manager:tooltips:actions'),
]);
$header = elgg_format_element('h3', [], $title);

$buttonbank = elgg_view('output/url', [
	'text' => elgg_echo('reset'),
	'title' => elgg_echo('profile_manager:actions:reset:description'),
	'href' => 'action/profile_manager/reset?type=group',
	'confirm' => elgg_echo('profile_manager:actions:reset:confirm'),
	'class' => 'elgg-button elgg-button-action',
	'is_action' => true,
]);
$buttonbank .= elgg_view('output/url', [
	'text' => elgg_echo('profile_manager:actions:import:from_default'),
	'title' => elgg_echo('profile_manager:actions:import:from_default:description'),
	'href' => 'action/profile_manager/importFromDefault?type=group',
	'confirm' => elgg_echo('profile_manager:actions:import:from_default:confirm'),
	'class' => 'elgg-button elgg-button-action',
	'is_action' => true,
]);
$buttonbank .= elgg_view('output/url', [
	'title' => elgg_echo('profile_manager:actions:export:description'),
	'text' => elgg_echo('export'),
	'href' => 'admin/groups/export',
	'class' => 'elgg-button elgg-button-action',
]);
$buttonbank .= elgg_view('output/url', [
	'text' => elgg_echo('profile_manager:actions:configuration:backup'),
	'href' => 'action/profile_manager/configuration/backup?fieldtype=' . CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE,
	'confirm' => elgg_echo('profile_manager:actions:configuration:backup:description'),
	'class' => 'elgg-button elgg-button-action',
	'is_action' => true,
]);
$buttonbank .= elgg_view('output/url', [
	'text' => elgg_echo('profile_manager:actions:configuration:restore'),
	'href' => '#restoreForm',
	'rel' => 'toggle',
	'class' => 'elgg-button elgg-button-action',
]);
		
$form_body = elgg_format_element('div', ['class' => 'mtm'], elgg_echo('profile_manager:actions:configuration:restore:description'));
$form_body .= elgg_view('input/file', ['name' => 'restoreFile']);
$form_body .= elgg_view('input/submit', ['value' => elgg_echo('profile_manager:actions:configuration:restore:upload')]);

$form = elgg_view('input/form', [
	'action' => 'action/profile_manager/configuration/restore?fieldtype=' . CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE,
	'id' => 'restoreForm',
	'body' => $form_body,
	'enctype' => 'multipart/form-data',
	'class' => 'hidden',
]);

$body = elgg_format_element('div', ['class' => 'pvm'], $buttonbank . $form);

echo elgg_view_module('inline', null, $body, ['header' => $header]);
