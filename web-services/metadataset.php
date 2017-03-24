<?php
/*
This program associates assets with the appropriate metadata sets. Note that data
definition blocks are not dealt with here. We need to fix phantom nodes and
values first.
*/
require_once( 'auth_chanw.php' );

use cascade_ws_AOHS      as aohs;
use cascade_ws_constants as c;
use cascade_ws_asset     as a;
use cascade_ws_property  as p;
use cascade_ws_utility   as u;
use cascade_ws_exception as e;

$site_name = "cascade-admin";

try
{
    $params = array();
    // folder
    $params[ a\Folder::TYPE ][ a\MetadataSet::TYPE ] =
        $cascade->getAsset( a\MetadataSet::TYPE, "b8e7624f8b7f08ee5b5abc1a9d488f66" );
    // block    
    $params[ a\TextBlock::TYPE ][ a\MetadataSet::TYPE ] =
        $cascade->getAsset( a\MetadataSet::TYPE, "b8e762348b7f08ee5b5abc1a00fdf9ab" );
    $params[ a\IndexBlock::TYPE ][ a\MetadataSet::TYPE ] =
        $cascade->getAsset( a\MetadataSet::TYPE, "b8e762348b7f08ee5b5abc1a00fdf9ab" );
    $params[ a\XmlBlock::TYPE ][ a\MetadataSet::TYPE ] =
        $cascade->getAsset( a\MetadataSet::TYPE, "b8e762348b7f08ee5b5abc1a00fdf9ab" );
    $params[ a\DataBlock::TYPE ][ a\MetadataSet::TYPE ] =
        $cascade->getAsset( a\MetadataSet::TYPE, "b8e762348b7f08ee5b5abc1a00fdf9ab" );
    $params[ a\FeedBlock::TYPE ][ a\MetadataSet::TYPE ] =
        $cascade->getAsset( a\MetadataSet::TYPE, "b8e762348b7f08ee5b5abc1a00fdf9ab" );
    // symlink
    $params[ a\Symlink::TYPE ][ a\MetadataSet::TYPE ] =
        $cascade->getAsset( a\MetadataSet::TYPE, "b8e7623d8b7f08ee5b5abc1a43ffa834" );

    $cascade->getSite( $site_name )->getAssetTree()->
        traverse(
            array( a\Folder::TYPE => array( "assetTreeAssociateWithMetadataSet" ),
                   a\TextBlock::TYPE => array( "assetTreeAssociateWithMetadataSet" ),
                   a\IndexBlock::TYPE => array( "assetTreeAssociateWithMetadataSet" ),
                   a\XmlBlock::TYPE => array( "assetTreeAssociateWithMetadataSet" ),
                   a\FeedBlock::TYPE => array( "assetTreeAssociateWithMetadataSet" ),
                   a\Symlink::TYPE => array( "assetTreeAssociateWithMetadataSet" ),
            ),
            $params
        );
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