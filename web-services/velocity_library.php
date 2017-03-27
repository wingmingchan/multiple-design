<?php
/*
This program switches the content type of pages, copies the text from
display name to H1, and attach a unique block to a block chooser. This
single block is responsible for generating the page contents.
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
    $ct = $cascade->getAsset( a\ContentType::TYPE, "b8e761968b7f08ee5b5abc1aef5eaea1" );
    $block = $cascade->getAsset(
        a\XmlBlock::TYPE, "49a264f68b7f08ee0dc41f8a635ef5f4" );
    $folder = $cascade->getAsset( a\Folder::TYPE, "bb0f675a8b7f08ee1788f4e0f4d4e5ec" );
    $children = $folder->getChildren();
    
    foreach( $children as $child )
    {
        if( $child->getType() == a\Page::TYPE )
        {
            if( $child->getPathPath() != "standard-model/velocity-library/index" )
            {
                try
                {
                    echo "Reloading", BR;
                    $page = $child->getAsset( $service );
                    $page->setContentType( $ct );
                    $page->reloadProperty();
                }
                catch( e\NoSuchFieldException $e )
                {
                    $phantom_page = new a\PagePhantom(
                        $service, $service->createId(
                            a\PagePhantom::TYPE, $child->getId() ) );
                    $dd = $ct->getDataDefinition();
                    $healthy_sd = new p\StructuredData( 
                        $dd->getStructuredData(), $service, $dd->getId() );
                    $phantom_page->setStructuredData(
                        $healthy_sd );
                    $phantom_page->setBlock( "pre-wysiwyg-chooser;0", $block )->
                        setText( "h1", $page->getName() )->
                        edit();
                }
            }
        }
    }    
}
catch( e\NoSuchFieldException $e )
{
    echo S_PRE . "Thrown here" . E_PRE; 
    echo S_PRE . $e . E_PRE; 
}
catch( \Exception $e ) 
{
    echo S_PRE . $e . E_PRE; 
}
catch( \Error $er )
{
    echo S_PRE . $er . E_PRE; 
}
/*
Useful code templates:
    u\ReflectionUtility::showMethodSignatures( 
        "cascade_ws_utility\ReflectionUtility" );
        
    u\ReflectionUtility::showMethodSignature( 
        "cascade_ws_asset\Page", "edit" );
        
    u\ReflectionUtility::showMethodDescription( 
        "cascade_ws_utility\ReflectionUtility", "getMethodInfoByName", true );
        
    u\ReflectionUtility::showMethodExample( 
        "cascade_ws_utility\ReflectionUtility", "getMethodInfoByName", true );

    u\DebugUtility::dump( $page );
    echo u\StringUtility::getCoalescedString( $m->getEndDate() ), BR;

    $cascade->getAsset( a\Page::TYPE, "389b32a68b7ffe83164c931497b7bc24" )->dump();
*/
?>