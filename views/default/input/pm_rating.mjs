import 'jquery';

// rating initialisation
$(document).on('mouseover', '.profile-manager-input-pm-rating .elgg-icon', function() {
	var $current_star = $(this);
	var $container = $current_star.closest('.profile-manager-input-pm-rating');
	
	$container.find('.fa-star').removeClass('far fas').addClass('far');
	$current_star.prevAll().addBack().addClass('fas');
}).on('mouseout', '.profile-manager-input-pm-rating .elgg-icon', function() {
	var $container = $(this).closest('.profile-manager-input-pm-rating');
	
	$container.find('.fa-star').removeClass('far fas').addClass('far');
	$container.find('.pm-rating-selected').removeClass('far').addClass('fas');
}).on('click', '.profile-manager-input-pm-rating .elgg-icon', function() {
	var $current_star = $(this);
	var $container = $current_star.closest('.profile-manager-input-pm-rating');
	
	$container.find('.pm-rating-selected').removeClass('pm-rating-selected fas').addClass('far');
	$current_star.prevAll().addBack().addClass('pm-rating-selected fas').removeClass('far');
	var newVal = $container.find('.elgg-icon').index(this) + 1;
	$container.find('input').val(newVal);
});

$(document).on('click', '.profile-manager-input-pm-rating a', function(event) {
	event.preventDefault();
	
	$(this).parent().find('.elgg-icon').removeClass('pm-rating-selected fas').addClass('far');
	$(this).parent().find('input').val('');
});
