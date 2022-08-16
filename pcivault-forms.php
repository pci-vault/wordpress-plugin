<?php

/*
Plugin Name: PCI Vault forms
Plugin URI: https://pcivault.io
Description: A brief description of the Plugin.
Version: 0.0.0
Author: PCI Vault
Author URI: https://pcivault.io
License: MIT
*/

function pcivault_shortcode( $atts = [], $content = null, $tag = '' ) {
    $args = array(
        'headers' => array(
            'Authorization' => 'Basic ' . base64_encode( 'example' . ':' . 'example' )
        )
    );

    $response = wp_remote_post('https://api.pcivault.io/v1/capture?user='.'example'.'&passphrase='.'example', $args);
    $body =  wp_remote_retrieve_body($response);
    $parsed_body = json_decode($body, true);

    return '
    <link rel="stylesheet" href="https://api.pcivault.io/pcd/pcd_form.css" />
    <script src="https://api.pcivault.io/pcd/pcd_form.js"></script>
    
    <div id="pcivault_pcd_form"></div>

    <script defer>
        window.pcd_form(document.getElementById("pcivault_pcd_form"), {
            submit_secret: "'.$parsed_body["secret"].'",
            submit_url: "'.$parsed_body["url"].'"
        })
    </script>
    ';
}

/**
 * Central location to create all shortcodes.
 */
function pcivault_shortcodes_init() {
    add_shortcode( 'pcivault', 'pcivault_shortcode' );
}

add_action( 'init', 'pcivault_shortcodes_init' );
