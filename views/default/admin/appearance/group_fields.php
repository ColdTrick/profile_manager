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

elgg_require_js('profile_manager/admin');

echo elgg_view('profile_manager/admin/tabs', ['group_fields_selected' => true]);
echo elgg_view('profile_manager/group_fields/list');
echo elgg_view('profile_manager/group_fields/actions');
