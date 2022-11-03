<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://7pixel.cl
 * @since             1.0.0
 * @package           Seven_Pixel_Crud
 *
 * @wordpress-plugin
 * Plugin Name:       7Pixel Crud
 * Plugin URI:        https://7pixel.cl
 * Description:       Plugin for Making CRUD operations into Database
 * Version:           1.0.0
 * Author:            Marco Alvarado
 * Author URI:        https://7pixel.cl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       seven-pixel-crud
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SEVEN_PIXEL_CRUD_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-seven-pixel-crud-activator.php
 */
function activate_seven_pixel_crud() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-seven-pixel-crud-activator.php';
	Seven_Pixel_Crud_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-seven-pixel-crud-deactivator.php
 */
function deactivate_seven_pixel_crud() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-seven-pixel-crud-deactivator.php';
	Seven_Pixel_Crud_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_seven_pixel_crud' );
register_deactivation_hook( __FILE__, 'deactivate_seven_pixel_crud' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-seven-pixel-crud.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_seven_pixel_crud() {

	$plugin = new Seven_Pixel_Crud();
	$plugin->run();

}
run_seven_pixel_crud();
