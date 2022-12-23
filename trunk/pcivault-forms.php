<?php

/*
Plugin Name: PCI Vault Forms
Description: Securely capture card data using PCI Vault, which is a vendor neutral PCI DSS compliant environment.
Version: 1.0.2
Author: PCI Vault
Author URI: https://pcivault.io
License: MIT
*/

function pcivault_capture_shortcode($atts = [], $content = null, $tag = '')
{
    // normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);

    $atts = shortcode_atts(
        array(
            'success_callback' => '() => {}',
            'error_callback' => '() => {}',
            'extra_data' => '{}',
            'show_card' => 'true',
            'disable_luhn' => 'false',
            'force_keypad' => 'false',
            'field_options' => 'false',
        ), $atts, $tag
    );

    $options = get_option('pcivault_options');
    $user = $options['pcivault_field_user'];
    $password = $options['pcivault_field_password'];

    $args = array(
        'headers' => array(
            'Authorization' => 'Basic ' . base64_encode($user . ':' . $password)
        )
    );

    $key = $options['pcivault_field_key'];
    $passphrase = $options['pcivault_field_passphrase'];

    $response = wp_remote_post('https://api.pcivault.io/v1/capture?ttl=1h&user=' . $key . '&passphrase=' . $passphrase, $args);
    $body = wp_remote_retrieve_body($response);
    $parsed_body = json_decode($body, true);

    wp_enqueue_style("pcivault_capture_style", "https://api.pcivault.io/pcd/pcd_form.css");
    wp_enqueue_script("pcivault_capture_script", "https://api.pcivault.io/pcd/pcd_form.js", array(), false, false);

    return '
    <div id="pcivault_pcd_form"></div>
    <script defer>
        window.addEventListener("load", function(){
            window.pcd_form(document.getElementById("pcivault_pcd_form"), {
                submit_secret: "' . $parsed_body["secret"] . '",
                submit_url: "' . $parsed_body["url"] . '",
                success_callback: ' . $atts['success_callback'] . ',
                error_callback: ' . $atts['error_callback'] . ',
                extra_data: ' . $atts['extra_data'] . ',
                show_card: ' . $atts['show_card'] . ',
                disable_luhn: ' . $atts['disable_luhn'] . ',
                force_keypad: ' . $atts['force_keypad'] . ',
                field_options: ' . $atts['field_options'] . ',
            })
        })
    </script>';
}

function pcivault_settings_init()
{
    register_setting('pcivault', 'pcivault_options');

    add_settings_section(
        'pcivault_section_auth',
        __('Authorization Details', 'pcivault'), 'pcivault_section_auth_callback',
        'pcivault'
    );

    add_settings_field(
        'pcivault_field_user',
        __('User', 'pcivault'),
        'pcivault_field_cb',
        'pcivault',
        'pcivault_section_auth',
        array(
            'label_for' => 'pcivault_field_user',
            "description" => "Your PCI Vault Basic Auth Username"
        )
    );
    add_settings_field(
        'pcivault_field_password',
        __('Password', 'pcivault'),
        'pcivault_field_cb',
        'pcivault',
        'pcivault_section_auth',
        array(
            'label_for' => 'pcivault_field_password',
            "description" => "Your PCI Vault Basic Auth Password"
        )
    );
    add_settings_field(
        'pcivault_field_key',
        __('Key User', 'pcivault'),
        'pcivault_field_cb',
        'pcivault',
        'pcivault_section_auth',
        array(
            'label_for' => 'pcivault_field_key',
            "description" => "The user for the key you want to use to store cards.",
        )
    );
    add_settings_field(
        'pcivault_field_passphrase',
        __('Key Passphrase', 'pcivault'),
        'pcivault_field_cb',
        'pcivault',
        'pcivault_section_auth',
        array(
            'label_for' => 'pcivault_field_passphrase',
            "description" => "The passphrase for the key you want to use to store cards.",
        )
    );
}

function pcivault_section_auth_callback($args)
{
    ?>
    <p id="<?php echo esc_attr($args['id']); ?>"><?php esc_html_e('Auth Settings', 'pcivault'); ?></p>
    <?php
}

function pcivault_field_cb($args)
{
    $setting = get_option('pcivault_options')[$args['label_for']];
    ?>
    <input
            id="<?php echo esc_attr($args['label_for']); ?>"
            name="pcivault_options[<?php echo esc_attr($args['label_for']); ?>]"
            value="<?php echo esc_attr($setting); ?>"
    />
    <p class="description">
        <?php esc_html_e($args['description'], 'pcivault'); ?>
    </p>
    <?php
}

function pcivault_options_page()
{
    add_menu_page(
        'PCI Vault Options',
        'PCI Vault Options',
        'manage_options',
        'pcivault',
        'pcivault_options_page_html'
    );
}

add_action('admin_menu', 'pcivault_options_page');

function pcivault_options_page_html()
{
    if (isset($_GET['settings-updated'])) {
        add_settings_error('pcivault_messages', 'pcivault_message', __('Settings Saved', 'pcivault'), 'updated');
    }

    settings_errors('pcivault_messages');
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('pcivault');
            do_settings_sections('pcivault');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}

function pcivault_shortcodes_init()
{
    add_shortcode('pcivault_capture', 'pcivault_capture_shortcode');
}

add_action('init', 'pcivault_shortcodes_init');
add_action('admin_init', 'pcivault_settings_init');
