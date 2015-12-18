elgg.provide('elgg.profile_manager');

elgg.profile_manager.init_rating = function(){
	// rating initialisation
	$(document).on('mouseover', '.profile-manager-input-pm-rating .elgg-icon', function() {
		$(this).parent().find('.fa-star').addClass('pm-rating-selected fa-star-o').removeClass('fa-star');
		
		$(this).addClass('fa-star').removeClass('fa-star-o').prevAll('.elgg-icon').addClass('fa-star').removeClass('fa-star-o');
	}).on('mouseout', '.profile-manager-input-pm-rating .elgg-icon', function() {
		$(this).parent().find('.elgg-icon').removeClass('fa-star fa-star-o').addClass('fa-star-o').filter('.pm-rating-selected').toggleClass('fa-star-o fa-star');
	}).on('click', '.profile-manager-input-pm-rating .elgg-icon', function() {

		$(this).parent().find('.elgg-icon').removeClass('pm-rating-selected');
		$(this).addClass('pm-rating-selected').prevAll('.elgg-icon').addClass('pm-rating-selected');
		var newVal = $(this).parent().find('.elgg-icon').index(this) + 1;
		$(this).parent().find('input').val(newVal);
	});
	
	$(document).on('click', '.profile-manager-input-pm-rating a', function(event) {
		$(this).parent().find('.elgg-icon').removeClass('pm-rating-selected fa-star').addClass('fa-star-o');
		$(this).parent().find('input').val('');
		event.preventDefault();
	});
};

//register init hook
elgg.register_hook_handler('init', 'system', elgg.profile_manager.init_rating);