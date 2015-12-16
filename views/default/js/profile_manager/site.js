elgg.provide("elgg.profile_manager");

elgg.profile_manager.init = function(){
	// profile details accordion
	$("#custom_fields_userdetails.profile-manager-accordion").accordion({
		header: "h3",
		heightStyle: "content"
	});
}

//register init hook
elgg.register_hook_handler("init", "system", elgg.profile_manager.init);