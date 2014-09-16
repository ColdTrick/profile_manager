<?php
/**
* Profile Manager
*
* Register profile icon input field
*
* @package profile_manager
* @author ColdTrick IT Solutions
* @copyright Coldtrick IT Solutions 2009
* @link http://www.coldtrick.com/
*/

$profile_icon = elgg_get_plugin_setting("profile_icon_on_register", "profile_manager");
if ($profile_icon == "yes") {
	// mandatory	
	echo "<div class='mandatory'>";	
} else {
	echo "<div>";	
}

echo "<label for='register-profile_icon'>" . elgg_echo("profile_manager:register:profile_icon") . "</label><br />";
echo elgg_view("input/file", array("name" => "profile_icon", "id" => "register-profile_icon"));
echo "</div>";
?>
<script type="text/javascript">
	$(document).ready(function(){
		$(".elgg-form-register").attr("enctype", "multipart/form-data").attr("encoding", "multipart/form-data");
	});
</script>