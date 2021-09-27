<?php

/**
 * Plugin Name:       Task Book
 * Plugin URI:        https://linkedin.com/learning
 * Description:       Track stress and anxiety levels around tasks.
 * Version:           1.0.0
 * Author:            Aldo Paz Velasquez
 * Author URI:        https://apazvelasquez.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       taskbook
 * Domain Path:       /languages
 */

/**
* Register Task post type
*/
  require_once plugin_dir_path( __FILE__ ) . 'includes/posttypes.php';
  register_activation_hook( __FILE__, 'taskbook_rewrite_flush' );

/**
 * Register Task Logger role
 */
  require_once plugin_dir_path(__FILE__ ) . 'includes/roles.php';
  register_activation_hook( __FILE__, 'taskbook_register_role' );
  register_deactivation_hook( __FILE__, 'taskbook_remove_role' );

/**
 * Add capabilities
 */
  register_activation_hook( __FILE__, 'taskbook_add_capabilities' );
  register_deactivation_hook( __FILE__, 'taskbook_remove_capabilities' );

/**
* Register Task Logger role
*/
  require_once plugin_dir_path( __FILE__ ) . 'includes/status.php';


/**
 * Register CMB2 metaboxes and fields
 */
  require_once plugin_dir_path( __FILE__ ) . 'includes/CMB2-functions.php';

/**
 * Grant access to tasks only to authenticated users
 * with either administrator or task logger roles
 */
add_action('pre_get_posts', 'taskbook_grant_access');

function taskbook_grant_access($query) {

  if ( !isset($query->query_vars['post_type']) ) {
    return;
  }

  if ( $query->query_vars['post_type'] != 'task' ) {
    return;
  }

  if ( !defined('REST_REQUEST') ) {
    return;
  }

  if ( current_user_can( 'administrator' ) ) {
    $query->set('post_status', 'private');
  } elseif (current_user_can( 'task_logger' )) {
    $query->set('post_status', 'private');
    $query->set('author', get_current_user_id());
  }
}