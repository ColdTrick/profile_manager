define(function(require) {
	var $ = require('jquery');

	function init () {
		$(document).on('mouseover', 'span.custom_fields_more_info', function(e) {
			var tooltip = $("#text_" + $(this).attr('id'));
			$("body").append("<p id='custom_fields_more_info_tooltip'>" + $(tooltip).html() + "</p>");
		
			if (e.pageX < 900) {
				$("#custom_fields_more_info_tooltip")
					.css("top",(e.pageY + 10) + "px")
					.css("left",(e.pageX + 10) + "px")
					.fadeIn("medium");
			} else {
				$("#custom_fields_more_info_tooltip")
					.css("top",(e.pageY + 10) + "px")
					.css("left",(e.pageX - 260) + "px")
					.fadeIn("medium");
			}
		}).on('mouseout', 'span.custom_fields_more_info', function() {
			$("#custom_fields_more_info_tooltip").remove();
		});
	}
	
	init();
});