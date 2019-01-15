<?php
/*/
This program creates the metadata sets.
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
    $root_ms_container  = $admin->getAsset(
        a\MetadataSetContainer::TYPE, $ROOT_PATH, $site_name );
    
    foreach( $metadata_set_names as $ms_name )
    {
        $ms = $admin->getMetadataSet( $ROOT_PATH . $ms_name );
        
        if( is_null( $ms ) )
        {
            $ms = $admin->createMetadataSet( $root_ms_container, $ms_name );
        }
        
        switch( $ms_name )
        {
            case "Block":
                $ms->
                    // hide all wired fields
                    setAuthorFieldVisibility( a\MetadataSet::HIDDEN )->
                    setDescriptionFieldVisibility( a\MetadataSet::HIDDEN )->
                    setDisplayNameFieldVisibility( a\MetadataSet::HIDDEN )->
                    setEndDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setExpirationFolderFieldVisibility( a\MetadataSet::HIDDEN )->
                    setKeywordsFieldVisibility( a\MetadataSet::HIDDEN )->
                    setReviewDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setStartDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setSummaryFieldVisibility( a\MetadataSet::HIDDEN )->
                    setTeaserFieldVisibility( a\MetadataSet::HIDDEN )->
                    setTitleFieldVisibility( a\MetadataSet::HIDDEN )->edit();
                
                $field_name = "macro";
                // add dynamic field if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,  // field name
                        c\T::TEXT,    // type
                        'Macro',      // label
                        false,        // required
                        c\T::INLINE,  // visibility
                        "",           // possible value
                        "Enter the name of the macro to be " . 
                        "invoked to process this block." // help text
                    );
                break;
            case "Folder":
                $ms->
                    // hide all wired fields except display name
                    setAuthorFieldVisibility( a\MetadataSet::HIDDEN )->
                    setDescriptionFieldVisibility( a\MetadataSet::HIDDEN )->
                    setDisplayNameFieldRequired( true )->
                    setDisplayNameFieldVisibility( a\MetadataSet::INLINE )->
                    setEndDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setExpirationFolderFieldVisibility( a\MetadataSet::HIDDEN )->
                    setKeywordsFieldVisibility( a\MetadataSet::HIDDEN )->
                    setReviewDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setStartDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setSummaryFieldVisibility( a\MetadataSet::HIDDEN )->
                    setTeaserFieldVisibility( a\MetadataSet::HIDDEN )->
                    setTitleFieldVisibility( a\MetadataSet::HIDDEN )->edit();
                
                $field_name = "exclude-from-menu";
                // add dynamic fields if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,
                        c\T::CHECKBOX,
                        "Exclude from top menu bar (desktop classic and mega menu)",
                        false,
                        c\T::VISIBLE,
                        "yes"
                    );
                $field_name = "exclude-from-left-folder-nav";
                // add dynamic fields if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,
                        c\T::CHECKBOX,
                        "Exclude from left menu nav (desktop)",
                        false,
                        c\T::VISIBLE,
                        "yes"
                    );
                $field_name = "exclude-from-mobile-menu";
                // add dynamic fields if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,
                        c\T::CHECKBOX,
                        "Exclude from mobile menu",
                        false,
                        c\T::VISIBLE,
                        "yes"
                    );
                break;
            case "Image":
                $ms->
                    // hide all wired fields except summary
                    setAuthorFieldVisibility( a\MetadataSet::HIDDEN )->
                    setDescriptionFieldVisibility( a\MetadataSet::HIDDEN )->
                    setDisplayNameFieldVisibility( a\MetadataSet::HIDDEN )->
                    setEndDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setExpirationFolderFieldVisibility( a\MetadataSet::HIDDEN )->
                    setKeywordsFieldVisibility( a\MetadataSet::HIDDEN )->
                    setReviewDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setStartDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setSummaryFieldRequired( true )->
                    setSummaryFieldVisibility( a\MetadataSet::INLINE )->
                    setSummaryFieldHelpText(
                        "In a sentence or two describe what this image conveying. " . 
                        "This summary will be used to aid visually impaired website users." )->
                    setTeaserFieldVisibility( a\MetadataSet::HIDDEN )->
                    setTitleFieldVisibility( a\MetadataSet::HIDDEN )->edit();
                break;
            case "Page":
                $ms->
                    setAuthorFieldVisibility( a\MetadataSet::VISIBLE )->
                    setAuthorFieldHelpText( "For multiple authors, separate with a semicolin \";\"" )->
                    setDescriptionFieldVisibility( a\MetadataSet::HIDDEN )->
                    setDisplayNameFieldRequired( true )->
                    setDisplayNameFieldVisibility( a\MetadataSet::INLINE )->
                    setDisplayNameFieldHelpText( "The Display Name is the name to be " .
                        "showed in the menus and breadcrumbs." )->
                    setEndDateFieldVisibility( a\MetadataSet::VISIBLE )->
                    setExpirationFolderFieldVisibility( a\MetadataSet::HIDDEN )->
                    setKeywordsFieldVisibility( a\MetadataSet::HIDDEN )->
                    setReviewDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setStartDateFieldVisibility( a\MetadataSet::VISIBLE )->
                    setSummaryFieldVisibility( a\MetadataSet::VISIBLE )->
                    setSummaryFieldHelpText( "Short sentence (used in news sites)" )->
                    setTeaserFieldVisibility( a\MetadataSet::HIDDEN )->
                    setTitleFieldRequired( true )->
                    setTitleFieldVisibility( a\MetadataSet::INLINE )->
                    setTitleFieldHelpText( "The Title string will be showed in the <title> element." )->
                    edit();
                $field_name = "article-sub-headline";
                // add dynamic fields if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,
                        c\T::TEXT,
                        "Article News Feed Image Caption",
                        false,
                        c\T::VISIBLE,
                        "",
                        "A short caption (20 characters or less) to be placed in " .
                        "the bottom-right corner of an image. Usually this is an event " .
                        "date such as \"Nov 16\""
                    );
                $field_name = "exclude-from-menu";
                // add dynamic fields if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,
                        c\T::CHECKBOX,
                        "Exclude from top menu bar (desktop classic and mega menu)",
                        false,
                        c\T::VISIBLE,
                        "yes",
                        ""
                    );
                $field_name = "exclude-from-left-folder-nav";
                // add dynamic fields if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,
                        c\T::CHECKBOX,
                        "Exclude from left menu nav (desktop)",
                        false,
                        c\T::VISIBLE,
                        "yes",
                        ""
                    );
                $field_name = "exclude-from-mobile-menu";
                // add dynamic fields if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,
                        c\T::CHECKBOX,
                        "Exclude from mobile menu",
                        false,
                        c\T::VISIBLE,
                        "yes",
                        ""
                    );
                $field_name = "tree-picker";
                // add dynamic fields if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,
                        c\T::DROPDOWN,
                        "Main Tree Picker",
                        false,
                        c\T::VISIBLE,
                        "inherited;center;left-center;center-right;3-column",
                        ""
                    );
                // set the default selection
                $ms->getDynamicMetadataFieldDefinition( $field_name )->
                    setSelectedByDefault( "inherited" );
                $ms->edit();
                break;
            case "RSS":
                $ms->
                    setAuthorFieldVisibility( a\MetadataSet::HIDDEN )->
                    setDescriptionFieldVisibility( a\MetadataSet::VISIBLE )->
                    setDescriptionFieldHelpText( "This will be used as the channel description" )->
                    setDisplayNameFieldVisibility( a\MetadataSet::HIDDEN )->
                    setEndDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setExpirationFolderFieldVisibility( a\MetadataSet::HIDDEN )->
                    setKeywordsFieldVisibility( a\MetadataSet::HIDDEN )->
                    setReviewDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setStartDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setSummaryFieldVisibility( a\MetadataSet::HIDDEN )->
                    setTeaserFieldVisibility( a\MetadataSet::HIDDEN )->
                    setTitleFieldVisibility( a\MetadataSet::VISIBLE )->
                    setTitleFieldHelpText( "This will be used as the channel title" )->
                    edit();
                break;
            case "Setup":
                $ms->
                    // hide all wired fields
                    setAuthorFieldVisibility( a\MetadataSet::HIDDEN )->
                    setDescriptionFieldVisibility( a\MetadataSet::HIDDEN )->
                    setDisplayNameFieldVisibility( a\MetadataSet::HIDDEN )->
                    setEndDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setExpirationFolderFieldVisibility( a\MetadataSet::HIDDEN )->
                    setKeywordsFieldVisibility( a\MetadataSet::HIDDEN )->
                    setReviewDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setStartDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setSummaryFieldVisibility( a\MetadataSet::HIDDEN )->
                    setTeaserFieldVisibility( a\MetadataSet::HIDDEN )->
                    setTitleFieldVisibility( a\MetadataSet::HIDDEN )->edit();
                $field_name = "macro";
                // add dynamic field if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,  // field name
                        c\T::TEXT,    // type
                        'Macro',      // label
                        false,        // required
                        c\T::INLINE,  // visibility
                        "",           // possible value
                        "The name of the macro used to process the block" // help text
                    );
                $field_name = "html-tree-picker";
                // add dynamic field if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,  // field name
                        c\T::TEXT,    // type
                        "HTML Tree Picker", // label
                        false,        // required
                        c\T::VISIBLE,  // visibility
                        "",           // possible value
                        "Enter the format name here. " .
                        "The format should be in site://$site_name/app/scaffolds" // help text
                    );
                $field_name = "main-tree-picker";
                // add dynamic fields if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,
                        c\T::DROPDOWN,
                        "Main Tree Picker",
                        true,
                        c\T::VISIBLE,
                        "inherited;center;left-center;center-right;3-column",
                        "Pick a subtree to control page layout"
                    );
                // set the default selection
                $ms->getDynamicMetadataFieldDefinition( $field_name )->
                    setSelectedByDefault( "inherited" );
                $ms->edit();
                break;
            case "Symlink":
                $ms->
                    setAuthorFieldVisibility( a\MetadataSet::VISIBLE )->
                    setDescriptionFieldVisibility( a\MetadataSet::HIDDEN )->
                    setDisplayNameFieldRequired( true )->
                    setDisplayNameFieldVisibility( a\MetadataSet::INLINE )->
                    setEndDateFieldVisibility( a\MetadataSet::VISIBLE )->
                    setExpirationFolderFieldVisibility( a\MetadataSet::HIDDEN )->
                    setKeywordsFieldVisibility( a\MetadataSet::HIDDEN )->
                    setReviewDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setStartDateFieldVisibility( a\MetadataSet::VISIBLE )->
                    setSummaryFieldVisibility( a\MetadataSet::VISIBLE )->
                    setTeaserFieldVisibility( a\MetadataSet::HIDDEN )->
                    setTitleFieldVisibility( a\MetadataSet::HIDDEN )->
                    edit();
                $field_name = "article-sub-headline";
                // add dynamic fields if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,
                        c\T::TEXT,
                        "Article subheadline",
                        false,
                        c\T::VISIBLE,
                        "",
                        "eg. \"May 4\", \"Sept 23\", \"Nov 1\""
                    );
                $field_name = "exclude-from-menu";
                // add dynamic fields if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,
                        c\T::CHECKBOX,
                        "Exclude from top menu bar (desktop classic and mega menu)",
                        false,
                        c\T::VISIBLE,
                        "yes",
                        ""
                    );
                $field_name = "exclude-from-left-folder-nav";
                // add dynamic fields if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,
                        c\T::CHECKBOX,
                        "Exclude from left menu nav (desktop)",
                        false,
                        c\T::VISIBLE,
                        "yes",
                        ""
                    );
                $field_name = "exclude-from-mobile-menu";
                // add dynamic fields if non-existent    
                if( !$ms->hasDynamicMetadataFieldDefinition( $field_name ) )
                    $ms->addField( 
                        $field_name,
                        c\T::CHECKBOX,
                        "Exclude from mobile menu",
                        false,
                        c\T::VISIBLE,
                        "yes",
                        ""
                    );
                break;
            case "XML":
                $ms->
                    // hide all wired fields except display name
                    setAuthorFieldVisibility( a\MetadataSet::HIDDEN )->
                    setDescriptionFieldVisibility( a\MetadataSet::HIDDEN )->
                    setDisplayNameFieldVisibility( a\MetadataSet::VISIBLE )->
                    setEndDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setExpirationFolderFieldVisibility( a\MetadataSet::HIDDEN )->
                    setKeywordsFieldVisibility( a\MetadataSet::HIDDEN )->
                    setReviewDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setStartDateFieldVisibility( a\MetadataSet::HIDDEN )->
                    setSummaryFieldVisibility( a\MetadataSet::HIDDEN )->
                    setTeaserFieldVisibility( a\MetadataSet::HIDDEN )->
                    setTitleFieldVisibility( a\MetadataSet::HIDDEN )->edit();
                break;
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