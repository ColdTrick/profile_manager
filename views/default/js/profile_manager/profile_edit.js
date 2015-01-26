elgg.provide("elgg.profile_manager");

//show description and fields based on selected profile type (profile edit)
elgg.profile_manager.change_profile_type = function(){
	var selVal = $('#custom_profile_type').val();
	
	$('.custom_fields_edit_profile_category').hide();
	$('.custom_profile_type_description').hide();

	if (selVal !== "") {
		$('.custom_profile_type_' + selVal).show();
		$('#custom_profile_type_description_'+ selVal).show();
	}
	
	if ($("#profile_manager_profile_edit_tabs li.elgg-state-selected:visible").length === 0) {
		$('#profile_manager_profile_edit_tab_content_wrapper>div').hide();
		$("#profile_manager_profile_edit_tabs a:first:visible").click();
	}
};

elgg.profile_manager.profile_manager_username = function(event, elem) {
	if (event.which !== 13) {
		var username = $(elem).val();
		$container = $(elem).parent();
		$container.find(".elgg-icon").hide();
		
		if (username !== $(elem).attr("rel")) {
			$container.find(".elgg-icon-profile-manager-loading").show();
			
			$.getJSON(elgg.get_site_url() + "profile_manager/validate_username", { "username": username }, function(data){
				if($("#profile_manager_username .elgg-input-text").val() == username){
					if(data.valid){
						$container.find(".elgg-icon-profile-manager-valid").show();
					} else {
						$container.find(".elgg-icon-profile-manager-invalid").show();
					}
					
					$("#profile_manager_username .elgg-icon-profile-manager-loading").hide();
				}
			});
		}
	}
};

elgg.profile_manager.init_edit = function() {
	// tab switcher on edit form
	$("#profile_manager_profile_edit_tabs a").click(function(event) {
		var id = $(this).attr("href").replace("#", "");
		$("#profile_manager_profile_edit_tabs li").removeClass("elgg-state-selected");
		$(this).parent().addClass("elgg-state-selected");
	
		$('#profile_manager_profile_edit_tab_content_wrapper>div').hide();
		$('#profile_manager_profile_edit_tab_content_' + id).show();

		// do not jump to the anchor
		event.preventDefault();
	});
	
	var hash = window.location.hash;
	if(hash && hash !== "#" && $("#profile_manager_profile_edit_tabs " + hash).length > 0){
		var $tab = $("#profile_manager_profile_edit_tabs " + hash + " a:visible");
		if($tab.length > 0){
			$tab.click();
		} else {
			$("#profile_manager_profile_edit_tabs a:first:visible").click();
		}
	} else {
		$("#profile_manager_profile_edit_tabs a:first:visible").click();
	}

	// username change
	$("#profile_manager_username .elgg-input-text").live("keyup", function(event) {
		elgg.profile_manager.profile_manager_username(event, $(this));
	});
};

//register init hook
elgg.register_hook_handler("init", "system", elgg.profile_manager.init_edit);