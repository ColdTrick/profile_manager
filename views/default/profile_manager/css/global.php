<?php 
	$plugin_graphics_folder = elgg_get_site_url() . "mod/profile_manager/graphics/"; 
?>
.custom_fields_more_info {
	width: 14px;
	height: 14px;
	display: inline-block;
	vertical-align: sub;
	background: url(<?php echo $plugin_graphics_folder; ?>icon_customise_info.gif);
	cursor: pointer;
	margin-left: 5px;
}

.custom_fields_more_info_text {
	display:none;
}

#custom_fields_more_info_tooltip {
	position:absolute;
	border:1px solid #333333;
	background:#e4ecf5;
	color:#333333;
	padding:5px;
	display:none;
	width: 250px;
	line-height: 1.2em;
	font-size: 90%;
	z-index:20000;
}