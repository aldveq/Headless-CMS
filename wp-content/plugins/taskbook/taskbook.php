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
    * Register Task Logger role
    */
    require_once plugin_dir_path( __FILE__ ) . 'includes/status.php';
