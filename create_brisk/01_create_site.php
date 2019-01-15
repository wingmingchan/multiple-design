<?php
/*/
This program creates the multiple-design, tree-driven master site; namely, Brisk.
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

    try
    {
        $admin->getSite( $site_name );
    }
    // create the site
    catch( e\NoSuchSiteException $e )
    {
        $url = 'myorg.edu/mydir';
        
        $admin->createSite(
            $site_name,
            $url,
            c\T::FIFTEEN // expiration: 15 days
        );
        // other site settings
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