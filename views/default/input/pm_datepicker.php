<?php 
	/**
	* Profile Manager
	* 
	* Datepicker
	* 
	* @uses $vars['value'] The current value, if any
	* @uses $vars['name'] The name of the input field
	* 
	* @package profile_manager
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	*/
 	
	global $datepicker;
 	
	$dateformat = elgg_echo("profile_manager:datepicker:input:dateformat");
	$dateformat_js = elgg_echo("profile_manager:datepicker:input:dateformat_js");
	$locale_js = elgg_echo("profile_manager:datepicker:input:localisation");
	
    // only include js once
    if (empty($datepicker)) {
        echo <<< END
        
<script type="text/javascript" src="{$vars['url']}mod/profile_manager/vendors/jquery.datepick.package-4.0.5/jquery.datepick.pack.js"></script>
<link rel="stylesheet" type="text/css" href="{$vars['url']}mod/profile_manager/vendors/jquery.datepick.package-4.0.5/redmond.datepick.css">        
END;
		if(!empty($locale_js)){
			echo "<script type='text/javascript' src='" . $vars['url'] . "mod/profile_manager/vendors/jquery.datepick.package-4.0.5/" . $locale_js . "'></script>";
		}
        $datepicker = 1;
    } else {
    	$datepicker++;
    }
    
    $internal_id = sanitise_string(str_replace("]", "_", str_replace("[" , "_" ,$vars['name']))) . $datepicker;
	
    $val = $vars['value'];
    if($val){
	    if((date($dateformat, $val) !== false) && (date($dateformat, $val) != date($dateformat, 0))){
			// probably a timestamp, we can format it
			$dateval =  strftime($dateformat, $val);
		} elseif(($new = strtotime($val)) !== false){
			// time in date format
			$dateval = strftime($dateformat, $new);
		}
    
    }
    
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#<?php echo $internal_id;?>').datepick({
			yearRange: '-90:+10',
			dateFormat: '<?php echo $dateformat_js;?>', 
		    altField: '#<?php echo $internal_id; ?>_alt', 
		    showTrigger: '<img src="<?php echo $vars['url']; ?>mod/profile_manager/vendors/jquery.datepick.package-4.0.5/calendar.gif" alt="Popup" class="trigger">',
		    onSelect: function(dates) {
			    var date = dates[0];
			    $('#<?php echo $internal_id; ?>_alt').val(date);
			}
		});
	});

</script>
<div>
	<input class="datepicker_hidden" type="text" READONLY name="<?php echo $vars['name']; ?>" value="" id="<?php echo $internal_id; ?>_alt" />
	<input type="text" READONLY id="<?php echo $internal_id; ?>" value="<?php echo $dateval; ?>" style="width:200px"/>
</div>