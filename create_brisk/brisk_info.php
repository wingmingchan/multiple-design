<?php
/*/
This file stores some basic information of Brisk, used by other programs.
/*/
// a constant
$ROOT_PATH = "/";

// the name of the master site
$site_name = "wing ming.chan";

// names of metadata sets
$metadata_set_names = array(
    "Block", "Folder", "Image", "Page", "RSS", "Setup", "Symlink", "XML" );

// data definitions
$dd_url_base   = "https://raw.githubusercontent.com/wingmingchan/multiple-design/" .
    "master/data_definitions";
$dd_names_urls = array(
    "Article Feed"     => "$dd_url_base/dd_article_feed.xml",
    "Attributes"       => "$dd_url_base/dd_attributes.xml",
    "Block Content"    => "$dd_url_base/dd_block_content.xml",
    "Block Multimedia" => "$dd_url_base/dd_block_multimedia.xml",
    "Column"           => "$dd_url_base/dd_column.xml",
    "Countdown Timer"  => "$dd_url_base/dd_countdown_timer.xml",
    "Page"             => "$dd_url_base/dd_page.xml",
    "Row"              => "$dd_url_base/dd_row.xml",
    "Setup"            => "$dd_url_base/dd_setup.xml",
    "Velocity"         => "$dd_url_base/dd_velocity.xml",
    "Wysiwyg"          => "$dd_url_base/dd_wysiwyg.xml"
);

// folders
$folder_names_parent_paths = array(
	"app"             => $ROOT_PATH,
	"components"      => "/app",
	"block_macros"    => "/app/components",
	"blocks"          => "/app/components",
	"content_types"   => "/app",
	"scaffolds"       => "/app",
	"rwd4"            => "/app/scaffolds",
	"tree_components" => "/app/scaffolds",
	"site_designs"    => "/app",

	"core"            => $ROOT_PATH,
	"base-assets"     => "/core",
	"library"         => "/core",
	"velocity"        => "/core/library",
	"chanw"           => "/core/library/velocity",
	"drulykg"         => "/core/library/velocity",
	"xslt"            => "/core/library",
	"macros"          => "/core"
);
?>