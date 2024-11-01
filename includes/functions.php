<?php
/**
 * Helper function WP Login Screens
 */
 
function wpls_get_design_json() {
    $designs_json_path = SIMPLE_WP_LOGIN_PLUGIN_DIR . 'designs.json';
    if (file_exists($designs_json_path)) {
        $designs_json = file_get_contents($designs_json_path);
        return json_decode($designs_json, true);
    }
    return [];
}



function wpls_get_selected_design_meta() {
    // Get the selected design from the options table (default to 'design1')
    $selected_design = get_option('wpls_selected_design', 'design1');
    
    // Load the designs from the JSON file
    $designs = wpls_get_design_json();
    
    $design_meta = null; // Initialize the variable to hold design metadata
    
    // Find the selected design
    foreach ($designs as $design) {
        if ($design['id'] === $selected_design) {
            $design_meta = $design; // Store the design metadata
            return $design_meta;    // Return the selected design metadata
        }
    }
    
    // Return null if the design is not found
    return $design_meta;
}


