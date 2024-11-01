<?php
$designs = wpls_get_design_json();
$designs_url = SIMPLE_WP_LOGIN_PLUGIN_URL . 'assets/designs/';

echo '<div class="wpls-design-grid">';

foreach ($designs as $design) {
    $design_id = esc_attr($design['id']);
    $design_title = esc_html($design['title']);
    $image_url = $designs_url . $design_id; // Assuming design1.png, design2.png, etc.
    
    
    if (get_option('wpls_selected_design') !== $design_id) {
    foreach ($design['fields'] as $field) {
        $field_name = 'wpls_' . sanitize_title($field['key']);
        update_option($field_name, '');
    }
}

    echo '<div class="wpls-design-item">';
    echo '<label>';
    echo '<input type="radio" name="wpls_selected_design" value="' . $design_id . '" ' . checked(get_option('wpls_selected_design'), $design_id, false) . ' />';
    echo '<img src="' . esc_url($image_url) . '" alt="' . $design_title . '">';
    echo '<p>' . $design_title . '</p>';
    echo '</label>';
    echo '</div>';
}

echo '</div>';
?>
