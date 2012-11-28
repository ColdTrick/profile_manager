<?php
?>
//<script>
elgg.provide("elgg.profile_manager");

var profile_manager_register_form_timers = new Array();
var profile_manager_register_form_validate_xhr = new Array();

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

	// tab switcher on edit form
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

	// registration form adjustments
	if($(".elgg-form-register").length > 0){
		// append mandatory *
		$(".elgg-form-register .mandatory>label").append("*");

		// validate on submit
		$(".elgg-form-register").submit(function(){
			var error_count = 0;
			var result = false;
	
			var $form = $(this);
			var selProfileType =  $("#custom_profile_fields_custom_profile_type").val();
			if(selProfileType == ""){
				selProfileType = 0;
			}
			
			$form.find(".mandatory").find("input, select, textarea").each(function(index, elem){
				
				switch($(elem).attr("type")){
					case "radio":
					case "checkbox":
						$(elem).parent(".mandatory").removeClass("profile_manager_register_missing");
	
						// check parents
						var $parents = $(elem).parents(".profile_manager_register_category"); 
						if(($parents.length == 0) || ($parents.hasClass("category_" + selProfileType) || $parents.hasClass("category_0"))){
							if($form.find("input[name='" + $(elem).attr("name") + "']:checked").length == 0){
								
								$(elem).parent(".mandatory").addClass("profile_manager_register_missing");
								error_count++;
							}
						}
						break;
					default:
						$(elem).removeClass("profile_manager_register_missing");
	
						// check parents
						var $parents = $(elem).parents(".profile_manager_register_category"); 
						if(($parents.length == 0) || ($parents.hasClass("profile_type_" + selProfileType) || $parents.hasClass("profile_type_0"))){
						
							if($(elem).is("select")){
								if($form.find("select[name='" + $(elem).attr("name") + "'] option:selected").val() == ""){
									$(elem).addClass("profile_manager_register_missing");
									error_count++;
								}
							} else {
								if($(elem).val() == ""){
									$(elem).addClass("profile_manager_register_missing");
									error_count++;
								}
							}
						}
						break;
				}
			});
		
			if(error_count > 0){
				alert(elgg.echo("profile_manager:register:mandatory"));
			} else {
				result = true;
			}
		
			return result;
		});

		$(".elgg-form-register").each(function(){
			var form = $(this);

			// add username generation when a email adress has been entered
			form.find("input[name='email']").live("blur", function(){
				var email_value = $(this).val();
				if(email_value.indexOf("@") !== -1){
					var pre = email_value.split("@");
					if(pre[0]){
						if($(".elgg-form-register input[name='username']").val() == ""){
							// change value and trigger change
							$(".elgg-form-register input[name='username']").val(pre[0]).keyup();
						}
					}
				}
			});

			// add live validation of username and emailaddress
			form.find("input[name='username'], input[name='email'], input[name='password']").live("keyup", function(event){
				var fieldname = $(event.currentTarget).attr("name");
				
				clearTimeout(profile_manager_register_form_timers[fieldname]);
				profile_manager_register_form_timers[fieldname] = setTimeout(function(){ elgg.profile_manager.register_form_validate(form, $(event.currentTarget)); }, 500);
			});

			// password compare check
			form.find("input[name='password'], input[name='password2']").live("keyup", function(event){
				var password1 = form.find("input[name='password']").val();
				var password2 = form.find("input[name='password2']").val();
				$field = form.find("input[name='password2']");
				$field_icon = $field.next(".profile_manager_validate_icon");
				$field_icon.attr("class", "elgg-icon profile_manager_validate_icon").attr("title", ""); 
				if((password1 !== "") && (password2 !== "")){
					if(password1 == password2){
						$field_icon.addClass("profile_manager_validate_icon_valid");
						$field.removeClass("profile_manager_register_missing");
					} else {
						$field_icon.addClass("profile_manager_validate_icon_invalid").attr("title", elgg.echo("RegistrationException:PasswordMismatch"));
					}
				}

			});
		});

		// init selected profile type
		elgg.profile_manager.change_profile_type_register();
	}
}

// live input validation
elgg.profile_manager.register_form_validate = function(form, field){
	var fieldname = $(field).attr("name"); 
	var fieldvalue = $(field).val(); 
	if(profile_manager_register_form_validate_xhr[fieldname]){
		// cancel running ajax calls
		profile_manager_register_form_validate_xhr[fieldname].abort();
	}
	if(fieldvalue){
		var data = new Object();
		data.name=fieldname;
		data[fieldname] = fieldvalue;
	
		form.find("input[name='" + fieldname + "']").next(".profile_manager_validate_icon").attr("class", "elgg-icon profile_manager_validate_icon profile_manager_validate_icon_loading").attr("title", "");
		
		profile_manager_register_form_validate_xhr[fieldname] = elgg.action("profile_manager/register/validate", {
				data: data,
				success: function(data){
					// process results
					if(data.output){
						$field = form.find("input[name='" + data.output.name + "']");
						$field_icon = $field.next(".profile_manager_validate_icon");
						$field_icon.removeClass("profile_manager_validate_icon_loading");
						if(data.output.status == false){
							// something went wrong; show error icon and add title
							$field_icon.addClass("profile_manager_validate_icon_invalid");
						}
	
						if(data.output.status == true){
							// something went right; show success icon
							$field_icon.addClass("profile_manager_validate_icon_valid");
							$field.removeClass("profile_manager_register_missing");
						}
						if(data.output.text){
							$field_icon.attr("title", data.output.text);
						}
					}
					
				}
			});
	} else {
		form.find("input[name='" + fieldname + "']").next(".profile_manager_validate_icon").attr("class", "elgg-icon profile_manager_validate_icon").attr("title", "");
	}	
}

// show description and fields based on selected profile type (profile edit)
elgg.profile_manager.change_profile_type = function(){
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

//show description and fields based on selected profile type (register form)
elgg.profile_manager.change_profile_type_register = function(){
	
	var selVal = $('#custom_profile_fields_custom_profile_type').val();
	if(selVal == "" || selVal == "undefined"){
		selVal = 0;
	}

	// profile type description
	$('div.custom_profile_type_description').hide();
	$('#'+ selVal).show();

	// tabs
	var $tabs = $('#profile_manager_register_tabbed'); 
	if($tabs.length > 0){
		$tabs.find('li').hide();
		$tabs.find(".profile_type_0, .profile_type_" + selVal).show();
		if($tabs.find('li.selected:visible').length == 0){
			$tabs.find('li:visible:first>a').click();
		} else {
			$tabs.find('li.selected:visible').click();
		}
	} else {
		// list
		$(".profile_manager_register_category").hide();
		$(".profile_manager_register_category.profile_type_0, .profile_manager_register_category.profile_type_" + selVal).show();
	}
}

// tab switcher on register form
elgg.profile_manager.toggle_tabbed_nav = function(div_id, element){
	$content_container = $('#profile_manager_register_tabbed').next(); 
	$content_container.find('>div').hide();
	$content_container.find('>div.category_' + div_id).show();

	$('#profile_manager_register_tabbed li.elgg-state-selected').removeClass('elgg-state-selected');
	$(element).parent('li').addClass("elgg-state-selected");
}

//register init hook
elgg.register_hook_handler("init", "system", elgg.profile_manager.init);