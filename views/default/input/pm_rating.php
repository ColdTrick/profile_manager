<?php

$selected_value = sanitise_int($vars['value'], false);

$rating_id = $vars["name"] . "_container";

echo "<div id='". $rating_id . "'>";
echo elgg_view("input/hidden", $vars);
for($i = 1; $i <= 5; $i++){
	if($i <= $selected_value){
		echo elgg_view_icon("star-alt", "link");
	} else {
		echo elgg_view_icon("star-empty","link");
	}	
}

echo " " . elgg_view("output/url", array("text" => elgg_echo("reset"), "href" => "#"));;
echo "</div>";
?>
<script type="text/javascript">

	$(document).ready(function(){
		$("#<?php echo $rating_id; ?> .elgg-icon").live({
			mouseover: function(){
				$("#<?php echo $rating_id; ?> .elgg-icon-star-alt").addClass("pm-rating-selected elgg-icon-star-empty").removeClass("elgg-icon-star-alt");
				
				$(this).addClass("elgg-icon-star-alt").removeClass("elgg-icon-star-empty").prevAll(".elgg-icon").addClass("elgg-icon-star-alt").removeClass("elgg-icon-star-empty");
				//.addClass("elgg-icon-star-alt").removeClass("elgg-icon-star-empty")
			},
			mouseout: function(){
				//$(this).addClass("elgg-icon-star-empty").removeClass("elgg-icon-star-alt");
				$("#<?php echo $rating_id; ?> .elgg-icon").removeClass("elgg-icon-star-alt elgg-icon-star-empty").addClass("elgg-icon-star-empty").filter(".pm-rating-selected").toggleClass("elgg-icon-star-empty elgg-icon-star-alt");
			},
			click: function(){
				$("#<?php echo $rating_id; ?> .elgg-icon").removeClass("pm-rating-selected");
				$(this).addClass("pm-rating-selected").prevAll(".elgg-icon").addClass("pm-rating-selected");
				var newVal = $("#<?php echo $rating_id; ?> .elgg-icon").index(this) + 1;
				$("#<?php echo $rating_id; ?> input").val(newVal);
			}
			
		});

		$("#<?php echo $rating_id; ?> a").live("click", function(event){
			$("#<?php echo $rating_id; ?> .elgg-icon").removeClass("pm-rating-selected elgg-icon-star-alt").addClass("elgg-icon-star-empty");
			$("#<?php echo $rating_id; ?> input").val("");
			event.preventDefault();
		});
	});
</script>