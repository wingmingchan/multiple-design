<?php
/*
This program switches the content type of pages, copies the text from
display name to H1, and attach a block, if there is one from the old
page, to the new page. The block is responsible for generating the page
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
    $folder = $cascade->getAsset( a\Folder::TYPE, "8d3a3ee78b7f08ee37c14fb2550836e7" );

    $ct = $cascade->getAsset( a\ContentType::TYPE, "b8e761968b7f08ee5b5abc1aef5eaea1" );
    $children = $folder->getChildren();
    
    foreach( $children as $child )
    {
        if( $child->getType() == a\Page::TYPE )
        {
            $page         = $child->getAsset( $service );
            $page_content = $page->getText( "main-content-content" );
            $block_id     = $page->getBlockId( "post-title-chooser" );
            $block        = null;
            
            if( isset( $block_id ) )
            {
                $block = $cascade->getAsset( a\XmlBlock::TYPE, $block_id );
            }
            
            try
            {
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
                
                if( isset( $block )    )
                {
                    echo "Setting block", BR;
                    $phantom_page->setBlock( "pre-wysiwyg-chooser;0", $block );
                }
                
                if( isset( $page_content ) )
                {
                    $phantom_page->setText( "wysiwyg", $page_content );
                }
                
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
?>