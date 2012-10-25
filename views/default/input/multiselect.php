<?php
	/**
	* Profile Manager
	* 
	* Multiselect
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
 
	global $multiselect;
	if (empty($multiselect)) {
		$multiselect = 1;
    } else {
    	$multiselect++;
    }
    $selected_items = $vars["value"];
    if(!is_array($selected_items)){
		$selected_items = string_to_tag_array($selected_items);
    }
    $selected_items = array_map("strtolower", $selected_items);

    $internal_id = str_replace("]", "_", str_replace("[" , "_" ,$vars['name'])) . $multiselect;
	
    elgg_load_js("jquery.ui.multiselect");
?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#<?php echo $internal_id;?>").multiselect({ 
			header: false,
			selectedList: 4,
			noneSelectedText: "<?php echo elgg_echo("profile_manager:input:multi_select:empty_text"); ?>"
		});
	});
</script>
<div>
	<select id="<?php echo $internal_id;?>" name="<?php echo $vars['name'];?>[]" multiple="multiple">
	<?php	
		if(!empty($vars["options_values"])){
			foreach($vars['options_values'] as $value => $option) {
		
				$encoded_value = htmlentities($value, ENT_QUOTES, 'UTF-8');
				$encoded_option = htmlentities($option, ENT_QUOTES, 'UTF-8');
		
				if (in_array(strtolower($value), $selected_items)) {
					echo "<option value=\"$encoded_value\" selected=\"selected\">$encoded_option</option>";
				} else {
					echo "<option value=\"$encoded_value\">$encoded_option</option>";
				}
			}
		} elseif(!empty($vars["options"])){
			foreach($vars['options'] as $option) {
				$selected = "";	
				if(in_array(strtolower($option), $selected_items)){
					$selected = " selected='selected'";
				}
				echo "<option" . $selected . ">" . $option . "</option>";
			}
		}
	?>
	</select>
</div>