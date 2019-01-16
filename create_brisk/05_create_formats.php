<?php
/*/
This program creates the formats.
There is a lot of repeated code. But I am too lazy to clean it up.
/*/

require_once( 'auth_soap_c8.php' );
require_once( 'brisk_info.php' );

use cascade_ws_AOHS      as aohs;
use cascade_ws_constants as c;
use cascade_ws_asset     as a;
use cascade_ws_property  as p;
use cascade_ws_utility   as u;
use cascade_ws_exception as e;

try
{
    u\DebugUtility::setTimeSpaceLimits();

    /*/
    Part 1: chanw library
    /*/
    // retrieve the parent folder
    $parent_path   = "/core/library/velocity/chanw";
    $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
        
    foreach( $chanw_format_names as $format_name )
    {
        $format = $admin->getScriptFormat( "$parent_path/$format_name", $site_name );
        
        if( is_null( $format ) )
        {
            // create the format
            $format = $admin->createScriptFormat( $parent_folder, $format_name, "##" );
        }
        
        $upstate_source_url = "http://www.upstate.edu/standard-model/source/$format_name.xml";
        $code = file_get_contents( $upstate_source_url );
        $code = str_replace( "<code>", "", $code );
        $code = str_replace( "</code>", "", $code );
        $code = str_replace( "&lt;", "<", $code );
        $code = str_replace( "&gt;", ">", $code );
        $code = str_replace( "&amp;", "&", $code );
        // fix the site name
        $code = str_replace(
            "#set( \$chanw_framework_site_name = '_brisk' )",
            "#set( \$chanw_framework_site_name = '$site_name' )",
            $code
        );
        $code = str_replace(
            "#set( \$chanw_framework_site_name = \"_brisk\" )",
            "#set( \$chanw_framework_site_name = \"$site_name\" )",
            $code
        );
        
        $format->setScript( $code )->edit();
    }
    
    /*/
    Part 2: drulylg library
    /*/
    // retrieve the parent folder
    $parent_path   = "/core/library/velocity/drulykg";
    $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
    
    foreach( $drulykg_format_names as $format_name )
    {
        $format = $admin->getScriptFormat( "$parent_path/$format_name", $site_name );
        
        if( is_null( $format ) )
        {
            // create the format
            $format = $admin->createScriptFormat( $parent_folder, $format_name, "##" );
        }
        
        $upstate_source_url = "http://www.upstate.edu/standard-model/brisk/core/library/velocity/drulykg/$format_name.php";
        $code = file_get_contents( $upstate_source_url );
      
        $start_pos = strpos( $code, "<pre>#*doc" );
        $end_pos   = strpos( $code, "doc*###</pre>" );
        
        if( $start_pos !== false && $end_pos !== false )
        {
            $code = substr( $code, $start_pos + 5, $end_pos - $start_pos + 2 );
            $code = str_replace( "&lt;", "<", $code );
            $code = str_replace( "&gt;", ">", $code );
            $code = str_replace( "&amp;", "&", $code );
            $format->setScript( $code )->edit();
        }
    }

    /*/
    Part 3: drulylg macros
    /*/
    $parent_path   = "/core/macros";
    $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
    
    foreach( $drulykg_macro_names as $format_name )
    {
        $format = $admin->getScriptFormat( "$parent_path/$format_name", $site_name );
        
        if( is_null( $format ) )
        {
            // create the format
            $format = $admin->createScriptFormat( $parent_folder, $format_name, "##" );
        }
        
        $upstate_source_url = "http://www.upstate.edu/standard-model/brisk/core/macros/$format_name.php";
        $code = file_get_contents( $upstate_source_url );
      
        $start_pos = strpos( $code, "<pre>#*doc" );
        $end_pos   = strpos( $code, "doc*###</pre>" );
        
        if( $start_pos !== false && $end_pos !== false )
        {
            $code = substr( $code, $start_pos + 5, $end_pos - $start_pos + 2 );
            $code = str_replace( "&lt;", "<", $code );
            $code = str_replace( "&gt;", ">", $code );
            $code = str_replace( "&amp;", "&", $code );
            $format->setScript( $code )->edit();
        }
    }

    /*/
    Part 4: drulylg macros posted on github
    /*/
    $parent_path   = "/core/macros";
    $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
    
    foreach( $drulykg_missing_macros as $format_name )
    {
        $format = $admin->getScriptFormat( "$parent_path/$format_name", $site_name );
        
        if( is_null( $format ) )
        {
            // create the format
            $format = $admin->createScriptFormat( $parent_folder, $format_name, "##" );
        }
        
        $git_source_url = "https://raw.githubusercontent.com/wingmingchan/multiple-design/master/macros/$format_name.vm";
        $code = file_get_contents( $git_source_url );
        
        if( $code != "" )
        {
            $format->setScript( $code )->edit();
        }
    }

    /*/
    Part 5: core constants and startup
    /*/
    $parent_path   = "/core";
    $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
    
    foreach( $core_formats as $format_name )
    {
        $format = $admin->getScriptFormat( "$parent_path/$format_name", $site_name );
        
        if( is_null( $format ) )
        {
            // create the format
            $format = $admin->createScriptFormat( $parent_folder, $format_name, "##" );
        }
        
        $git_source_url = "https://raw.githubusercontent.com/wingmingchan/multiple-design/master/$format_name.vm";
        $code = file_get_contents( $git_source_url );
        
        if( $code != "" )
        {
            $code = str_replace(
                "#set( \$BRISK[ 'CORE_SITE_NAME' ] = '_brisk' )",
                "#set( \$BRISK[ 'CORE_SITE_NAME' ] = '$site_name' )",
                $code
            );
            $format->setScript( $code )->edit();
        }
    }

    /*/
    Part 6: app constants and app-startup
    /*/
    $parent_path   = "/app";
    $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
    
    foreach( $app_formats as $format_name )
    {
        $format = $admin->getScriptFormat( "$parent_path/$format_name", $site_name );
        
        if( is_null( $format ) )
        {
            // create the format
            $format = $admin->createScriptFormat( $parent_folder, $format_name, "##" );
        }
        
        $git_source_url = "https://raw.githubusercontent.com/wingmingchan/multiple-design/master/$format_name.vm";
        $code = file_get_contents( $git_source_url );
        
        if( $code != "" )
        {
            $format->setScript( $code )->edit();
        }
    }

    /*/
    Part 7: formats in components
    /*/
    $parent_path   = "/app/components";
    $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
    
    foreach( $components_format_names as $format_name )
    {
        $format = $admin->getScriptFormat( "$parent_path/$format_name", $site_name );
        
        if( is_null( $format ) )
        {
            // create the format
            $format = $admin->createScriptFormat( $parent_folder, $format_name, "##" );
        }
        
        $git_source_url = "https://raw.githubusercontent.com/wingmingchan/multiple-design/master/components/$format_name.vm";
        $code = file_get_contents( $git_source_url );
        
        if( $code != "" )
        {
            $format->setScript( $code )->edit();
        }
    }

    /*/
    Part 8: formats for content types
    /*/
    $parent_path   = "/app/content_types";
    $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
    
    foreach( $content_type_names as $format_name )
    {
        $format = $admin->getScriptFormat( "$parent_path/$format_name", $site_name );
        
        if( is_null( $format ) )
        {
            // create the format
            $format = $admin->createScriptFormat( $parent_folder, $format_name, "##" );
        }
        
        $git_source_url = "https://raw.githubusercontent.com/wingmingchan/multiple-design/master/content_types/$format_name.vm";
        $code = file_get_contents( $git_source_url );
        
        if( $code != "" )
        {
            $format->setScript( $code )->edit();
        }
    }

    /*/
    Part 9: formats for tree compoents
    /*/
    $parent_path   = "/app/scaffolds/tree_components";
    $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
    
    foreach( $tree_component_names as $format_name )
    {
        $format = $admin->getScriptFormat( "$parent_path/$format_name", $site_name );
        
        if( is_null( $format ) )
        {
            // create the format
            $format = $admin->createScriptFormat( $parent_folder, $format_name, "##" );
        }
        
        $git_source_url = "https://raw.githubusercontent.com/wingmingchan/multiple-design/master/scaffolds/tree_components/$format_name.vm";
        $code = file_get_contents( $git_source_url );
        
        if( $code != "" )
        {
            $format->setScript( $code )->edit();
        }
    }

    /*/
    Part 10: formats for scaffolds
    /*/
    $parent_path   = "/app/scaffolds";
    $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
    
    foreach( $scaffold_names as $format_name )
    {
        $format = $admin->getScriptFormat( "$parent_path/$format_name", $site_name );
        
        if( is_null( $format ) )
        {
            // create the format
            $format = $admin->createScriptFormat( $parent_folder, $format_name, "##" );
        }
        
        $git_source_url = "https://raw.githubusercontent.com/wingmingchan/multiple-design/master/scaffolds/$format_name.vm";
        $code = file_get_contents( $git_source_url );
        
        if( $code != "" )
        {
            $format->setScript( $code )->edit();
        }
    }

    /*/
    Part 11. rwd4 design tree
    /*/
    $parent_path   = "/app/scaffolds/rwd4";
    $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
    $format = $admin->getScriptFormat( "$parent_path/$rwd4_design_tree", $site_name );
    
    if( is_null( $format ) )
    {
        // create the format
        $format = $admin->createScriptFormat( $parent_folder, $rwd4_design_tree, "##" );
    }
    
    $git_source_url = "https://raw.githubusercontent.com/wingmingchan/multiple-design/master/scaffolds/rwd4/design-tree.vm";
    $code = file_get_contents( $git_source_url );
        
    if( $code != "" )
    {
        $format->setScript( $code )->edit();
    }

    /*/
    Part 12. XSLT
    /*/
    $parent_path   = "/core/library/xslt";
    $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
    
    foreach( $xsl_format_names as $format_name )
    {
        $format = $admin->getXsltFormat( "$parent_path/$format_name", $site_name );
        
        if( is_null( $format ) )
        {
            // create the format
            $format = $admin->createXsltFormat(
                $parent_folder, $format_name,
                "<xsl:stylesheet xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"></xsl:stylesheet>" );
        }
        
        $git_source_url = "https://raw.githubusercontent.com/wingmingchan/xslt/master/$format_name.xsl";
        $code = file_get_contents( $git_source_url );
        
        if( $code != "" )
        {
            $format->setXml( $code )->edit();
        }
    }

    $parent_path   = "/core";
    $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
    $format_name   = "page-template";
    $format        = $admin->getXsltFormat( "$parent_path/$format_name", $site_name );
    
    if( is_null( $format ) )
    {
        // create the format
        $format = $admin->createXsltFormat(
            $parent_folder, $format_name,
            "<xsl:stylesheet xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"></xsl:stylesheet>" );
    }
    
    $git_source_url = "https://raw.githubusercontent.com/wingmingchan/xslt/master/$format_name.xsl";
    $code = file_get_contents( $git_source_url );
        
    if( $code != "" )
    {
        $format->setXml( $code )->edit();
    }
}
catch( \Exception $e ) 
{
    echo S_PRE . $e . E_PRE; 
}
catch( \Error $er )
{
    echo S_PRE . $er . E_PRE; 
}
?>