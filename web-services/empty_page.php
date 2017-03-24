<?php
/*
This program switches the content type of pages, copies the text from
display name to H1, and leave other fields empty. The resulting pages can
be populated with contents generated by other programs.
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
    $folder = $cascade->getAsset( a\Folder::TYPE, "96b7e8468b7f08ee71339a166cf9930e" );
    $children = $folder->getChildren();
    
    foreach( $children as $child )
    {
        if( $child->getType() == a\Page::TYPE )
        {
            try
            {
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
                    
                $phantom_page->setText( "h1",
                        $phantom_page->getMetadata()->getDisplayName() )->
                    edit();
            }
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