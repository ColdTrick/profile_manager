<?php
/**
 * @uses $vars['entity']       The user entity
 * @uses $vars['microformats'] Mapping of fieldnames to microformats
 * @uses $vars['fields']       Array of profile fields to show
 */

$microformats = [
	'mobile' => 'tel p-tel',
	'phone' => 'tel p-tel',
	'website' => 'url u-url',
	'contactemail' => 'email u-email',
];
$microformats = array_merge($microformats, (array) elgg_extract('microformats', $vars, []));

$user = elgg_extract('entity', $vars);
if (!($user instanceof ElggUser)) {
	return;
}

$categorized_fields = profile_manager_get_categorized_fields($user);
$cats = elgg_extract('categories', $categorized_fields);
$fields = elgg_extract('fields', $categorized_fields);

if (count($cats) < 1) {
	return;
}

$output = '';

$show_profile_type_on_profile = elgg_get_plugin_setting('show_profile_type_on_profile', 'profile_manager');

if ($show_profile_type_on_profile !== 'no') {
	if ($profile_type_guid = $user->custom_profile_type) {
		if (($profile_type = get_entity($profile_type_guid)) && ($profile_type instanceof \ColdTrick\ProfileManager\CustomProfileType)) {
			$output .= elgg_format_element('div', ['class' => 'even'], '<b>' . elgg_echo('profile_manager:user_details:profile_type') . '</b>: ' . $profile_type->getDisplayName());
		}
	}
}

// only show category headers if more than 1 category available
$show_header = (bool) (count($cats) > 1);

foreach ($cats as $cat_guid => $cat) {

	$cat_data = '';
	foreach ($fields[$cat_guid] as $field) {
		$shortname = $field->metadata_name;
		$valtype = $field->metadata_type;
		if ($cat_guid !== -1) {
			$annotations = $user->getAnnotations([
				'annotation_names' => "profile:$shortname",
				'limit' => false,
			]);
			$values = array_map(function (ElggAnnotation $a) {
				return $a->value;
			}, $annotations);
		
			if (!$values) {
				continue;
			}
			// emulate metadata API
			$value = (count($values) === 1) ? $values[0] : $values;
		} else {
			// system data is not annotations
			$value = $user->$shortname;
		}
		// validate urls
		if ($valtype == 'url' && !preg_match('~^https?\://~i', $value)) {
			$value = "http://$value";
		}
		
		// adjust output type
		if ($field->output_as_tags == 'yes') {
			$valtype = 'tags';
			if (!is_array($value)) {
				$value = string_to_tag_array($value);
			}
		}
		
		$class = elgg_extract($shortname, $microformats, '');
	
		$cat_data .= elgg_view('object/elements/field', [
			'label' => $field->getDisplayName(),
			'value' => elgg_format_element('span', [
				'class' => $class,
			], elgg_view("output/{$valtype}", [
				'value' => $value,
			])),
			'name' => $shortname,
		]);
	}
	
	if (!empty($cat_data)) {
		if (!$show_header) {
			$output .= $cat_data;
		} else {
			$cat_title = $cat;
			if ($cat_guid == -1) {
				$cat_title = elgg_echo('profile_manager:categories:list:system');
			} elseif ($cat_guid == 0) {
				if (empty($cat)) {
					$cat_title = elgg_echo('profile_manager:categories:list:default');
				}
			} elseif ($cat instanceof \ColdTrick\ProfileManager\CustomFieldCategory) {
				$cat_title = $cat->getDisplayName();
			}
			
			$output .= elgg_view_module('info', $cat_title, $cat_data);
		}
	}
}

if ($output) {
	echo elgg_format_element('div', ['class' => 'elgg-profile-fields'], $output);
}


// if (!empty($details_result)) {
// 	$details_options = [
// 		'id' => 'custom_fields_userdetails',
// 		'class' => ['elgg-module', 'elgg-module-info'],
// 	];
// 	if (elgg_get_plugin_setting('display_categories', 'profile_manager') == 'accordion') {
// 		elgg_require_js('profile_manager/accordion');
// 		$details_options['class'][] = 'profile-manager-accordion';
// 	}
// 	$content .= elgg_format_element('div', $details_options, $details_result);
// }
