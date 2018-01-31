<?php
/*
Plugin Name: WordPress Primary Category
Plugin URI: https://getbutterfly.com/
Description: Set a primary category for your (custom) posts and query them in your template using native WordPress queries.
Author: Ciprian Popescu
Author URI: https://getbutterfly.com/
Version: 1.0.0
Text Domain: wp-primary-category

WordPress Primary Category
Copyright (C) 2018 Ciprian Popescu (getbutterfly@gmail.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Include meta box and plugin settings
 */
include 'includes/category-meta.php';
include 'includes/category-settings.php';

/**
 * Load JavaScript helper functions
 * Return false if admin screen is not a post editor screen
 */
function wppc_load_admin_style($hook) {
    if (!in_array($hook, array('post.php', 'post-new.php'))) {
        return;
    }

    wp_enqueue_script('wppc', plugins_url('js/post-functions.js', __FILE__), array('jquery'));
}
add_action('admin_enqueue_scripts', 'wppc_load_admin_style');

/**
 * Create plugin options menu
 */
function wppc_plugin_menu() {
    add_options_page(__('Primary Category', 'wp-primary-category'), __('Primary Category', 'wp-primary-category'), 'manage_options', 'wppc_settings', 'wppc_settings');
}
add_action('admin_menu', 'wppc_plugin_menu');

/**
 * Add default/initial options
 */
function wppc_install() {
    add_option('wppc_primary_category', '');
}
register_activation_hook(__FILE__, 'wppc_install');
