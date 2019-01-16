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

// formats
$chanw_format_names = array(
	"chanw-database-utilities",
	"chanw-date-time-utilities",
	"chanw-display-velocity-code",
	"chanw-doc-xml-utilities",
	"chanw-element-utilities",
	"chanw-global-deque",
	"chanw-global-queue",
	"chanw-global-stack",
	"chanw-html-builder",
	"chanw-html-builder-with-deque",
	"chanw-initialization",
	"chanw-library-import",
	"chanw-process-cascade-api",
	"chanw-process-index-block",
	"chanw-process-xml",
	"chanw-reflect-utilities",
	"chanw-regex-utilities",
	"chanw-rss-utilities",
	"chanw-service-provider",
	"chanw-tree-utilities",
	"chanw-ws-utilities",
	"chanw-xslt-utilities"
);
$drulykg_format_names = array(
	"drulykg-html-asset",
	"drulykg-timer"
);
$drulykg_macro_names = array(
	"drulykgAppendVar",
	"drulykgConvertObjectToJdom",
	"drulykgConvertToArrayList",
	"drulykgDeepMerge",
	"drulykgEvaluateFormat",
	"drulykgFixWebUrl",
	"drulykgGetCascadeAssetLink",
	"drulykgGetCascadeAssetUrl",
	"drulykgGetObjectKeys",
	"drulykgGetSortedMethodsList",
	"drulykgHtmlTag",
	"drulykgImportPassThrough",
	"drulykgInvokeMacro",
	"drulykgParseCascadePath",
	"drulykgParseUrl",
	"drulykgPrependVar",
	"drulykgSetVar",
	"drulykgShallowMerge",
	"drulykgShowSortedMethodsList",
	"drulykgSimpleKeysAndValues",
	"drulykgVarDump"
);
$drulykg_missing_macros = array(
	"drulykgApplyBricks",
	"drulykgCleanupAndStop",
	"drulykgGetTagsAssetMap",
	"import-core-macros"
);
$core_formats = array(
	"core-constants",
	"startup"
);
$app_formats = array(
	"app-constants",
	"app-startup"
);
$components_format_names = array(
	"designNamespace",
	"generateClassicMenu",
	"generateMegaMenu",
	"generateMiniMenu",
	"page-element-macros",
	"page-load-core",
	"process-block-chooser-macros",
	"processSiteSetup",
	"siteNavHtmlShell"
);
$content_type_names = array( "Page", "RSS", "XML" );
$tree_component_names = array(
	"assemble-html",
	"assemble-innermain",
	"body-children",
	"body-children-behaviors",
	"footer-children",
	"footer-row-children",
	"footer-row-children-behaviors",
	"head-children",
	"head-children-behaviors",
	"header-children",
	"header-children-behaviors",
	"header-row-children",
	"header-row-children-behaviors",
	"html",
	"html-behaviors",
	"innermain",
	"innermain-children",
	"innermain-children-behaviors",
	"last-modified-behaviors",
	"main",
	"main-middle",
	"main-middle-bottom",
	"main-top-middle",
	"main-top-middle-bottom",
	"middle-element-children"
);
$scaffold_names = array(
	"3-column-main-tree",
	"center-main-tree",
	"center-right-main-tree",
	"default-html-tree",
	"default-main-tree",
	"innermain-tree",
	"left-center-main-tree"
);
$rwd4_design_tree = "design-tree";
$xsl_format_names = array( "java-string-methods", "node-processing" );
?>