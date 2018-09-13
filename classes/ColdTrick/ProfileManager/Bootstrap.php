<?php

namespace ColdTrick\ProfileManager;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritdoc}
	 */
	public function init() {
		
		require_once(self::plugin()->getPath() . '/lib/functions.php');
		
		// Extend CSS
		elgg_extend_view('css/admin', 'css/profile_manager/global.css');
		elgg_extend_view('css/admin', 'css/profile_manager/admin.css');
		elgg_extend_view('css/admin', 'jquery/multiselect.css');
		elgg_extend_view('css/elgg', 'css/profile_manager/global.css');
		elgg_extend_view('css/elgg', 'css/profile_manager/site.css');
		elgg_extend_view('css/elgg', 'jquery/multiselect.css');
		
		elgg_extend_view('forms/register', 'profile_manager/register/free_text', 400);
		elgg_extend_view('register/extend', 'profile_manager/register/fields');
		elgg_extend_view('forms/useradd', 'profile_manager/admin/useradd');
		
		// register ajax views
		elgg_register_ajax_view('forms/profile_manager/type');
		elgg_register_ajax_view('forms/profile_manager/category');
		elgg_register_ajax_view('forms/profile_manager/group_field');
		elgg_register_ajax_view('forms/profile_manager/profile_field');
		elgg_register_ajax_view('forms/profile_manager/restore_fields');
		
		// Register all custom field types
		$this->registerCustomFieldTypes();
		
		// add profile_completeness widget
		if (elgg_get_plugin_setting('enable_profile_completeness_widget', 'profile_manager') == 'yes') {
			elgg_register_widget_type([
				'id' => 'profile_completeness',
				'context' => ['profile', 'dashboard'],
			]);
		}
		
		$hooks = $this->elgg()->hooks;
		
		$hooks->registerHandler('categorized_profile_fields', 'profile_manager', '\ColdTrick\ProfileManager\ProfileFields::addAdminFields', 1000);
		$hooks->registerHandler('profile:fields', 'profile', '\ColdTrick\ProfileManager\ProfileFields::getUserFields');
		$hooks->registerHandler('profile:fields', 'group', '\ColdTrick\ProfileManager\ProfileFields::getGroupFields');
		$hooks->registerHandler('register', 'menu:page', '\ColdTrick\ProfileManager\Menus::registerAdmin');
		$hooks->registerHandler('register', 'menu:profile_fields', '\ColdTrick\ProfileManager\Menus::registerProfileFieldsActions');
		$hooks->registerHandler('view_vars', 'input/form', '\ColdTrick\ProfileManager\Users::registerViewVars');
		
		$hooks->registerHandler('action', 'useradd', function() {
			// only register createByAdmin during useradd action
			elgg_register_event_handler('create', 'user', '\ColdTrick\ProfileManager\Users::createUserByAdmin');
		});
		
		elgg_register_event_handler('create', 'user', '\ColdTrick\ProfileManager\Users::createUserByRegister');
		elgg_register_event_handler('create', 'user', '\ColdTrick\ProfileManager\Users::createUserRiverItem');
	}
	
	/**
	 * Registes all custom field types
	 *
	 * @return void
	 */
	protected function registerCustomFieldTypes() {
		// registering profile field types
		$profile_options = [
			'show_on_register' => true,
			'mandatory' => true,
			'user_editable' => true,
			'output_as_tags' => true,
			'admin_only' => true,
			'count_for_completeness' => true,
		];
		
		$location_options = $profile_options;
		unset($location_options['output_as_tags']);
		
		$dropdown_options = $profile_options;
		$dropdown_options['blank_available'] = true;
		
		$radio_options = $profile_options;
		$radio_options['blank_available'] = true;
		
		$tel_options = $profile_options;
		$tel_options['output_as_tags'] = false;
		
		$pm_rating_options = $profile_options;
		unset($pm_rating_options['output_as_tags']);
		
		$social_options = $profile_options;
		$social_options['output_as_tags'] = false;
		
		profile_manager_add_custom_field_type('custom_profile_field_types', 'text', elgg_echo('profile:field:text'), $profile_options);
		profile_manager_add_custom_field_type('custom_profile_field_types', 'longtext', elgg_echo('profile:field:longtext'), $profile_options);
		profile_manager_add_custom_field_type('custom_profile_field_types', 'tags', elgg_echo('profile:field:tags'), $profile_options);
		profile_manager_add_custom_field_type('custom_profile_field_types', 'location', elgg_echo('profile:field:location'), $location_options);
		profile_manager_add_custom_field_type('custom_profile_field_types', 'url', elgg_echo('profile:field:url'), $profile_options);
		profile_manager_add_custom_field_type('custom_profile_field_types', 'email', elgg_echo('profile:field:email'), $profile_options);
		profile_manager_add_custom_field_type('custom_profile_field_types', 'tel', elgg_echo('profile_manager:admin:options:tel'), $tel_options);
		profile_manager_add_custom_field_type('custom_profile_field_types', 'date', elgg_echo('profile:field:date'), $profile_options);
		profile_manager_add_custom_field_type('custom_profile_field_types', 'dropdown', elgg_echo('profile_manager:admin:options:dropdown'), $dropdown_options);
		profile_manager_add_custom_field_type('custom_profile_field_types', 'radio', elgg_echo('profile_manager:admin:options:radio'), $radio_options);
		profile_manager_add_custom_field_type('custom_profile_field_types', 'multiselect', elgg_echo('profile_manager:admin:options:multiselect'), $profile_options);
		profile_manager_add_custom_field_type('custom_profile_field_types', 'pm_rating', elgg_echo('profile_manager:admin:options:pm_rating'), $pm_rating_options);
		profile_manager_add_custom_field_type('custom_profile_field_types', 'pm_twitter', elgg_echo('profile_manager:admin:options:pm_twitter'), $social_options);
		profile_manager_add_custom_field_type('custom_profile_field_types', 'pm_facebook', elgg_echo('profile_manager:admin:options:pm_facebook'), $social_options);
		profile_manager_add_custom_field_type('custom_profile_field_types', 'pm_linkedin', elgg_echo('profile_manager:admin:options:pm_linkedin'), $social_options);
		
		// registering group field types
		$group_options = [
			'output_as_tags' => true,
			'admin_only' => true,
		];
		
		$dropdown_options = $group_options;
		$dropdown_options['blank_available'] = true;
		
		$radio_options = $group_options;
		$radio_options['blank_available'] = true;
		
		$location_options = $group_options;
		unset($location_options['output_as_tags']);
		
		$tel_options = $group_options;
		$tel_options['output_as_tags'] = false;
		
		profile_manager_add_custom_field_type('custom_group_field_types', 'text', elgg_echo('profile:field:text'), $group_options);
		profile_manager_add_custom_field_type('custom_group_field_types', 'longtext', elgg_echo('profile:field:longtext'), $group_options);
		profile_manager_add_custom_field_type('custom_group_field_types', 'tags', elgg_echo('profile:field:tags'), $group_options);
		profile_manager_add_custom_field_type('custom_group_field_types', 'url', elgg_echo('profile:field:url'), $group_options);
		profile_manager_add_custom_field_type('custom_group_field_types', 'email', elgg_echo('profile:field:email'), $group_options);
		profile_manager_add_custom_field_type('custom_group_field_types', 'tel', elgg_echo('profile_manager:admin:options:tel'), $tel_options);
		profile_manager_add_custom_field_type('custom_group_field_types', 'date', elgg_echo('profile:field:date'), $group_options);
		profile_manager_add_custom_field_type('custom_group_field_types', 'location', elgg_echo('profile:field:location'), $location_options);
		profile_manager_add_custom_field_type('custom_group_field_types', 'dropdown', elgg_echo('profile_manager:admin:options:dropdown'), $dropdown_options);
		profile_manager_add_custom_field_type('custom_group_field_types', 'radio', elgg_echo('profile_manager:admin:options:radio'), $radio_options);
		profile_manager_add_custom_field_type('custom_group_field_types', 'multiselect', elgg_echo('profile_manager:admin:options:multiselect'), $group_options);
	}
}
