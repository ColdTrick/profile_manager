<?php
	/**
	 * Elgg groups plugin full profile view.
	 *
	 * @package ElggGroups
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider
	 * @copyright Curverider Ltd 2008-2010
	 * @link http://elgg.com/
	 */

	if ($vars['full'] == true) {
		$iconsize = "large";
	} else {
		$iconsize = "medium";
	}

?>

<div id="groups_info_column_right"><!-- start of groups_info_column_right -->
	<div id="groups_icon_wrapper"><!-- start of groups_icon_wrapper -->

		<?php
			echo elgg_view(
					"groups/icon", array(
												'entity' => $vars['entity'],
												//'align' => "left",
												'size' => $iconsize,
											)
					);
		?>

	</div><!-- end of groups_icon_wrapper -->
	<div id="group_stats"><!-- start of group_stats -->
		<?php

			echo "<p><b>" . elgg_echo("groups:owner") . ": </b><a href=\"" . get_user($vars['entity']->owner_guid)->getURL() . "\">" . get_user($vars['entity']->owner_guid)->name . "</a></p>";

		?>
		<p><?php echo elgg_echo('groups:members') . ": " . $vars['entity']->getMembers(0, 0, TRUE); ?></p>
	</div><!-- end of group_stats -->
</div><!-- end of groups_info_column_right -->

<div id="groups_info_column_left"><!-- start of groups_info_column_left -->
	<?php
		if ($vars['full'] == true) {
        	$group_fields = profile_manager_get_categorized_group_fields();
			
			if(count($group_fields["fields"]) > 0){
				$group_fields = $group_fields["fields"];
				
				foreach($group_fields as $field) {
					$metadata_name = $field->metadata_name;
					$value = $vars['entity']->$metadata_name;
					if($value){			
					    // make title
					    $title = $field->getTitle();
						
						// adjust output type
						if($field->output_as_tags == "yes"){
							$output_type = "tags";
						} else {
							$output_type = $field->metadata_type;
						}
						
						if($field->metadata_type == "url"){
							$target = "_blank";
						} else {
							$target = null;
						}
						
						//This function controls the alternating class
	                    $even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even';
				    	
						echo "<p class=\"{$even_odd}\">";
						echo "<b>" . $title . ": </b>";
						echo elgg_view("output/" . $output_type, array('value' => $value, "target" => $target));
						echo "</p>";
					}
				}
		    }
		}
	?>
</div><!-- end of groups_info_column_left -->

<div id="groups_info_wide">

	<p class="groups_info_edit_buttons">

<?php
	if ($vars['entity']->canEdit())
	{

?>

		<a href="<?php echo $vars['url']; ?>mod/groups/edit.php?group_guid=<?php echo $vars['entity']->getGUID(); ?>"><?php echo elgg_echo("edit"); ?></a>


<?php

	}

?>

	</p>
</div>
<div class="clearfloat"></div>