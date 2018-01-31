<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Add primary category meta box
 *
 * @param post $post The post object
 */
function wppc_add_meta_boxes($post) {
    $allowPrimaryCategoryFor = get_option('wppc_primary_category');;

    add_meta_box('product_meta_box', __('Primary Category', 'wp-primary-category'), 'wppc_build_meta_box', $allowPrimaryCategoryFor, 'side', 'low');
}
add_action('add_meta_boxes', 'wppc_add_meta_boxes');

/**
 * Build custom field meta box
 *
 * @param post $post The post object
 */
function wppc_build_meta_box($post) {
	wp_nonce_field(basename(__FILE__), 'wppc_meta_box_nonce');

    $wpPrimaryCategory = get_post_meta($post->ID, '_wppc_primary_category', true);
    if (empty($wpPrimaryCategory)) {
        $wpPrimaryCategory = 0;
    }
	?>
    <div class='inside'>
        <p>
            <label for="wppc_primary_category"><b><?php _e('Primary Category', 'wp-primary-category'); ?></b></label>
            <select name="wppc_primary_category" id="wppc_primary_category" class="regular-text" data-primary-category="<?php echo $wpPrimaryCategory; ?>" style="width: 100%;">
                <option value="0"><?php _e('Select primary category...', 'wp-primary-category'); ?></option>
            </select>
            <br><small><?php _e('Select one or more categories then select a primary category from the dropdown above.', 'wp-primary-category'); ?></small>
        </p>
	</div>
	<?php
}

/**
 * Store custom field meta box data
 *
 * @param int $post_id The post ID
 */
function wppc_save_meta_box_data($post_id) {
    // Verify meta box nonce
    if (!isset($_POST['wppc_meta_box_nonce']) || !wp_verify_nonce($_POST['wppc_meta_box_nonce'], basename(__FILE__))) {
        return;
    }

    // Return if doing autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions (assume basic editing permissions)
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Store custom fields value
    if (isset($_REQUEST['wppc_primary_category'])) {
        update_post_meta($post_id, '_wppc_primary_category', sanitize_text_field($_POST['wppc_primary_category']));
    }
}
add_action('save_post', 'wppc_save_meta_box_data');
