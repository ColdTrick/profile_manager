<?php 
	/**
	* Profile Manager
	* 
	* Profile Fields header view
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

?>
<div class="contentWrapper">
	<?php 
		echo elgg_echo("profile_manager:profile_fields:add:description");
		echo "<br />";
		echo elgg_view("input/button", array("type" => "button", "value" => elgg_echo("profile_manager:profile_fields:add:link"), "js" => "onclick=\"toggleForm('custom_fields_form');\"")) . " ";
		echo elgg_view("input/button", array("type" => "button", "value" => elgg_echo("profile_manager:categories:add:link"), "js" => "onclick=\"toggleForm('custom_fields_category_form');\"")) . " ";
		echo elgg_view("input/button", array("type" => "button", "value" => elgg_echo("profile_manager:profile_types:add:link"), "js" => "onclick=\"toggleForm('custom_fields_profile_type_form');\""));
	?>
</div>