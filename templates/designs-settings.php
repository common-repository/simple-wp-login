<?php
// Ensure that $design is available and contains the selected design's fields
if (isset($design['fields'])) {
    foreach ($design['fields'] as $field) {
        $field_name = 'wpls_' . sanitize_title($field['key']);
        $field_value = get_option($field_name, '');
        
        // var_dump($field_value);

        echo '<div class="wpls-inline-field">';
        echo '<label for="' . esc_attr($field_name) . '" class="wpls-label">' . esc_html($field['label']) . ':</label>';

        // Render the field based on its type (text or color)
        if ($field['type'] === 'text') {
            echo '<input type="text" name="' . esc_attr($field_name) . '" id="' . esc_attr($field_name) . '" value="' . esc_attr($field_value) . '" class="regular-text wpls-input" />';
        } elseif ($field['type'] === 'color') {
            echo '<input type="color" name="' . esc_attr($field_name) . '" id="' . esc_attr($field_name) . '" value="' . esc_attr($field_value) . '" class="wpls-input-color" />';
        }

        echo '</div>';
    }
}
