<?php
$plugin_graphics_folder = elgg_get_site_url() . "mod/profile_manager/graphics/";
?>
.custom_fields_more_info {
	width: 16px;
	height: 16px;
	margin: 0 2px 0 5px;
	display: inline-block;
	vertical-align: top;
	background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/elgg_sprites.png) 0 -486px;
	cursor: pointer;
}
.custom_fields_more_info:hover {
	background-position: 0 -468px;
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