<?php 
	/**
	* Profile Manager
	* 
	* non editable
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
	
	echo elgg_view("input/hidden", $vars);
	
	echo "<div>";
	echo elgg_view("output/text", $vars);
	echo "</div>";
	
	echo "<div>";
	echo elgg_echo("profile_manager:non_editable:info");
	echo "</div>";