<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * LDNGT_Gutenberg_Toolkit_Blocks
 */
class LDNGT_Gutenberg_Toolkit_Blocks {
    
    /**
     * @var self
     */
    private static $instance = null;

    /**
     * @since 1.0
     * @return $this
     */
    public static function instance() {
        
        if ( is_null( self::$instance ) && ! ( self::$instance instanceof LDNGT_Gutenberg_Toolkit_Blocks ) ) {
            self::$instance = new self;
            self::$instance->hooks();
        }
        
        return self::$instance;
    }

    /**
     * Registers the block using the metadata loaded from the `block.json` file.
     * Behind the scenes, it registers also all assets so they can be enqueued
     * through the block editor in the corresponding context.
     *
     * @see https://developer.wordpress.org/reference/functions/register_block_type/
     */
    function block_init() {
        $args = array();
        
        //$args['render_callback'] = 'ldngt_render_spacer_block';
        $args['category'] = 'ldngt-gutenberg-blocks';
        $args['attributes'] = array(
                            "divider_type" => array(
                                "type" => "string",
                                "default" => "custom"
                            ),
                            "custom_text"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "color"  => array(
                                "type" => "string",
                                "default" => "black"
                            ),
                            "icon_image_height"  => array(
                                "type" => "string",
                                "default" => "25px"
                            ),
                            "height"  => array(
                                "type" => "string",
                                "default" => 1
                            ),
                            "imgID"  => array(
                                "type" => "number",
                                "default" => 0
                            ),
                            "imgURL"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "gradient"  => array(
                                "type" => "string",
                                "default" => "linear-gradient( 45deg, red , yellow )"
                            ),
                            "emojiunified"  => array(
                                "type" => "string",
                                "default" => "1f642"
                            ),
                            "emojiurl"  => array(
                                "type" => "string",
                                "default" => "https://cdn.jsdelivr.net/npm/emoji-datasource-apple/img/apple/64/1f642.png"
                            ),
                            //Global attrs replications
                            "ldngt_color" => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_backcolor" => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_backgroundtype" => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_backimageurl" => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_backimageid" => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_borderstyle" => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_width"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_height"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_marginunit" => array(
                                "type" => "string",
                                "default" => "px"
                            ),
                            "ldngt_fontsize" => array(
                                "type" => "string",
                                "default" => "12px"
                            ),
                            
                            "ldngt_fontfamily" => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            
                            "ldngt_paddingunit" => array(
                                "type" => "string",
                                "default" => "px"
                            ),
                            
                            "ldngt_wrapper_id"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_wrapper_classes"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_hideforroles"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_margin_top"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_margin_right"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_margin_bottom"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_margin_left"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_padding_top"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_padding_right"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_padding_bottom"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_padding_left"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            
                            "ldngt_hidetablet"  => array(
                                "type" => "boolean",
                                "default" => false
                            ),
                            "ldngt_hideonmobile"  => array(
                                "type" => "boolean",
                                "default" => false
                            ),
                            "ldngt_hideondesktop"  => array(
                                "type" => "boolean",
                                "default" => false
                            ),
                            "ldngt_hideonbigscreens"  => array(
                                "type" => "boolean",
                                "default" => false
                            ),
                            "ldngt_enablehideforroles"  => array(
                                "type" => "boolean",
                                "default" => false
                            ),
                            
                            "ldngt_hideforloggedoutuser"  => array(
                                "type" => "boolean",
                                "default" => false
                            ),
                            "ldngt_shadowinset"  => array(
                                "type" => "boolean",
                                "default" => false
                            ),
                            "ldngt_bordercolor"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_border_radius_unit"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_border_radiusleft"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_border_radius_bottom"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_border_radius_right"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_border_radius_top"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_borderunit"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_border_top"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_border_right"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_border_bottom"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_borderleft"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_shadowcolor"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_hoffset"  => array(
                                "type" => "string",
                                "default" => ""
                            ),
                            "ldngt_voffset"  => array(
                                "type" => "string",
                                "default" => ""
                            ),

                            "ldngt_isbold"  => array(
                                "type" => "boolean",
                                "default" => false
                            ),
                            "ldngt_isitalic"  => array(
                                "type" => "boolean",
                                "default" => false
                            ),
                            "ldngt_decoration"  => array(
                                "type" => "string",
                                "default" => ''
                            )
                        );

        register_block_type( LDNGT_DIR . 'blocks/build/divider-block', $args );
    }
    
    /**
     * Plugin Constants
     */
    private function hooks() {
        
        add_action( 'init', [ $this, 'block_init' ] );
    }
}

LDNGT_Gutenberg_Toolkit_Blocks::instance();