<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

function wppc_settings() { ?>
	<div class="wrap">
		<h2><?php _e('Primary Category Settings', 'wp-primary-category'); ?></h2>

        <?php $tab = isset($_GET['tab']) ? $_GET['tab'] : 'settings'; ?>
        <h2 class="nav-tab-wrapper">
            <a href="<?php echo admin_url('admin.php?page=wppc_settings&amp;tab=settings'); ?>" class="nav-tab <?php echo $tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php _e('General Settings', 'wp-primary-category'); ?></a>
            <a href="<?php echo admin_url('admin.php?page=wppc_settings&amp;tab=help'); ?>" class="nav-tab <?php echo $tab == 'help' ? 'nav-tab-active' : ''; ?>"><?php _e('Help', 'wp-primary-category'); ?></a>
        </h2>

        <?php if ((string) $tab === 'settings') {
            if (isset($_POST['info_update']) && current_user_can('manage_options')) {
                // Any of the WordPress data sanitization functions can be used here
                $wppc_primary_category = array_map('sanitize_text_field', $_POST['wppc_primary_category']);
                update_option('wppc_primary_category', $wppc_primary_category);

                echo '<div class="updated notice is-dismissible"><p>Settings updated!</p></div>';
            }
            ?>
            <form method="post" action="">
                <h3><?php _e('Primary Category Settings', 'wp-primary-category'); ?></h3>

                <p><span class="dashicons dashicons-editor-help"></span> <?php _e('Select one or more post types from the list below to allow primary category selection.', 'wp-primary-category'); ?></p>
                <p>
                    <?php
                    $allowPrimaryCategoryFor = get_option('wppc_primary_category');
                    $postTypes = get_post_types();

                    foreach ($postTypes as $postType) {
                        $postTypeObject = get_post_type_object($postType);
                        $checked = (in_array($postType, $allowPrimaryCategoryFor) ? 'checked' : ''); ?>
                        <input type="checkbox" id="wppc_primary_category_<?php echo $postType; ?>" name="wppc_primary_category[]" value="<?php echo $postType; ?>" <?php echo $checked; ?>>
                        <label for="wppc_primary_category_<?php echo $postType; ?>"><?php echo $postTypeObject->labels->singular_name; ?> (<code><?php echo $postType; ?></code>)</label>
                        <br>
                    <?php } ?>
                </p>

                <p><input type="submit" name="info_update" class="button button-primary" value="<?php _e('Save Changes', 'wp-primary-category'); ?>"></p>
            </form>
            <?php
        } else if ((string) $tab === 'help') { ?>
            <h3><?php _e('Primary Category Help', 'wp-primary-category'); ?></h3>

            <p><?php _e('Use native WordPress queries to get posts based on their primary category ID. See example below.', 'wp-primary-category'); ?></p>
            <p>
                <textarea class="large-text code" rows="24">$args = array(
    'meta_query' => array(
        array(
            'key' => '_wppc_primary_category',
            'value' => array(3, 4),
            'compare' => 'IN', // optional
        ),
    ),
);
$myQuery = new WP_Query($args);

if ($myQuery->have_posts()) {
    while ($myQuery->have_posts()) {
        $myQuery->the_post();

        // Assign post object to a variable for convenience
        $myPost = $myQuery->post;

        /*
         * $myQuery->post (or $myPost) is a WP_Post object
         *
         * Usage
         * $myQuery->post->ID (or $myPost->ID)
         * $myQuery->post->post_title (or $myPost->post_title)
         * $myQuery->post->post_content (or $myPost->post_content)
         */
    }
}</textarea>
            </p>
            <?php
        }
        ?>
	</div>
<?php
}
