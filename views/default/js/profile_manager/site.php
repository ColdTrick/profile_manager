<?php
?>
//<script>
elgg.provide("elgg.profile_manager");

elgg.profile_manager.init = function(){
	// more info tooltips
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

	// profile details accordion
	$("#custom_fields_userdetails.profile-manager-accordion").accordion({
		header: "h3",
		heightStyle: "content"
	});
}

//register init hook
elgg.register_hook_handler("init", "system", elgg.profile_manager.init);