<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/****************************************************************************************************
                                        Add Theme Support
****************************************************************************************************/

add_action( 'after_setup_theme', 'mw_theme_setup' );

function mw_theme_setup() {

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    
    // add_theme_support( 'responsive-embeds' );
    // add_theme_support( 'post-formats', array( 'video' ) );

    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'script',
            'style',
        )
    );

    // add_image_size( 'small', 230, 140, true );
}

/*****************************************************************************************************
                                        Register Menus
*****************************************************************************************************/
function mw_register_custom_menus() {

    register_nav_menu('main_menu', __('Main Menu', 'emosaweq') );
    register_nav_menu('top_menu', __('Topbar Menu', 'emosaweq') );
    // register_nav_menu('foot_menu', __('Footer Menu', 'emosaweq') );

}

add_action( 'init', 'mw_register_custom_menus' );

/*****************************************************************************************************
 *                                          Enqueue Scripts
 ****************************************************************************************************/

function mw_register_theme_scripts() {
    
    wp_dequeue_style( 'wp-block-library' );
    
    if ( is_single() || is_page() ) {
        wp_enqueue_style( 'single', get_template_directory_uri() . '/dist/css/single.css', false, '1.0' );
    }
    else {
        wp_enqueue_style( 'general', get_template_directory_uri() . '/dist/css/home.css', false, '1.0' );
    }
    wp_enqueue_style( 'tajawal', 'https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;600&display=swap', false, null );
    
    wp_enqueue_script( 'general', get_template_directory_uri() . '/dist/js/general.js', array(), null, true );
}

add_action( 'wp_enqueue_scripts', 'mw_register_theme_scripts' );

/*****************************************************************************************************
 *                                          Limit Excerpt Words
 ****************************************************************************************************/
function mw_custom_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'mw_custom_excerpt_length', 999 );