<?php
// Hook to admin menu to create the settings page
add_action('admin_menu', 'wpls_add_admin_menu');

// Hook to enqueue styles only on the settings page
add_action('admin_enqueue_scripts', 'wpls_enqueue_admin_styles');

function wpls_enqueue_admin_styles($hook_suffix) {
    if ($hook_suffix === 'toplevel_page_wpls_settings') {
        // Enqueue the settings.css file
        wp_enqueue_style('simple-wp-login-style', SIMPLE_WP_LOGIN_PLUGIN_URL . 'assets/css/settings.css');
    }
}


function wpls_add_admin_menu() {
    add_menu_page(
        'WP Login Screens Settings', // Page Title
        'WP Login Screens', // Menu Title
        'manage_options', // Capability
        'wpls_settings', // Menu Slug
        'wpls_settings_page', // Callback function
        '', // Icon URL (can leave blank)
        99 // Position in the menu
    );
}

function wpls_settings_page() {
    // Determine the active tab, default to 'designs' if none is set
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'designs'; 
    
    ?>
    <div class="wrap">
        <h2>WP Login Screens Settings</h2>
        
        <!-- Tab Navigation -->
        <h2 class="nav-tab-wrapper">
            <a href="?page=wpls_settings&tab=designs" class="nav-tab <?php echo $active_tab == 'designs' ? 'nav-tab-active' : ''; ?>">Designs</a>
            <a href="?page=wpls_settings&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
        </h2>
        
        <!-- Form Submission to Options.php -->
        <form method="post" action="options.php">
            <?php
            // Display content for the Designs tab
            if ($active_tab == 'designs') {
                // Output settings fields for the 'wpls_designs_group'
                settings_fields('wpls_designs_group');
                
                // Display sections and fields registered with 'wpls_designs'
                do_settings_sections('wpls_designs');
            } 
            // Display content for the Settings tab
            else {
                // Output settings fields for the 'wpls_settings_group'
                settings_fields('wpls_settings_group');
                
                // Display sections and fields registered with 'wpls_settings'
                do_settings_sections('wpls_settings');
            }

            // Submit Button
            submit_button(); 
            ?>
        </form>
    </div>
    <?php
}



