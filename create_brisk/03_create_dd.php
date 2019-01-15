<?php
/*/
This program creates the data definitions.
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

    // retrieve the root container
    $root_dd_container  = $admin->getAsset(
        a\DataDefinitionContainer::TYPE, $ROOT_PATH, $site_name );

    foreach( $dd_names_urls as $dd_name => $dd_url )
    {
        $dd = $admin->getDataDefinition( $ROOT_PATH . $dd_name );
        
        if( is_null( $dd ) )
        {
            // throw in a dummy wysiwyg
            $dd = $admin->createDataDefinition(
                $root_dd_container, $dd_name, "<system-data-structure>
    <text identifier=\"wysiwyg\" label=\"Wysiwyg\" wysiwyg=\"true\"/>
</system-data-structure>" );
            sleep( 5 );
        }
        
        $xml = file_get_contents( $dd_url ).trim();
        
        if( $xml != "" )
        {
            $dd->setXml( $xml )->edit();
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