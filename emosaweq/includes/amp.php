<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

use KubAT\PhpSimple\HtmlDomParser;

// flush rewrite rules
add_action( 'init', 'emosaweq_rewrites_init_add_amp_page' );
function emosaweq_rewrites_init_add_amp_page(){
    add_rewrite_rule(
        'amp/([0-9]+).html[/]?$',
        'index.php?pagename=amp&post_id=$matches[1]',
        'top'
    );
}

add_filter( 'query_vars', 'emosaweq_amp_query_vars' );
function emosaweq_amp_query_vars( $query_vars ){
    $query_vars[] = 'post_id';
    return $query_vars;
}


add_action( 'template_include', function( $template ) {

    if ( get_query_var( 'pagename' ) != 'amp' ) {
        return $template;
    }

    status_header(200);
 
    return get_template_directory() . '/mobile/amp.php';
} );


/*=====================================================================================
                                    Filter AMP Tags
=====================================================================================*/

add_filter( 'the_content', 'mw_filter_amp_tags', 9999 );

function mw_filter_amp_tags( $content ) {

    if ( get_query_var( 'pagename' ) != 'amp' || ! is_main_query() ) {
        return $content;
    }

    global $post;
    $post_id = $post->ID;

    $replacedTags = array(
        'img' => array(
            'tag' => 'amp-img',
            'default_attributes' => array(
                'width' => 16,
                'height' => 16,
            ),
            'attributes' => array(
                'layout' => 'responsive',
                'loading' => null
            ),
        ),
        'iframe' => array(
            'tag' => 'amp-iframe',
            'attributes' => array(
                'width' => '480',
                'loading' => null,
                'layout' => 'responsive',
                'sandbox' => 'allow-scripts allow-same-origin'
            )
        ),
        'video' => array(
            'tag' => 'amp-video',
            'attributes' => array(
                'layout' => 'responsive',
                'loading' => null,
                'preload' => null,
                // 'id' => null
            )
        )
    );


    $html = HtmlDomParser::str_get_html( $content );

    foreach($replacedTags as $replacedTag => $replaceWith) {
        $tags = $html->find( $replacedTag );

        foreach($tags as $tag) {
            $tag->tag = $replaceWith['tag'];

            // Default attributes
            if( array_key_exists( 'default_attributes', $replaceWith ) ) {
                foreach( $replaceWith['default_attributes'] as $def_attribute => $def_value ) {
                    $tag->$def_attribute = $def_value;
                }
            }
    
            // New attributes
            if( array_key_exists( 'attributes', $replaceWith ) ) {
                foreach( $replaceWith['attributes'] as $new_attribute => $new_value ) {
                    $tag->$new_attribute = $new_value;
                }
            }

            // If is video tag, add poster img
            if( $replacedTag == 'video' ) {
                $tag->poster = get_the_post_thumbnail_url($post_id, 'th-lg');
            }

            // If is iframe, add placeholder img
            if( $replacedTag == 'iframe' ) {
                $placeholder = $html->createElement( 'amp-img' );
                $placeholder->layout = 'fill';
                $placeholder->src = get_the_post_thumbnail_url($post_id, 'th-lg');
                $placeholder->placeholder = '';
                $tag->appendChild( $placeholder );
            }
            
        }
    }

    return $html->save();
}