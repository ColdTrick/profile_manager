<?php 
	
	$input_sorting = get_input("sorting", "newest");
	
	$default_search_criteria = "<tr><td colspan='2'>";
	$default_search_criteria .= elgg_echo("name") . elgg_view("input/text", array("internalname" => "user_data_partial_search_criteria[name]", "value" => get_input("name")));
	$default_search_criteria .= "</td></tr><tr>";
	
	$profile_type_options = array(
			"type" => "object",
			"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
			"count" => true,
			"owner_guid" => $CONFIG->site_guid,
			"metadata_name_value_pairs" => array("name" => "show_on_members", "value" =>  "yes")
		);
	
	$profile_type_count = elgg_get_entities_from_metadata($profile_type_options);
	if($profile_type_count > 0){
		$profile_type_options["count"] = false;
		$profile_type_options["limit"] = $profile_type_count;
		
		$profile_types = elgg_get_entities_from_metadata($profile_type_options);

		foreach($profile_types as $profile_type){
			// label
			$title = $profile_type->getTitle();
			
			$options[$title] = $profile_type->guid;
		}
				 
		$default_search_criteria .=  "<td>";
		$default_search_criteria .=  elgg_echo("profile_manager:profile_types:list:title") . "<br />";
		$default_search_criteria .=  elgg_view("input/checkboxes", array("internalname" => "profile_all_selector", "options" => array(elgg_echo("all")), "value" => elgg_echo("all") ,  "js" => "onchange='toggle_profile_type_selection($(this).parents(\"form\").attr(\"id\"));'"));
		$default_search_criteria .=  elgg_view("input/checkboxes", array("internalname" => "meta_data_array_search_criteria[custom_profile_type]", "options" => $options));
		$default_search_criteria .=  "</td>";
	} else {
		$default_search_criteria .=  "<td></td>";
	}
	
	$default_search_criteria .= "<td>" . elgg_echo("profile_manager:members:searchform:sorting"). "<br />";
	$default_search_criteria .= elgg_view("input/radio", array("internalname" => "sorting", "value" => $input_sorting, "options" => array(elgg_echo("profile_manager:members:searchform:sorting:alphabetic") => "alphabetic", elgg_echo("profile_manager:members:searchform:sorting:newest") => "newest", elgg_echo("profile_manager:members:searchform:sorting:popular") => "popular", elgg_echo("profile_manager:members:searchform:sorting:online") => "online")));
	$default_search_criteria .= "</td></tr>";
	
	$simple_search_criteria = "";
	
	
	$simple_search_fields_options = array(
			"type" => "object",
			"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
			"count" => true,
			"owner_guid" => $CONFIG->site_guid,
			"metadata_name_value_pairs" => array("name" => "simple_search", "value" =>  "yes")
		);
	
	$simple_search_fields_count = elgg_get_entities_from_metadata($simple_search_fields_options);
	if($simple_search_fields_count > 0){
		$simple_search_fields_options["count"] = false;
		$simple_search_fields_options["limit"] = $simple_search_fields_count;
		 
		$simple_search_fields = elgg_get_entities_from_metadata($simple_search_fields_options);
		
		foreach($simple_search_fields as $field){
			if($field->admin_only != "yes" || isadminloggedin()){
				$ordered_simple_search_fields[$field->order] = $field;
			}
		}
		ksort($ordered_simple_search_fields);
		
		foreach($ordered_simple_search_fields as $field){
			$metadata_name = $field->metadata_name;
			$metadata_type = $field->metadata_type;
			if($metadata_type == "longtext" || $metadata_type == "plaintext"){
				$metadata_type = "text";
			}
			// make title
			$title = $field->getTitle();
			
			// get options
			$options = $field->getOptions();
	
			// type of search
			$search_type = get_search_type($metadata_type);
			
			// input value
			$value = get_input($metadata_name); 
			
			// output field row
			$simple_search_criteria .= "<tr><td colspan='2'>";
			$simple_search_criteria .= $title . "<br />";
			
			if($search_type == "meta_data_between_search_criteria"){
				$simple_search_criteria .= elgg_echo("profile_manager:members:searchform:date:from") . " ";
				$simple_search_criteria .= elgg_view("input/" . $metadata_type, array(
					"internalname" => $search_type . "[" . $metadata_name . "][FROM]"));
				$simple_search_criteria .= " " . elgg_echo("profile_manager:members:searchform:date:to") . " ";
				$simple_search_criteria .= elgg_view("input/" . $metadata_type, array(
					"internalname" => $search_type . "[" . $metadata_name . "][TO]"));
			} else {
				$simple_search_criteria .= elgg_view("input/" . $metadata_type, array(
						"internalname" => $search_type . "[" . $metadata_name . "]",
						"options" => $options,
						"value" => $value));
			}
			$simple_search_criteria .= "</td></tr>";
		}
	}
	
	$advanced_search_criteria = "";
	
	$advanced_search_fields_options = array(
			"type" => "object",
			"subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
			"count" => true,
			"owner_guid" => $CONFIG->site_guid,
			"metadata_name_value_pairs" => array("name" => "advanced_search", "value" =>  "yes")
		);
	
	$advanced_search_fields_count = elgg_get_entities_from_metadata($advanced_search_fields_options);
	
	if($advanced_search_fields_count > 0){
		$advanced_search_fields_options["count"] = false;
		$advanced_search_fields_options["limit"] = $advanced_search_fields_count;
		
		$advanced_search_fields = elgg_get_entities_from_metadata($advanced_search_fields_options);
		
		foreach($advanced_search_fields as $field){
			if($field->admin_only != "yes" || isadminloggedin()){
				$ordered_advanced_search_fields[$field->order] = $field;
			}
		}
		ksort($ordered_advanced_search_fields);
		
		foreach($ordered_advanced_search_fields as $field){
			$metadata_name = $field->metadata_name;
			$metadata_type = $field->metadata_type;
			if($metadata_type == "longtext" || $metadata_type == "plaintext"){
				$metadata_type = "text";
			}
			// make title
			$title = $field->getTitle();

			// get options
			$options = $field->getOptions();
	
			// type of search
			$search_type = get_search_type($metadata_type);
			
			// input value
			$value = get_input($metadata_name); 
			
			// output field row
			$advanced_search_criteria .= "<tr><td colspan='2'>";
			$advanced_search_criteria .= $title . "<br />";
			
			if($search_type == "meta_data_between_search_criteria"){
				$advanced_search_criteria .= elgg_echo("profile_manager:members:searchform:date:from") . " ";
				$advanced_search_criteria .= elgg_view("input/" . $metadata_type, array(
					"internalname" => $search_type . "[" . $metadata_name . "][FROM]"));
				$advanced_search_criteria .= " " . elgg_echo("profile_manager:members:searchform:date:to") . " ";
				$advanced_search_criteria .= elgg_view("input/" . $metadata_type, array(
					"internalname" => $search_type . "[" . $metadata_name . "][TO]"));
			} else {
				$advanced_search_criteria .= elgg_view("input/" . $metadata_type, array(
						"internalname" => $search_type . "[" . $metadata_name . "]",
						"options" => $options,
						"value" => $value));
			}
			$advanced_search_criteria .= "</td></tr>";
		}
	}
	
	function get_search_type($metadata_type){
		$type = "meta_data_partial_search_criteria";
		if($metadata_type == "multiselect"){
			$type = "meta_data_array_search_criteria";
		} elseif($metadata_type == "pulldown" || $metadata_type == "radio") {
			$type = "meta_data_exact_search_criteria";
		} elseif($metadata_type == "pm_datepicker" || $metadata_type == "datepicker" || $metadata_type == "calendar"){
			$type = "meta_data_between_search_criteria";
		} 
		return $type;
	}
	
?>
<style type="text/css">
	.hasDatepick {
		width: 100px !important;
	}
</style>
<script type="text/javascript">
	var formdata;
	function perform_members_search(formid){
		$("body").addClass("profile_manager_members_wait");
		$("#members_search_result").hide();
		$("#members_search_loader").show();

		formdata = $("#" + formid).serialize();
		
		$.post("<?php echo $vars['url'];?>pg/members/search", formdata, function(data){
			$("#members_search_result").html(data);
			
			$("body").removeClass("profile_manager_members_wait");
			$("#members_search_loader").hide();
			$("#members_search_result").show();
		});
	}

	function navigate_members_search(offset){
		$("body").addClass("profile_manager_members_wait");
		$("#members_search_result").hide();
		$("#members_search_loader").show();
		
		$.post("<?php echo $vars['url'];?>pg/members/search?offset=" + offset, formdata, function(data){
			$("#members_search_result").html(data);
			
			$("body").removeClass("profile_manager_members_wait");
			$("#members_search_loader").hide();
			$("#members_search_result").show();
		});
	}

	function toggle_profile_type_selection(formid){
		var status = "disabled";
		
		if(formid != undefined){
			formid = "#" + formid + " ";
		} else {
			var formid = "";
		}

		if(formid != ""){
			if($(formid + "input[name='profile_all_selector[]']").attr("checked") == false){
				status = "";
			}
		}

		$(formid + "input[name='meta_data_array_search_criteria[custom_profile_type][]']").attr("disabled", status);		
	}

	$(document).ready(function(){
		toggle_profile_type_selection();
		perform_members_search("simplesearch");
	});

</script>
<?php echo elgg_view_title(elgg_echo("profile_manager:members:searchform:title"));?>
<div id='profile_manager_members_search_form' class='contentWrapper'>

<h3 class='settings' onclick='$("#simplesearch").toggle();$("#advancedsearch").toggle();'><?php echo elgg_echo("profile_manager:members:searchform:simple:title");?></h3>
<form id="simplesearch" action="javascript:perform_members_search('simplesearch');" type="post">
<table width=100%>
	<?php 
		echo $default_search_criteria;
		echo $simple_search_criteria;
	?>	
</table>

<?php 
	echo elgg_view("input/submit", array("value" => elgg_echo("search")));
	echo " ";
	echo elgg_view("input/reset", array("value" => elgg_echo("profile_manager:members:searchform:reset")));
?>

</form>

<?php
	// advanced search 
	if(!empty($advanced_search_criteria)){
?>
<h3 class='settings' onclick='$("#simplesearch").toggle();$("#advancedsearch").toggle();'><?php echo elgg_echo("profile_manager:members:searchform:advanced:title");?></h3>
<form id="advancedsearch" style="display:none" action="javascript:perform_members_search('advancedsearch');" type="post">
<table width=100%>
	<?php 
		echo $default_search_criteria;
		echo $advanced_search_criteria;
	?>
</table>

<?php 
	echo elgg_view("input/submit", array("value" => elgg_echo("search")));
	echo " ";
	echo elgg_view("input/reset", array("value" => elgg_echo("profile_manager:members:searchform:reset")));
?>

</form>
<?php 
	}
?>

</div>

<div id="members_search_result"></div>
<div id="members_search_loader">
	<?php echo elgg_view("ajax/loader"); ?>
</div>
<div class="clearfloat"></div>