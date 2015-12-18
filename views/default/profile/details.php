<?php
/**
 * Elgg user display (details)
 * @uses $vars['entity'] The user entity
 */

$user = elgg_get_page_owner_entity();
	
$content = elgg_format_element('h2', [], $user->name);

$content .= elgg_view('profile/status', ['entity' => $user]);

$show_profile_type_on_profile = elgg_get_plugin_setting('show_profile_type_on_profile', 'profile_manager');

$categorized_fields = profile_manager_get_categorized_fields($user);
$cats = $categorized_fields['categories'];
$fields = $categorized_fields['fields'];

$details_result = '';
	
if ($show_profile_type_on_profile !== 'no') {
	if ($profile_type_guid = $user->custom_profile_type) {
		if (($profile_type = get_entity($profile_type_guid)) && ($profile_type instanceof \ColdTrick\ProfileManager\CustomProfileType)) {
			$details_result .= elgg_format_element('div', ['class' => 'even'], '<b>' . elgg_echo('profile_manager:user_details:profile_type') . '</b>: ' . $profile_type->getTitle());
		}
	}
}
	
if (count($cats) > 0) {
			
	// only show category headers if more than 1 category available
	if (count($cats) > 1) {
		$show_header = true;
	} else {
		$show_header = false;
	}
	
	foreach ($cats as $cat_guid => $cat) {
		$cat_title = '';
		$field_result = '';
		$even_odd = 'even';
		
		if ($show_header) {
			// make nice title
			$title = $cat;
			if ($cat_guid == -1) {
				$title = elgg_echo('profile_manager:categories:list:system');
			} elseif ($cat_guid == 0) {
				if (empty($cat)) {
					$title = elgg_echo('profile_manager:categories:list:default');
				}
			} elseif ($cat instanceof \ColdTrick\ProfileManager\CustomFieldCategory) {
				$title = $cat->getTitle();
			}

			$collapse_link = elgg_view('output/url', [
				'text' => ' ',
				'href' => '#',
				'class' => 'elgg-widget-collapse-button',
				'rel' => 'toggle',
			]);
			
			$cat_title = elgg_format_element('h3', ['class' => 'elgg-head mtm'], $title);
		}
			
		foreach ($fields[$cat_guid] as $field) {
			
			$metadata_name = $field->metadata_name;
			
			// give correct class
			if ($even_odd != 'even') {
				$even_odd = 'even';
			} else {
				$even_odd = 'odd';
			}
			
			// get user value
			$value = $user->$metadata_name;
			
			// adjust output type
			if ($field->output_as_tags == 'yes') {
				$output_type = 'tags';
				if (!is_array($value)) {
					$value = string_to_tag_array($value);
				}
			} else {
				$output_type = $field->metadata_type;
			}
			
			if ($field->metadata_type == 'url') {
				$target = '_blank';
				// validate urls
				if (!preg_match('~^https?\://~i', $value)) {
					$value = "http://$value";
				}
			} else {
				$target = null;
			}
			
			// build result
			$field_result .= '<div class="' . $even_odd . '">';
			$field_result .= '<b>' . $field->getTitle() . '</b>:&nbsp;';
			$field_result .= elgg_view('output/' . $output_type, ['value' => $value, 'target' => $target]);
			$field_result .= '</div>';
		}
			
		if (!empty($field_result)) {
			$details_result .= $cat_title;
			$details_result .= elgg_format_element('div', [], $field_result);
		}
	}
}
	
if (!empty($details_result)) {
	$details_options = [
		'id' => 'custom_fields_userdetails',
		'class' => ['elgg-module', 'elgg-module-info'],
	];
	if (elgg_get_plugin_setting('display_categories', 'profile_manager') == 'accordion') {
		elgg_require_js('profile_manager/accordion');
		$details_options['class'][] = 'profile-manager-accordion';
	}
	$content .= elgg_format_element('div', $details_options, $details_result);
}

if ($user->isBanned()) {
	$content .= elgg_format_element('p', ['class' => 'profile-banned-user'], elgg_echo('banned'));
}

echo elgg_format_element('div', ['id' => 'profile-details', 'class' => 'elgg-body pll'], $content);
