<?php
			
	$plugin = "profile_manager";
	$details = array("user_guid" => page_owner());
	
	$user_guid = $details['user_guid'];
	if ($user_guid)
	{
		$user_guid = get_loggedin_userid();
	}
	
	?>
	<div class="contentWrapper">
		<h3 class="settings"><?php echo elgg_echo($plugin); ?></h3>
	
		<div id="<?php echo $plugin; ?>_settings">
			<?php 
			
			$entity = find_plugin_usersettings($plugin, $user_guid);
	
			$noyes_options = array(
				"no" => elgg_echo("option:no"),
				"yes" => elgg_echo("option:yes")
			);
			
			$form_body .= "<div>";
				$form_body .= elgg_echo("profile_manager:usersettings:hide_from_search_engine");
				$form_body .= "&nbsp;" . elgg_view("input/pulldown", array("internalname" => "params[hide_from_search_engine]", "options_values" => $noyes_options, "value" => $entity->hide_from_search_engine));
				$form_body .= "<div class='profile_noindex_explain'>" . elgg_echo("profile_manager:usersettings:hide_from_search_engine:explain") . "</div>";
			$form_body .= "</div>";
			$form_body .= "<p>" . elgg_view('input/hidden', array('internalname' => 'plugin', 'value' => $plugin)) . elgg_view('input/submit', array('value' => elgg_echo('save'))) . "</p>";
			
			?>
			<div>
				<?php echo elgg_view('input/form', array('body' => $form_body, 'action' => "{$vars['url']}action/plugins/usersettings/save")); ?>
			</div>
		</div>
	</div>
	<?php
	