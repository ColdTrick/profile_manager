<?php 
	$body = elgg_view("profile_manager/members/form");
	$body = elgg_view_layout("one_column", $body);
	
	page_draw(elgg_echo('profile_manager:members:searchform:title'), $body);
?>