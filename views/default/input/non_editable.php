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
	
	echo "</label>";
	echo "<input name='" . $vars['internalname'] . "' type='hidden' value='" . $vars['value'] . "'>";
	echo $vars['value'] . "<br />" . elgg_echo("profile_manager:non_editable:info") . "<br />";

?>