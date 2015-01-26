<?php
/**
* Profile Manager
*
* Profile Types add form
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
		if ($entity instanceof ProfileManagerCustomProfileType) {
			$vars["entity"] = $entity;
		}
	}
}

$form_title = elgg_echo('profile_manager:profile_types:add');

$metadata_name = null;
$metadata_label = null;
$metadata_description = null;

$related_categories = array();

if ($vars["entity"]) {
	
	$form_title = elgg_echo('profile_manager:profile_types:edit');
	
	$guid = $vars["entity"]->guid;
	$metadata_name = $vars["entity"]->metadata_name;
	$metadata_label = $vars["entity"]->metadata_label;
	$metadata_description = $vars["entity"]->metadata_description;
	
	$options = array(
		"type" => "object",
		"subtype" => CUSTOM_PROFILE_FIELDS_CATEGORY_SUBTYPE,
		"limit" => false,
		"owner_guid" => elgg_get_site_entity()->getGUID(),
		"relationship" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP,
		"relationship_guid" => $vars["entity"]->guid,
		"inverse_relationship" => false
	);
	
	$cats = elgg_get_entities_from_relationship($options);
	if ($cats) {
		foreach ($cats as $cat) {
			$related_categories[] = $cat->guid;
		}
	}
}

$formbody = "<table class='custom_fields_add_form_table'>";
$formbody .= "<tr>";
$formbody .= "<td class='custom_fields_add_form_table_left'>";

$formbody .= elgg_echo('profile_manager:admin:metadata_name') . ":";
$formbody .= elgg_view('input/text', array('name' => 'metadata_name', "value" => $metadata_name));

$formbody .= elgg_echo('profile_manager:admin:metadata_label') . "*:";
$formbody .= elgg_view('input/text', array('name' => 'metadata_label', "value" => $metadata_label));

$formbody .= elgg_echo('description') . "*:";
$formbody .= elgg_view('input/longtext', array("name" => "metadata_description", "value" => $metadata_description));
	
$formbody .= "</td>";
$formbody .= "<td class='custom_fields_add_form_table_right'>";

$options = array(
		"type" => "object",
		"subtype" => CUSTOM_PROFILE_FIELDS_CATEGORY_SUBTYPE,
		"limit" => false,
		"owner_guid" => elgg_get_site_entity()->getGUID()
	);

$categories = elgg_get_entities($options);

if (!empty($categories)) {
	$checkbox_options = array();
	
	foreach ($categories as $cat) {
		$title = $cat->getTitle();
		$checkbox_options[$title] = $cat->guid;
	}
	
	$formbody .= elgg_view("input/checkboxes", array("name" => "categories", "options" => $checkbox_options, "value" => $related_categories));
} else {
	$formbody .= "&nbsp;";
}

$formbody .= "</td>";
$formbody .= "</tr>";
$formbody .= "</table>";

$formbody .= elgg_view("input/hidden", array("name" => "guid", "value" => $guid));
$formbody .= elgg_view('input/submit', array("value" => elgg_echo('save')));

$form = elgg_view('input/form', array('body' => $formbody, 'action' => 'action/profile_manager/profile_types/add'));

?>
<div class="elgg-module elgg-module-inline mvn" id="custom_fields_profile_type_form">
	<div class="elgg-head">
		<h3>
			<?php echo $form_title; ?>
			<span class='custom_fields_more_info' id='more_info_profile_type'></span>
		</h3>
	</div>
	<div class="elgg-body">
		<?php echo $form; ?>
	</div>
</div>