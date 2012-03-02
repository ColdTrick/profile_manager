<?php
?>
// Profile Manager More Info tooltips
$(document).ready(function(){
	$("span.custom_fields_more_info").live('mouseover', function(e) {
			var tooltip = $("#text_" + $(this).attr('id'));
			$("body").append("<p id='custom_fields_more_info_tooltip'>"+ $(tooltip).html() + "</p>");
		
			if (e.pageX < 900) {
				$("#custom_fields_more_info_tooltip")
					.css("top",(e.pageY + 10) + "px")
					.css("left",(e.pageX + 10) + "px")
					.fadeIn("medium");	
			}	
			else {
				$("#custom_fields_more_info_tooltip")
					.css("top",(e.pageY + 10) + "px")
					.css("left",(e.pageX - 260) + "px")
					.fadeIn("medium");		
			}			
		}).live('mouseout', function() {
			$("#custom_fields_more_info_tooltip").remove();
		}
	);	
	
	$("#profile_manager_profile_edit_tabs a").click(function(){
		var id = $(this).attr("href").replace("#", ""); 
		$("#profile_manager_profile_edit_tabs li").removeClass("elgg-state-selected");
		$(this).parent().addClass("elgg-state-selected");
	
		$('#profile_manager_profile_edit_tab_content_wrapper>div').hide();
		$('#profile_manager_profile_edit_tab_content_' + id).show();
	});
	
	hash = window.location.hash;
	if(hash && $("#profile_manager_profile_edit_tabs " + hash).length > 0){
	
		$("#profile_manager_profile_edit_tabs " + hash + " a").click();
	} else {
		$("#profile_manager_profile_edit_tabs a:first").click();
	}
});

function changeProfileType(){
	var selVal = $('#custom_profile_type').val();
	
	$('.custom_fields_edit_profile_category').hide();
	$('.custom_profile_type_description').hide();

	if(selVal != ""){
		$('.custom_profile_type_' + selVal).show();
		$('#custom_profile_type_description_'+ selVal).show();
	}
	
	if($("#profile_manager_profile_edit_tabs li.elgg-state-selected:visible").length == 0){
		$("#profile_manager_profile_edit_tabs a:first").click();
	}
}