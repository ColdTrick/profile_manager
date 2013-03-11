<?php 
	/**
	* Profile Manager
	* 
	* Profile Fields actions view
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

?>
<div class="elgg-module elgg-module-inline">
	<div class="elgg-head">
		<h3>
			<?php echo elgg_echo('profile_manager:actions:title'); ?>
			<span class='custom_fields_more_info' id='more_info_actions'></span>
		</h3>
	</div>
	<div class="elgg-body profile-manager-actions">
		<?php 
			echo elgg_view("output/confirmlink", array("text" => elgg_echo("reset"), "title" => elgg_echo("profile_manager:actions:reset:description"), "href" => "/action/profile_manager/reset?type=profile", "confirm" => elgg_echo("profile_manager:actions:reset:confirm"), "class" => "elgg-button elgg-button-action")); 
			echo elgg_view("output/confirmlink", array("text" => elgg_echo("profile_manager:actions:import:from_custom"), "title" => elgg_echo("profile_manager:actions:import:from_custom:description"), "href" => "/action/profile_manager/importFromCustom", "confirm" => elgg_echo("profile_manager:actions:import:from_custom:confirm"), "class" => "elgg-button elgg-button-action")); 
			echo elgg_view("output/confirmlink", array("text" => elgg_echo("profile_manager:actions:import:from_default"), "title" => elgg_echo("profile_manager:actions:import:from_default:description"), "href" => "/action/profile_manager/importFromDefault?type=profile", "confirm" => elgg_echo("profile_manager:actions:import:from_default:confirm"), "class" => "elgg-button elgg-button-action")); 
			echo elgg_view("output/url", array("title" => elgg_echo("profile_manager:actions:export:description"),"text" => elgg_echo("profile_manager:actions:export"), "href" => "/admin/users/export", "class" => "elgg-button elgg-button-action")); 
			echo elgg_view("output/confirmlink", array("text" => elgg_echo("profile_manager:actions:configuration:backup"), "href" => "/action/profile_manager/configuration/backup?fieldtype=" . CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE, "confirm" => elgg_echo("profile_manager:actions:configuration:backup:description"), "class" => "elgg-button elgg-button-action"));
			echo elgg_view("output/url", array("text" => elgg_echo("profile_manager:actions:configuration:restore"), "href" => "#restoreForm", "rel" => "toggle", "class" => "elgg-button elgg-button-action")); 

			$form_body = "<div class='mtm'>" . elgg_echo("profile_manager:actions:configuration:restore:description") . "</div>";
			$form_body .= elgg_view("input/file", array("name" => "restoreFile"));
			$form_body .= elgg_view("input/submit", array("value" => elgg_echo("profile_manager:actions:configuration:restore:upload")));

			$form = elgg_view("input/form", array("action" => "action/profile_manager/configuration/restore?fieldtype=" . CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE, "id" => "restoreForm", "body" => $form_body, "enctype" => "multipart/form-data"));

			echo $form;
		?>
	</div>
</div>

<div class="custom_fields_more_info_text" id="text_more_info_actions"><?php echo elgg_echo("profile_manager:tooltips:actions");?></div>