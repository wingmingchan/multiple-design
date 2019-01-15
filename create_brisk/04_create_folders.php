<?php
/*/
This program creates the folders.
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

    // retrieve the Folder metadata set
    $folder_ms  = $admin->getAsset(
        a\MetadataSet::TYPE, $ROOT_PATH . "Folder", $site_name );
    
    foreach( $folder_names_parent_paths as $folder_name => $parent_path )
    {
        $folder = $admin->getFolder( "$parent_path/$folder_name", $site_name );
        
        if( is_null( $folder ) )
        {
            // get parent folder
            $parent_folder = $admin->getAsset( a\Folder::TYPE, $parent_path, $site_name );
            // create the folder
            $folder = $admin->createFolder( $parent_folder, $folder_name );
        }
        
        // set metadata set
        $folder->setMetadataSet( $folder_ms );
        // set mandatory display name
        $folder->getMetadata()->setDisplayName( $folder_name );
        // not indexable and not publishable
        $folder->setShouldBeIndexed( false )->setShouldBePublished( false )->edit();
        
        
    }
   
    // fix workflow settings of the base folder
    $base_folder = $admin->getAsset( a\Folder::TYPE, $ROOT_PATH, $site_name );
    $wf_settings = $base_folder->getWorkflowSettings();
    $wf_settings->setInheritWorkflows( false )->setRequireWorkflow( false );
    $base_folder->editWorkflowSettings( true, true );
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