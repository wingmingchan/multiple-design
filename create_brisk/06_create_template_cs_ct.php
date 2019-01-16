<?php
/*/
This program creates the template, three page configuration sets, and three content types.
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
    // the template
    $parent_path   = "/core";
    $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
    $template_name = "xml";
    $template      = $admin->getTemplate( "$parent_path/$template_name", $site_name );

    if( is_null( $template ) )
    {
        $template = $admin->createTemplate(
            $parent_folder, $template_name, "<system-region name=\"DEFAULT\"/>" );
    }
    else
    {
        $template->setXml( "<system-region name=\"DEFAULT\"/>" )->edit();
    }

    // the configuration sets
    // retrieve the root container
    $root_pcs_container  = $admin->getAsset(
        a\PageConfigurationSetContainer::TYPE, $ROOT_PATH, $site_name );
    // retrieve the startup format
    $startup_format = $admin->getAsset( a\ScriptFormat::TYPE, "/core/startup", $site_name );

    // the names of config sets are identical to the names of content types
    foreach( $content_type_names as $pcs_name )
    {
        $pcs = $admin->getPageConfigurationSet( $ROOT_PATH . $pcs_name );
        
        if( is_null( $pcs ) )
        {
            $pcs = $cascade->createPageConfigurationSet(
                    $root_pcs_container, // parent container
                    $pcs_name,           // configuration set name
                    $pcs_name,           // default configuration name
                    $template,           // template
                    ( $pcs_name == "Page" ? '.php' : ( $pcs_name == "RSS" ? ".rss" : ".xml" ) ),           
                    ( $pcs_name == "Page" ? c\T::HTML : c\T::XML )
                )->
                // attach the startup format to the DEFAULT region at config level
                setConfigurationPageRegionFormat( 
                    $pcs_name, 'DEFAULT', $startup_format )->
                setPublishable( $pcs_name, true )->
                edit();
        }
        
        if( $pcs_name == "Page" )
        {
            $pcs->setFormat( $pcs_name, 
                $admin->getAsset( a\XsltFormat::TYPE, "core/page-template", $site_name ) 
            )->edit();
        }
    }
    
    // the content types
    // retrieve the root container
    $root_ct_container  = $admin->getAsset(
        a\ContentTypeContainer::TYPE, $ROOT_PATH, $site_name );

    foreach( $content_type_names as $ct_name )
    {
        $ct = $admin->getContentType( $ROOT_PATH . $ct_name );
        
        if( is_null( $ct ) )
        {
            $ct = $cascade->createContentType(
                $root_ct_container,
                $ct_name,
                $cascade->getAsset(
                    a\PageConfigurationSet::TYPE, 
                    $ct_name, $site_name ),
                $cascade->getAsset(
                    a\MetadataSet::TYPE,
                    $ct_name, $site_name ),
                ( 
                    ( $ct_name == "Page" ?
                        $cascade->getAsset(
                            a\DataDefinition::TYPE,
                            $ct_name, $site_name ) : NULL
                    )
                )
            );
        }
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