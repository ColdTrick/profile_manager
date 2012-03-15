<?php
	/**
	* Profile Manager
	* 
	* JS (admin pages only, so no extend)
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

?>
//<script>
$(document).ready(function(){
	filterCustomFields(0);
	$('#custom_fields_ordering').sortable({
  		update: function(event, ui) { 
   			reorderCustomFields();			   		
   		},
   		opacity: 0.6,
   		tolerance: 'pointer',
   		items: 'li'
	});

	$('#custom_fields_category_list_custom .elgg-list').sortable({
		update: function(event, ui) { 
   			reorderCategories();			   		
   		},
		opacity: 0.6,
		tolerance: 'pointer',
		items: 'li',
		handle: '.elgg-icon-drag-arrow'
	});

	$('#custom_profile_field_category_0, #custom_fields_category_list_custom .elgg-item').droppable({
		accept: "#custom_fields_ordering .elgg-item",
		hoverClass: 'droppable-hover',
		tolerance: 'pointer',
		drop: function(event, ui) {
			var dropped_on = $(this).attr("id");  
			var dragged_field = $(ui.draggable);
			changeFieldCategory(dragged_field, dropped_on); 
		}
	});

	$(".elgg-icon-profile-manager-user-summary-config-add").live("click", function(){
		$("#profile-manager-user-summary-config-options").clone().insertBefore($(this)).removeAttr("id").attr("name", $(this).parent().attr("rel") + "[]");
	});

	$(".profile-manager-user-summary-config-options-delete").live("click", function(){
		$(this).parent().remove();
	});

	// add buttons
	$(".profile-manager-popup").fancybox();
});

function toggleOption(field, guid){
	$.post(elgg.security.addToken('<?php echo $vars['url']; ?>action/profile_manager/toggleOption?&guid=' + guid + '&field=' + field), function(data){
		if(data == 'true'){
			$("#" + field + "_" + guid).toggleClass("field_config_metadata_option_disabled field_config_metadata_option_enabled");
		} else {
			alert(elgg.echo("profile_manager:actions:toggle_option:error:unknown"));
		}
	});
}

function reorderCustomFields(){
	var strArray = $('#custom_fields_ordering').sortable('serialize');
	$.post(elgg.security.addToken('<?php echo $vars['url'];?>action/profile_manager/reorder?'), strArray);
}

function reorderCategories(){
	var strArray = $('#custom_fields_category_list_custom .elgg-list').sortable('serialize');
	$.post(elgg.security.addToken('<?php echo $vars['url'];?>action/profile_manager/categories/reorder?'), strArray);
}

function removeField(guid){
	if(confirm(elgg.echo("profile_manager:actions:delete:confirm"))){
		$.post(elgg.security.addToken('<?php echo $vars['url']; ?>action/profile_manager/delete?guid=' + guid), function(data){
			if(data == 'true'){
				$('#custom_profile_field_' + guid).hide('slow').parent().remove();
				reorderCustomFields();
			} else {
				alert(elgg.echo("profile_manager:actions:delete:error:unknown"));
			}
		});
	}	
}

function deleteCategory(guid){
	if(guid && confirm(elgg.echo("profile_manager:categories:delete:confirm"))){
		document.location.href = elgg.security.addToken("<?php echo $vars['url']; ?>action/profile_manager/categories/delete?guid=" + guid);
	}
}

function filterCustomFields(category_guid){
	$("#custom_fields_ordering .elgg-item").hide();
	$("#custom_fields_category_list_custom .custom_fields_category_selected").removeClass("custom_fields_category_selected");
	if(category_guid === 0){
		// show default
		$("#custom_fields_ordering .custom_field[rel='']").parent().show();
		$("#custom_profile_field_category_0").addClass("custom_fields_category_selected");
	} else {
		if(category_guid === undefined){
			// show all
			$("#custom_fields_ordering .custom_field").parent().show();
			$("#custom_profile_field_category_all").addClass("custom_fields_category_selected");
		} else {
			//show selected category
			$("#custom_fields_ordering .custom_field[rel='" + category_guid + "']").parent().show();
			$("#custom_profile_field_category_" + category_guid).parent().addClass("custom_fields_category_selected");
		}
	}		
}

function changeFieldType(){
	var selectedType = $("#custom_fields_form select[name='metadata_type']").val();
	
	$("#custom_fields_form .custom_fields_form_field_option").attr("disabled", "disabled");
	$("#custom_fields_form .field_option_enable_" + selectedType).removeAttr("disabled");
}

// categories	
function changeFieldCategory(field, category_guid){
	var field_guid = $(field).attr("id").replace("elgg-object-","");
	category_guid = category_guid.replace("elgg-object-","");

	$.post(elgg.security.addToken('<?php echo $vars['url']; ?>action/profile_manager/changeCategory?guid=' + field_guid + '&category_guid=' + category_guid), function(data){
		if(data == 'true'){		
			if(category_guid == 0){
				category_guid = "";
			}				 
			$(field).find(".custom_field").attr("rel", category_guid);
			$(".custom_fields_category_selected a").click();
				
		} else {
			alert(elgg.echo("profile_manager:actions:change_category:error:unknown"));
		}
	});
}

// Profile Types
function deleteProfileType(guid){
	if(guid && confirm(elgg.echo("profile_manager:profile_types:delete:confirm"))){
		document.location.href = elgg.security.addToken("<?php echo $vars['url']; ?>action/profile_manager/profile_types/delete?guid=" + guid);
	}
}
