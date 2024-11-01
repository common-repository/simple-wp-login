<?php 
/**
 * Plugin Name: Simple Login Screen For WordPress
 * Plugin URI: http://www.najeebmedia.com/
 * Description: Choose beautiful designs for login window and also change logo with graphics or text even disable logo 
 * Version: 2.0
 * Author: nmedia
 * Author URI: http://www.najeebmedia.com/
 * Text Domain: wp-login-window
 * License: GPL2
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define constants for plugin paths
define('SIMPLE_WP_LOGIN_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SIMPLE_WP_LOGIN_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include the admin page and settings file
require_once SIMPLE_WP_LOGIN_PLUGIN_DIR . 'includes/functions.php';
require_once SIMPLE_WP_LOGIN_PLUGIN_DIR . 'includes/admin.php';
require_once SIMPLE_WP_LOGIN_PLUGIN_DIR . 'includes/settings.php';

// Enqueue custom styles for the login screen
function simple_wp_login_custom_styles() {
    
    // Ensure that the default login style is deregistered if needed
    wp_deregister_style('login');
    
    // Enqueue the dashicons style for icons
    wp_enqueue_style('dashicons');
    
    // Get selected design metadata
    $current_design_meta = wpls_get_selected_design_meta();
    $screen = isset($current_design_meta['screen']) ? $current_design_meta['screen'] : 'black-key';
    
    // Enqueue the selected design's CSS file
    wp_enqueue_style('simple-wp-login-style', SIMPLE_WP_LOGIN_PLUGIN_URL . 'includes/screens/' . $screen . '/login.css');

    // Add content before the login form
    add_action('login_header', function() use ($current_design_meta) {
        $html_before_login = isset($current_design_meta['before_login']) ? $current_design_meta['before_login'] : '';
        echo $html_before_login;
    });

    // Add content after the login form
    add_action('login_footer', function() use ($current_design_meta) {
        $html_after_login = isset($current_design_meta['after_login']) ? $current_design_meta['after_login'] : '';
        echo $html_after_login;
    });

    // Get the logo URL
    $logo_url = get_option('wpls_logo_url', 'login-header.png');

    // Generate dynamic CSS based on selected design fields
    $fields = isset($current_design_meta['fields']) ? $current_design_meta['fields'] : [];

    // Initialize the CSS string
    $custom_css = ":root {";
    
    // Loop through the fields and dynamically create CSS variables
    foreach ($fields as $field) {
        $root_var = isset($field['root_variable']) ? $field['root_variable'] : null;
        if ($root_var) {
            // Get the field value from the database or use a default value
            $value = get_option('wpls_' . $field['key'], null);
            if($value)
                $custom_css .= "{$root_var}: {$value};";
        }
    }
    
    // Close the root block and add custom logo styling
    $custom_css .= "}
        #login h1 a {
        background-image: url(" . esc_url($logo_url) . ");
        background-size: contain; /* Scale the logo to fit within the element */
        background-repeat: no-repeat; /* Prevent the logo from repeating */
        background-position: center; /* Center the logo horizontally */
        width: 100%; /* Adjust width to allow centering */
        height: 80px; /* Set an explicit height for the logo container */
        display: block; /* Ensure the element behaves as a block */
        text-indent: -9999px; /* Hide the default text */
    }";

    
    // Add the inline style to the login page
    wp_add_inline_style('simple-wp-login-style', $custom_css);
}

add_action('login_enqueue_scripts', 'simple_wp_login_custom_styles');