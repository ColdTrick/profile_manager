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

elgg_require_js('profile_manager/profile_edit');

echo elgg_view('profile/edit/name', $vars);

// Build fields

$categorized_fields = profile_manager_get_categorized_fields($user, true);
$cats = $categorized_fields['categories'];
$fields = $categorized_fields['fields'];

$edit_profile_mode = elgg_get_plugin_setting('edit_profile_mode', 'profile_manager');
$simple_access_control = elgg_get_plugin_setting('simple_access_control','profile_manager');

$access_id = get_default_access($user);

if (!empty($cats)) {
	
	// Profile type selector
	$setting = elgg_get_plugin_setting('profile_type_selection', 'profile_manager', 'user');
	
	$profile_type = $user->custom_profile_type;
	
	// can user edit? or just admins
	if ($setting == 'user' || elgg_is_admin_logged_in()) {
		// get profile types
		
		$types = elgg_get_entities([
			'type' => 'object',
			'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
			'limit' => false,
			'owner_guid' => elgg_get_site_entity()->getGUID(),
		]);
		if ($types) {
			$types_description = '';
			
			$dropdown_options = ['' => elgg_echo('profile_manager:profile:edit:custom_profile_type:default')];

			foreach ($types as $type) {
				
				$dropdown_options[$type->getGUID()] = $type->getTitle();
				
				// preparing descriptions of profile types
				$description = $type->getDescription();
				
				if (!empty($description)) {
					$type_description = elgg_format_element('h3', [], elgg_echo("profile_manager:profile:edit:custom_profile_type:description"));
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
	$tab_content = '';
	$list_content = '';
	
	foreach ($cats as $cat_guid => $cat) {
		// make nice title for category
		$cat_title = elgg_echo('profile_manager:categories:list:default');
		if ($cat instanceof \ColdTrick\ProfileManager\CustomFieldCategory) {
			$cat_title = $cat->getTitle();
		}
	
		$class = '';
		if ($edit_profile_mode !== 'tabbed') {
			$class .= 'elgg-module elgg-module-info';
		}
		if (!empty($cat_guid) && ($cat instanceof \ColdTrick\ProfileManager\CustomFieldCategory)) {

			$profile_types = elgg_get_entities_from_relationship([
				'type' => 'object',
				'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
				'limit' => false,
				'owner_guid' => $cat->getOwnerGUID(),
				'site_guid' => $cat->site_guid,
				'relationship' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP,
				'relationship_guid' => $cat_guid,
				'inverse_relationship' => true,
			]);
			if ($profile_types) {
				
				$class .= ' custom_fields_edit_profile_category';
				
				// add extra class so it can be toggle in the display
				$hidden_category = true;
				foreach ($profile_types as $type) {
					$class .= ' custom_profile_type_' . $type->getGUID();
					if ($type->getGUID() === (int) $profile_type) {
						$hidden_category = false;
					}
				}
				
				if ($hidden_category) {
					$class .= ' hidden';
				}
			}
		}
				
		$tab_content .= "<div id='profile_manager_profile_edit_tab_content_{$cat_guid}' class='profile_manager_profile_edit_tab_content'>";
			
		$list_content .= "<div id='{$cat_guid}' class='{$class}'>";
		if (count($cats) > 1) {
			$cat_header = elgg_format_element('h3', [], $cat_title);
			$list_content .= elgg_format_element('div', ['class' => 'elgg-head'], $cat_header);
		}
		$list_content .= '<div class="elgg-body">';
		$list_content .= '<fieldset>';
		
		// display each field for currect category
		$visible_fields = 0;
		
		foreach ($fields[$cat_guid] as $field) {
			
			if ($field->user_editable == 'no') {
				// non editable fields should not be on the form
				continue;
			}
			
			$valtype = $field->metadata_type;
			$metadata_name = $field->metadata_name;
			
			// get options
			$options = $field->getOptions();
						
			// get value
			$metadata = elgg_get_metadata([
				'guid' => $user->guid,
				'metadata_name' => $metadata_name,
				'limit' => false,
			]);
			
			if ($metadata) {
				$metadata = $metadata[0];
				
				$value = $user->$metadata_name;
				$access_id = $metadata->access_id;
			} else {
				$value = '';
				$access_id = get_default_access($user);
			}

			$visible_fields++;
			$field_result = '<div>';
			
			$field_result .= elgg_format_element('label', [], $field->getTitle(true));
			
			$hint = $field->getHint();
			if ($hint) {
				$field_result .= elgg_view('output/pm_hint', [
					'id' => "more_info_{$metadata_name}",
					'text' => $hint,
				]);
			}
			
			if ($valtype == 'dropdown') {
				// add div around dropdown to let it act as a block level element
				$field_result .= '<div>';
			}
			
			$field_options = [
				'name' => $metadata_name,
				'value' => $value,
				'options' => $options
			];

			$field_placeholder = $field->getPlaceholder();
			if (!empty($field_placeholder)) {
				$field_options['placeholder'] = $field_placeholder;
			}

			$field_result .= elgg_view('input/' . $valtype, $field_options);
			
			if ($valtype == 'dropdown') {
				$field_result .= '</div>';
			}
			
			$field_result .= elgg_view('input/access', [
				'name' => 'accesslevel[' . $metadata_name . ']',
				'value' => $access_id,
			]);
			$field_result .= '</div>';
			
			$tab_content .= $field_result;
			$list_content .= $field_result;
		}
		
		if ($visible_fields) {
			// only add tab if there are visible fields
			$tabs[] = [
				'title' => $cat_title,
				'url' => "#" . $cat_guid,
				'id' => $cat_guid,
				'class' => $class,
			];
		}
		
		$tab_content .= '</div>';
		
		$list_content .= '</fieldset>';
		$list_content .= '</div>';
		$list_content .= '</div>';
	}
	
	if (($edit_profile_mode == 'tabbed') && (count($cats) > 1)) {
		echo elgg_format_element('div', ['id' => 'profile_manager_profile_edit_tabs'], elgg_view('navigation/tabs', ['tabs' => $tabs]));
		echo elgg_format_element('div', ['id' => 'profile_manager_profile_edit_tab_content_wrapper'], $tab_content);
	} else {
		echo $list_content;
	}
}

if ($simple_access_control == 'yes') {
	elgg_require_js('profile_manager/simple_access_control');
	
	$simple_access_control_input = elgg_format_element('label', [], elgg_echo('profile_manager:simple_access_control'));
	$simple_access_control_input .= elgg_view('input/access', [
		'name' => 'simple_access_control',
		'value' => $access_id,
		'class' => 'simple_access_control mlm hidden',
	]);
	
	echo elgg_format_element('div', ['class' => 'profile-manager-simple-access-control'], $simple_access_control_input);
	
	?>
	<style type="text/css">
		.elgg-input-access {
			display: none;
		}
		.simple_access_control {
			display: inline-block;
		}
	</style>
	<?php
}

$foot = elgg_view('input/hidden', ['name' => 'guid', 'value' => $user->guid]);
$foot .= elgg_view('input/submit', ['value' => elgg_echo('save')]);

echo elgg_format_element('div', ['class' => 'elgg-foot'], $foot);
