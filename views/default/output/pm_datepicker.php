<?php 
	/**
	* Profile Manager
	* 
	* Output view of a datepicker
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

	$dateformat = elgg_echo("profile_manager:datepicker:output:dateformat");
	echo "<span title='" . $vars['value'] . "'>";
	
	if((date($dateformat, $vars['value']) !== false) && (date($dateformat, $vars['value']) != date($dateformat, 0))){
		// probably a timestamp, we can format it
		echo strftime($dateformat, $vars['value']);
	} elseif(($new = strtotime($vars["value"])) !== false){
		// time in date format
		echo strftime($dateformat, $new);
	} else {
		// some other format, just present it
		echo $vars['value'];
	}
	echo "</span>";
