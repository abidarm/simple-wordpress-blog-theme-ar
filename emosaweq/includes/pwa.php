<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_filter( 'init', 'my_custom_page_template' );

function my_custom_page_template() {

    $request_url = mw_requested_url();

    if( $request_url == '/sw-desktop.js' ) {
        header ('Content-Type: application/javascript');
        echo file_get_contents(__DIR__ . '/../desktop/assets/js/sw.js');
        exit;
    }

    else if( $request_url == '/sw-mobile.js' ) {
        header ('Content-Type: application/javascript');
        echo file_get_contents(__DIR__ . '/../mobile/assets/js/sw.js');
        exit;
    }

}