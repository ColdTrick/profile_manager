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
	
	$select_all_label = elgg_echo('profile_manager:export:select:all');
	$select_main_label = elgg_echo('profile_manager:export:select:default');
	$select_custom_label = elgg_echo('profile_manager:export:select:custom');
?>
<script>
		elgg.pm_customfields = [<?php
$first = true;
foreach ( $fields as $metadata_name => $type ) {
	if ( $first ) {
		$first = false;
	} else {
		echo ', ';
	}
	echo "'$metadata_name'";
}
?>];
	elgg.pm_export_selectAll = function() {
		var checked = document.getElementById('pm_exportselect_all').checked;
		document.getElementById('pm_exportselect_main').checked = checked;
		elgg.pm_export_selectMain();
		document.getElementById('pm_exportselect_custom').checked = checked;
		elgg.pm_export_selectCustom();
	}
	elgg.pm_export_selectMain = function() {
		var checked = document.getElementById('pm_exportselect_main').checked;
		document.getElementById('pm_export_guid').checked = checked;
		document.getElementById('pm_export_username').checked = checked;
		document.getElementById('pm_export_name').checked = checked;
		document.getElementById('pm_export_email').checked = checked;
		elgg.pm_export_selectMainUpdate();
	}
	elgg.pm_export_selectCustom = function() {
		var fields = elgg.pm_customfields;
		var checked = document.getElementById('pm_exportselect_custom').checked;
		for ( var i = 0; i < fields.length; ++i ) {
			document.getElementById('pm_exportcustom_' + fields[i]).checked = checked;
		}
		elgg.pm_export_selectCustomUpdate();
	}
	elgg.pm_export_selectAnyMain = function(theBox) {
		document.getElementById('pm_exportselect_main').checked = document.getElementById('pm_export_guid').checked &&
			document.getElementById('pm_export_username').checked &&
			document.getElementById('pm_export_name').checked &&
			document.getElementById('pm_export_email').checked;
		elgg.pm_export_selectMainUpdate();
	}
	elgg.pm_export_selectAnyCustom = function(theBox) {
		var fields = elgg.pm_customfields;
		var allSelected = true;
		for ( var i = 0; i < fields.length; ++i ) {
			if ( !document.getElementById('pm_exportcustom_' + fields[i]).checked ) {
				allSelected = false;
				break;
			}
		}
		document.getElementById('pm_exportselect_custom').checked = allSelected;
		elgg.pm_export_selectCustomUpdate();
	}
	elgg.pm_export_selectMainUpdate = function() {
		var checked = document.getElementById('pm_exportselect_main').checked;
		if ( document.getElementById('pm_exportselect_custom').checked == checked ) {
			document.getElementById('pm_exportselect_all').checked = checked;
		} else {
			document.getElementById('pm_exportselect_all').checked = false;
		}
	}
	elgg.pm_export_selectCustomUpdate = function() {
		var checked = document.getElementById('pm_exportselect_custom').checked;
		if ( document.getElementById('pm_exportselect_main').checked == checked ) {
			document.getElementById('pm_exportselect_all').checked = checked;
		} else {
			document.getElementById('pm_exportselect_all').checked = false;
		}
	}
</script>
	<div class="elgg-module elgg-module-inline">
		<div class="elgg-head">
			<h3><?php echo elgg_echo('profile_manager:export:list:title'); ?>
				&nbsp; [<input id="pm_exportselect_all" type="checkbox" onchange="elgg.pm_export_selectAll();"> <?php echo $select_all_label; ?> ]
				&nbsp; [<input id="pm_exportselect_main" type="checkbox" onchange="elgg.pm_export_selectMain();"> <?php echo $select_main_label; ?> ]
				&nbsp; [<input id="pm_exportselect_custom" type="checkbox" onchange="elgg.pm_export_selectCustom();"> <?php echo $select_custom_label; ?> ]
			</h3>
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
					<input id='pm_export_guid' type='checkbox' name='export[guid]' value='guid' onchange="elgg.pm_export_selectAnyMain(this);"></input>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo elgg_echo("username");?>
				</td>
				<td>
					<input id='pm_export_username' type='checkbox' name='export[username]' value='username' onchange="elgg.pm_export_selectAnyMain(this);"></input>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo elgg_echo("name");?>
				</td>
				<td>
					<input id='pm_export_name' type='checkbox' name='export[name]' value='name' onchange="elgg.pm_export_selectAnyMain(this);"></input>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo elgg_echo("email");?>
				</td>
				<td>
					<input id='pm_export_email' type='checkbox' name='export[email]' value='email' onchange="elgg.pm_export_selectAnyMain(this);"></input>
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
					<input id='pm_exportcustom_<?php echo $metadata_name;?>' type='checkbox' name='export[<?php echo $metadata_name;?>]' value='<?php echo $metadata_name;?>' onchange="elgg.pm_export_selectAnyCustom(this);"></input>
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