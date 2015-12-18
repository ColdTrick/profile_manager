define(function(require) {
	var $ = require('jquery');

	function init () {
		$(document).ready(function(){
			var val = $('.elgg-input-access:first').val();
			$('.simple_access_control').val(val);
			
			set_access_control(val);
			
			$('.simple_access_control').on('change', function() {
				set_access_control($(this).val());
			}).removeClass('hidden');
		});
	}
	
	function set_access_control(val){
		$('.elgg-input-access').not('.simple_access_control').val(val);
	}
	
	init();
});
