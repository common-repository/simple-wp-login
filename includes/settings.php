<?php
// Hook to admin init to register settings
add_action('admin_init', 'wpls_register_settings');

function wpls_register_settings() {
    // Register the design selection (the selected design ID)
    register_setting('wpls_designs_group', 'wpls_selected_design');
    
    // Register the general settings section (this will be for the dynamic fields)
    // Get the selected design
    $selected_design = get_option('wpls_selected_design', 'black-key'); // Default to 'design1'
    $designs = wpls_get_design_json();
    
    // Register fields dynamically for the selected design
    foreach ($designs as $design) {
        if ($design['id'] === $selected_design) {
            foreach ($design['fields'] as $field) {
                $field_name = 'wpls_' . sanitize_title($field['key']);
                register_setting('wpls_settings_group', $field_name);
            }
        }
    }
    
    // Add a section for selecting the design
    add_settings_section(
        'wpls_designs_section', // Section ID
        'Select Login Design',  // Section Title
        'wpls_designs_section_callback', // Callback for rendering the section
        'wpls_designs'          // Page slug
    );
    
    // Add a section for general settings based on selected design
    add_settings_section(
        'wpls_settings_section', // Section ID
        'General Settings',       // Section Title
        'wpls_general_section_callback', // Callback to load the fields
        'wpls_settings'          // Page slug
    );
}

// Section and Field Callbacks

// Load the Designs grid from the template file
function wpls_designs_section_callback() {
    include SIMPLE_WP_LOGIN_PLUGIN_DIR . 'templates/designs-grid.php';  // Include the designs grid template
}

// Dynamically register and render fields for the selected design in General Settings
function wpls_general_section_callback() {
    // Get the selected design from the saved options
    $selected_design = get_option('wpls_selected_design', 'design1'); // Default to 'design1'

    // Load designs.json to get the fields for the selected design
    $designs = wpls_get_design_json();

    // Find the selected design
    foreach ($designs as $design) {
        if ($design['id'] === $selected_design) {
            // Register settings for the selected design's fields
            foreach ($design['fields'] as $field) {
                $field_name = 'wpls_' . sanitize_title($field['key']);
                
                // Register the dynamic field
                register_setting('wpls_settings_group', $field_name);
            }

            // Include the template that renders the fields for the selected design
            include SIMPLE_WP_LOGIN_PLUGIN_DIR . 'templates/designs-settings.php';
            return;
        }
    }
}