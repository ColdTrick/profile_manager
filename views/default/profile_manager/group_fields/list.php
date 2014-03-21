<?php
/**
* Profile Manager
*
* Group Fields list view
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$options = array(
		"type" => "object",
		"subtype" => CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE,
		"limit" => false,
		"order_by_metadata" => array(array('name' => 'order', 'direction' => "asc", 'as' => "integer")),
		"owner_guid" => elgg_get_site_entity()->getGUID(),
		"pagination" => false,
		"full_view" => false
	);

$list = elgg_list_entities_from_metadata($options);

if (empty($list)) {
	$list = elgg_echo("profile_manager:profile_fields:no_fields");
}
?>

<div class="elgg-module elgg-module-inline">
	<div class="elgg-head">
		<?php echo elgg_view("output/url", array("text" => elgg_echo("add"), "href" => "ajax/view/forms/profile_manager/group_field", "class" => "elgg-button elgg-button-action profile-manager-popup elgg-lightbox"));?>
		<h3>
			<?php echo elgg_echo('profile_manager:group_fields:list:title'); ?>
		</h3>
	</div>
	<div class="elgg-body" id="custom_fields_ordering">
		<?php echo $list; ?>
	</div>
</div>