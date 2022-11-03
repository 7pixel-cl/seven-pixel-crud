<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://7pixel.cl
 * @since      1.0.0
 *
 * @package    Seven_Pixel_Crud
 * @subpackage Seven_Pixel_Crud/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Seven_Pixel_Crud
 * @subpackage Seven_Pixel_Crud/includes
 * @author     Marco Alvarado <hola@7pixel.cl>
 */
class Seven_Pixel_Crud_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'seven-pixel-crud',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
