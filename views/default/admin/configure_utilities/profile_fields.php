<?php
/**
* Profile Manager
*
* User Profile Fields Config page
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

elgg_require_js('profile_manager/admin');

echo elgg_view('profile_manager/admin/tabs', ['profile_fields_selected' => true]);
echo elgg_view('profile_manager/profile_types/list');
echo elgg_view('profile_manager/categories/list');
echo elgg_view('profile_manager/profile_fields/list');
echo elgg_view('profile_manager/profile_fields/actions');
