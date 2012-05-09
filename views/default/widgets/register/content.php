<?php
if(!elgg_is_logged_in()){
	echo elgg_view_form("register");
} else {
	echo elgg_echo("widgets:register:loggedout");
}