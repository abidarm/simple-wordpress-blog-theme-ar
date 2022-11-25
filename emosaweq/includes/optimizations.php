<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	
	// Remove from TinyMCE
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter out the tinymce emoji plugin.
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/*====================== Remove Unused Plugin Scripts ======================*/
add_action( 'wp_enqueue_scripts', 'mw_remove_unused_scripts', 99999, 0 );

function mw_remove_unused_scripts() {
	wp_deregister_script( 'wp-embed' );
	wp_deregister_script( 'jquery' );
}

/*====================== Move Jquery To Footer ======================*/
// add_action( 'wp_enqueue_scripts', 'mw_optimize_jquery_enqueue', 9, 0 );

// function mw_optimize_jquery_enqueue() {
// 	wp_enqueue_script( 'jquery', '/wp-includes/js/jquery/jquery.min.js', array(), false, true );
// }


/*====================== Add Defer Attribute to scripts ======================*/
add_filter('script_loader_tag', 'mw_optimize_add_defer_attribute', 10, 2);

function mw_optimize_add_defer_attribute($tag, $handle) {
    if ( strpos($tag, ' async') !== false ) {
        return str_replace(' src=', ' defer="defer" src=', $tag);
    }
    return $tag;
}

/*====================== Add Preload for styles  ======================*/
add_filter('style_loader_tag', 'mw_optimize_add_preload_for_styles', 10, 4);

function mw_optimize_add_preload_for_styles($html, $handle, $href, $media) {
	$excludes = array(
		'general',
		'single'
	);
	if( ! in_array( $handle, $excludes ) ) {
		$html = '<link id="'. $handle .'" rel="preload" href="'. $href .'" as="style" onload="this.onload=null;this.rel=\'stylesheet\'" media="'. $media .'"><noscript><link id="'. $handle .'" rel="stylesheet" href="'. $href .'" media="'. $media .'"></noscript>';
	}
    return $html;
}
