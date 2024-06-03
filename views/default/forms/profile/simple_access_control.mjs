import 'jquery';
	
function set_access_control(val){
	$('.profile-manager-edit-profile-field .elgg-input-access').val(val);
}

$(document).ready(function(){
	set_access_control($('.elgg-input-access[name="simple_access_control"]').val());
	
	$('.elgg-input-access[name="simple_access_control"]').on('change', function() {
		set_access_control($(this).val());
	});
});
