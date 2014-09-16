<?php
/**
* Profile Manager
*
* Category add form
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

if (!elgg_is_admin_logged_in()) {
	echo elgg_echo('adminrequired');
	return;
}

if ($guid = get_input("guid")) {
	if ($entity = get_entity($guid)) {
		if ($entity instanceof ProfileManagerCustomFieldCategory) {
			$vars["entity"] = $entity;
		}
	}
}

$form_title = elgg_echo('profile_manager:categories:add');

$metadata_name = null;
$metadata_label = null;
$related_types = array();

if ($vars["entity"]) {
	
	$form_title = elgg_echo('profile_manager:categories:edit');
	
	$guid = $vars["entity"]->guid;
	$metadata_name = $vars["entity"]->metadata_name;
	$metadata_label = $vars["entity"]->metadata_label;
	
	$options = array(
		"type" => "object",
		"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
		"limit" => false,
		"owner_guid" => elgg_get_site_entity()->getGUID(),
		"relationship" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP,
		"relationship_guid" => $vars["entity"]->guid,
		"inverse_relationship" => true
	);
	$types = elgg_get_entities_from_relationship($options);
	if ($types) {
		foreach ($types as $type) {
			$related_types[] = $type->guid;
		}
	}
}

$formbody = "<table class='custom_fields_add_form_table'>";
$formbody .= "<tr>";
$formbody .= "<td class='custom_fields_add_form_table_left'>";
$formbody .= elgg_echo('profile_manager:admin:metadata_name') . ":";
$formbody .= elgg_view('input/text', array('name' => 'metadata_name', "value" => $metadata_name));
$formbody .= "</td>";
$formbody .= "<td rowspan='2' class='custom_fields_add_form_table_right'>";

$options = array(
		"type" => "object",
		"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
		"limit" => false,
		"owner_guid" => elgg_get_site_entity()->getGUID()
	);

$types = elgg_get_entities($options);

if (count($types) > 0) {
	
	$checkbox_options = array();
	
	foreach ($types as $type) {
		$title = $type->getTitle();
		$checkbox_options[$title] = $type->guid;
	}
	
	$formbody .= elgg_view("input/checkboxes", array("name" => "profile_types", "options" => $checkbox_options, "value" => $related_types));
} else {
	$formbody .= "&nbsp;";
}

$formbody .= "</td>";
$formbody .= "</tr>";
$formbody .= "<tr>";
$formbody .= "<td>";
$formbody .= elgg_echo('profile_manager:admin:metadata_label') . "*:";
$formbody .= elgg_view('input/text', array('name' => 'metadata_label', "value" => $metadata_label));
$formbody .= "</td>";
$formbody .= "</tr>";
$formbody .= "</table>";

$formbody .= elgg_view("input/hidden", array("name" => "guid", "value" => $guid));
$formbody .= elgg_view('input/submit', array('name' => elgg_echo('save'), 'value' => elgg_echo('save')));

$form = elgg_view('input/form', array('body' => $formbody, 'action' => 'action/profile_manager/categories/add'));
	
?>
<div class="elgg-module elgg-module-inline mvn" id="custom_fields_category_form">
	<div class="elgg-head">
		<h3>
			<?php echo $form_title; ?>
			<span class='custom_fields_more_info' id='more_info_category'></span>
		</h3>
	</div>
	<div class="elgg-body">
		<?php echo $form; ?>
	</div>
</div>