<?php 
	/**
	* Profile Manager
	* 
	* view to extend the user links
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/

?>

<p class="user_menu_profile">
	<a href="<?php echo $vars['url'] . 'pg/profile_manager/full_profile/' . $vars['entity']->guid; ?>"><?php echo elgg_echo("profile_manager:show_full_profile"); ?></a>
</p>