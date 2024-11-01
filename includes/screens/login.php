<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Hook into login form to customize the layout
function custom_login_form_structure() {
    ?>
    <div class="login-left">
        <div>
            <h1>Welcome to Our Site</h1>
            <p>Join us today and enjoy exclusive content, features, and more.</p>
        </div>
    </div>
    <div class="login-right">
    <?php
}
add_action('login_header', 'custom_login_form_structure');

// Close the div structure after the login form
function custom_login_form_footer() {
    ?>
    </div>
    <?php
}
add_action('login_footer', 'custom_login_form_footer');
