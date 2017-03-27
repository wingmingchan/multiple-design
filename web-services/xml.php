<?php
/*
This program switches the content type of XML pages, and reattach a format
to the DEFAULT regoin. The format is responsible for generating the XML
contents.
*/
require_once( 'auth_chanw.php' );

use cascade_ws_AOHS      as aohs;
use cascade_ws_constants as c;
use cascade_ws_asset     as a;
use cascade_ws_property  as p;
use cascade_ws_utility   as u;
use cascade_ws_exception as e;

try
{
    $ct = $cascade->getAsset( a\ContentType::TYPE, "f1dfe84b8b7f08ee57eeeebafde4c605" );
    $format = $cascade->getAsset(
        a\ScriptFormat::TYPE, "77e8ba858b7f08ee495d8956d3125494" );
    $folder = $cascade->getAsset( a\Folder::TYPE, "b95262048b7f08ee67c19cca965ed1da" );
    $children = $folder->getChildren();
    
    foreach( $children as $child )
    {
        $page = $child->getAsset( $service );
        
        if( $child->getPathPath() != "standard-model/source/index" )
        {
            $page->setContentType( $ct );
            $page->setRegionFormat( "XML", "DEFAULT", $format )->edit();
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