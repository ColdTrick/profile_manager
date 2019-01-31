<?php
/**
* Profile Manager
*
* Replaces default Elgg profile edit form
*
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*
* @uses $user The user entity
*/

$user = elgg_extract('entity', $vars);


$sticky_values = elgg_get_sticky_values('profile:edit');

echo elgg_view('profile/edit/name', $vars);

// Build fields

$categorized_fields = profile_manager_get_categorized_fields($user, true);
$cats = elgg_extract('categories', $categorized_fields);
$fields = elgg_extract('fields', $categorized_fields);

$edit_profile_mode = elgg_get_plugin_setting('edit_profile_mode', 'profile_manager');
$show_tabbed = (bool) ($edit_profile_mode === 'tabbed');

$simple_access_control = (bool) (elgg_get_plugin_setting('simple_access_control','profile_manager') === 'yes');

$access_id = get_default_access($user);

if (!empty($cats)) {
	
	// Profile type selector
	$setting = elgg_get_plugin_setting('profile_type_selection', 'profile_manager');
	
	$profile_type = $user->custom_profile_type;
	
	// can user edit? or just admins
	if ($setting == 'user' || elgg_is_admin_logged_in()) {
		$types = elgg_get_entities([
			'type' => 'object',
			'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
			'limit' => false,
			'owner_guid' => elgg_get_site_entity()->getGUID(),
		]);
		
		if ($types) {
			elgg_require_js('profile_manager/profile_type');

			$types_description = '';
			
			$dropdown_options = ['' => elgg_echo('profile_manager:profile:edit:custom_profile_type:default')];

			foreach ($types as $type) {
				
				$dropdown_options[$type->guid] = $type->getDisplayName();
				
				// preparing descriptions of profile types
				$description = $type->getDescription();
				
				if (!empty($description)) {
					$type_description = elgg_format_element('strong', [], elgg_echo("profile_manager:profile:edit:custom_profile_type:description"));
					$type_description .= $description;
					
					$types_description .= elgg_format_element('div', [
						'id' => 'custom_profile_type_description_' . $type->getGUID(),
						'class' => 'custom_profile_type_description hidden',
					], $type_description);
				}
			}
			
			if (elgg_get_plugin_setting('hide_profile_type_default', 'profile_manager') == 'yes') {
				// only unset if the current type exists in the options, otherwise keep default intact
				if (array_key_exists($profile_type, $dropdown_options)) {
					unset($dropdown_options['']);
				}
			}
			
			
			$types_input = elgg_format_element('label', [], elgg_echo('profile_manager:profile:edit:custom_profile_type:label'));
			$types_input .= elgg_view('input/dropdown', [
				'name' => 'custom_profile_type',
				'id' => 'custom_profile_type',
				'options_values' => $dropdown_options,
				'onchange' => 'elgg.profile_manager.change_profile_type();',
				'value' => $user->custom_profile_type,
				'class' => 'mlm',
			]);
			$types_input .= elgg_view('input/hidden', ['name' => 'accesslevel[custom_profile_type]', 'value' => ACCESS_PUBLIC]);
			
			echo elgg_format_element('div', [], $types_input);
			echo $types_description;
		}
	} else {
		if (!empty($profile_type)) {
			echo elgg_view('input/hidden', ['name' => 'custom_profile_type', 'value' => $profile_type]);
			echo elgg_view('input/hidden', ['name' => 'accesslevel[custom_profile_type]', 'value' => ACCESS_PUBLIC]);
		}
	}
	
	$tabs = [];
	$output = '';
	
	// only show category headers if more than 1 category available
	$show_header = (bool) (count($cats) > 1);
	
	foreach ($cats as $cat_guid => $cat) {
		
		$category_class = [
			'custom_fields_edit_profile_category',
		];
		if ($cat instanceof \ColdTrick\ProfileManager\CustomFieldCategory) {

			$profile_types = elgg_get_entities([
				'type' => 'object',
				'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
				'limit' => false,
				'owner_guid' => $cat->getOwnerGUID(),
				'relationship' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP,
				'relationship_guid' => $cat_guid,
				'inverse_relationship' => true,
			]);
			
			if ($profile_types) {
				// add extra class so it can be toggle in the display
				$hidden_category = true;
				foreach ($profile_types as $type) {
					$category_class[] = 'custom_profile_type_' . $type->guid;
					if ($type->guid === (int) $profile_type) {
						$hidden_category = false;
					}
				}
				
				if ($hidden_category) {
					$category_class[] = 'hidden';
				}
			} else {
				$category_class[] = 'custom_profile_type_0';
			}
		} else {
			$category_class[] = 'custom_profile_type_0';
		}
				
		$cat_data = '';
		
		foreach ($fields[$cat_guid] as $field) {
			if ($field->user_editable == 'no') {
				// non editable fields should not be on the form
				continue;
			}
			
			$shortname = $field->metadata_name;
			$valtype = $field->metadata_type;
			
			$annotations = $user->getAnnotations([
				'annotation_names' => "profile:$shortname",
				'limit' => false,
			]);
			$access_id = ACCESS_DEFAULT;
			if ($annotations) {
				$value = '';
				foreach ($annotations as $annotation) {
					if (!empty($value)) {
						$value .= ', ';
					}
					$value .= $annotation->value;
					$access_id = $annotation->access_id;
				}
			} else {
				$value = '';
			}
	
			// sticky form values take precedence over saved ones
			if (isset($sticky_values[$shortname])) {
				$value = $sticky_values[$shortname];
			}
			if (isset($sticky_values['accesslevel'][$shortname])) {
				$access_id = $sticky_values['accesslevel'][$shortname];
			}
	
			$id = "profile-$shortname";
			$input = elgg_view("input/$valtype", [
				'name' => $shortname,
				'value' => $value,
				'id' => $id,
				'options' => $field->getOptions() ?: null,
				'placeholder' => $field->getPlaceholder() ?: null,
			]);
			$access_input = elgg_view('input/access', [
				'name' => "accesslevel[$shortname]",
				'value' => $access_id,
			]);
			
			$cat_data .= elgg_view('elements/forms/field', [
				'class' => 'profile-manager-edit-profile-field',
				'input' => elgg_format_element('div', [
						'class' => 'elgg-field-input',
					], '<div class="edit-profile-input">' . $input . '</div><div class="edit-profile-access">' . $access_input . '</div>'),
				'label' => elgg_view('elements/forms/label', [
					'label' => $field->getDisplayName(true),
					'id' => $id,
				]),
				'help' => elgg_view('elements/forms/help', [
					'help' => $field->getHint(),
				]),
			]);
		}
		
		if (!empty($cat_data)) {
			if (!$show_header) {
				$output .= $cat_data;
			} else {
				// make nice title for category
				$cat_title = elgg_echo('profile_manager:categories:list:default');
				if ($cat instanceof \ColdTrick\ProfileManager\CustomFieldCategory) {
					$cat_title = $cat->getDisplayName();
				}
				
				if ($show_tabbed) {
					$tabs[] = [
						'text' => $cat_title,
						'content' => $cat_data,
						'class' => $category_class,
					];
				} else {
					$output .= elgg_view_module('info', $cat_title, $cat_data, [
						'class' => $category_class,
					]);
				}
			}
		}
	}
	
	if (!empty($tabs)) {
		// make the first tab selected
		$tabs[0]['selected'] = true;
		$output .= elgg_view('page/components/tabs', [
			'tabs' => $tabs,
			'id' => 'profile_manager_profile_edit_tabs',
		]);
	}
	
	if (!empty($output) && $simple_access_control) {
		elgg_require_js('profile_manager/simple_access_control');
		
		echo elgg_format_element('div', [
			'class' => 'profile-manager-simple-access-controlled',
		], $output);
		
		echo elgg_view_field([
			'#type' => 'access',
			'#label' => elgg_echo('profile_manager:simple_access_control'),
			'#class' => 'profile-manager-simple-access-control',
			'name' => 'simple_access_control',
			'value' => get_default_access($user),
		]);
	} else {
		echo $output;
	}
}

elgg_clear_sticky_form('profile:edit');

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'guid',
	'value' => $user->guid,
]);

$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('save'),
]);
elgg_set_form_footer($footer);
