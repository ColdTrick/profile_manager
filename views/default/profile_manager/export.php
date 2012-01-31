<?php
	/**
	* Profile Manager
	* 
	* Export view
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	$fieldtype = $vars['fieldtype'];

	if($fieldtype == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE){
		$fields = elgg_get_config('profile_fields');
	} elseif($fieldtype == CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE){
		$fields = elgg_get_config('group');
	}
	
	echo elgg_echo('profile_manager:export:description:' . $fieldtype);
?>
	<div class="elgg-module elgg-module-inline">
		<div class="elgg-head">
			<h3><?php echo elgg_echo('profile_manager:export:list:title'); ?></h3>
		</div>
		<div class="elgg-body">
	
<?php 
	
	if($fields){
		
		echo "<form action='" . $vars['url'] . "action/profile_manager/export' method='POST'>";
		echo "<input type='hidden' name='fieldtype' value='" . $fieldtype . "'></hidden>";
		echo elgg_view("input/securitytoken");
				
		echo "<table>";
		if($fieldtype == CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE){
			?>
			<tr>
				<td>
					<?php echo elgg_echo("guid");?>
				</td>
				<td>
					<input type='checkbox' name='export[guid]' value='guid'></input>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo elgg_echo("username");?>
				</td>
				<td>
					<input type='checkbox' name='export[username]' value='username'></input>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo elgg_echo("name");?>
				</td>
				<td>
					<input type='checkbox' name='export[name]' value='name'></input>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo elgg_echo("email");?>
				</td>
				<td>
					<input type='checkbox' name='export[email]' value='email'></input>
				</td>
			</tr>
			<?php 			
		}
		
		if($fieldtype == CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE){
			?>
			<tr>
				<td>
					<?php echo elgg_echo("guid");?>
				</td>
				<td>
					<input type='checkbox' name='export[guid]' value='guid'></input>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo elgg_echo("name");?>
				</td>
				<td>
					<input type='checkbox' name='export[name]' value='name'></input>
				</td>
			</tr>
			<?php 	
		}
		
		foreach($fields as $metadata_name => $type){
			?>
			<tr>
				<td>
					<?php echo $metadata_name;?>
				</td>
				<td>
					<input type='checkbox' name='export[<?php echo $metadata_name;?>]' value='<?php echo $metadata_name;?>'></input>
				</td>
			</tr>
			<?php 
		}
		echo "</table>";
		// buttons
		echo elgg_view("input/submit", array("value" => elgg_echo("export")));
		echo "</form>";
	} else {
		echo elgg_echo("profile_manager:export:nofields");
	}
?>
	</div>
</div>