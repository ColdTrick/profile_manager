elgg.provide("elgg.profile_manager");

elgg.profile_manager.init_rating = function(){
	// rating initialisation
	$(document).on('mouseover', '.profile-manager-input-pm-rating .elgg-icon', function() {
		$(this).parent().find(".elgg-icon-star-alt").addClass("pm-rating-selected elgg-icon-star-empty").removeClass("elgg-icon-star-alt");
		
		$(this).addClass("elgg-icon-star-alt").removeClass("elgg-icon-star-empty").prevAll(".elgg-icon").addClass("elgg-icon-star-alt").removeClass("elgg-icon-star-empty");
	}).on('mouseout', '.profile-manager-input-pm-rating .elgg-icon', function() {
		$(this).parent().find(".elgg-icon").removeClass("elgg-icon-star-alt elgg-icon-star-empty").addClass("elgg-icon-star-empty").filter(".pm-rating-selected").toggleClass("elgg-icon-star-empty elgg-icon-star-alt");
	}).on('click', '.profile-manager-input-pm-rating .elgg-icon', function() {

		$(this).parent().find(".elgg-icon").removeClass("pm-rating-selected");
		$(this).addClass("pm-rating-selected").prevAll(".elgg-icon").addClass("pm-rating-selected");
		var newVal = $(this).parent().find(".elgg-icon").index(this) + 1;
		$(this).parent().find("input").val(newVal);
	});
	
	$(document).on('click', '.profile-manager-input-pm-rating a', function(event) {
		$(this).parent().find(".elgg-icon").removeClass("pm-rating-selected elgg-icon-star-alt").addClass("elgg-icon-star-empty");
		$(this).parent().find("input").val("");
		event.preventDefault();
	});
};

//register init hook
elgg.register_hook_handler("init", "system", elgg.profile_manager.init_rating);