<?php
/*
Plugin Name: Pjpluginboiler
Plugin URI: https://pjpluginboiler.com
Description: Replace me with your description.
Version: 1.0.0.0
Author: Pjpluginboiler
Text Domain: pjpluginboiler
Domain Path: languages
License: GPLv3
*/

/*
Copyright 2019  Pjpluginboiler  (email : support@pjpluginboiler.com)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup plugin constants.
 *
 * @access private
 * @since 1.0
 * @return void
 */
function pjpluginboiler_setup_constants() {

	// Plugin version.
	if ( ! defined( 'PJPLUGINBOILER_VERSION' ) ) {

		$pjpluginboiler_version = '1.0.0.0';

		// If SCRIPT_DEBUG is enabled, break the browser cache.
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			define( 'PJPLUGINBOILER_VERSION', $pjpluginboiler_version . time() );
		} else {
			define( 'PJPLUGINBOILER_VERSION', $pjpluginboiler_version );
		}
	}

	// Plugin Folder Path.
	if ( ! defined( 'PJPLUGINBOILER_PLUGIN_DIR' ) ) {
		define( 'PJPLUGINBOILER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	}

	// Plugin Folder URL.
	if ( ! defined( 'PJPLUGINBOILER_PLUGIN_URL' ) ) {
		define( 'PJPLUGINBOILER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	}

	// Plugin Root File.
	if ( ! defined( 'PJPLUGINBOILER_PLUGIN_FILE' ) ) {
		define( 'PJPLUGINBOILER_PLUGIN_FILE', __FILE__ );
	}

	// The default mode for the onboarding wizard.
	if ( ! defined( 'PJPLUGINBOILER_WIZARD_TEST_MODE' ) ) {
		define( 'PJPLUGINBOILER_WIZARD_TEST_MODE', false );
	}

}
pjpluginboiler_setup_constants();

/**
 * Installation functions
 */
require PJPLUGINBOILER_PLUGIN_DIR . 'includes/other/php/install.php';

if ( ! class_exists( 'Pjpluginboiler' ) ) {

	/**
	 * Main Pjpluginboiler Class.
	 *
	 * @since 1.0
	 */
	final class Pjpluginboiler {

		/**
		 * The instance of Pjpluginboiler
		 *
		 * @var Pjpluginboiler
		 * @since 1.0
		 */
		private static $instance;

		/**
		 * Main Pjpluginboiler Instance.
		 *
		 * @since 1.0
		 * @static
		 * @static var array $instance
		 * @uses Pjpluginboiler::includes() Include the required files.
		 * @uses Pjpluginboiler::load_textdomain() load the language files.
		 * @see Pjpluginboiler()
		 * @return object|Pjpluginboiler The Pjpluginboiler singleton
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Pjpluginboiler ) ) {
				self::$instance = new Pjpluginboiler();
				self::$instance->load_textdomain();
				self::$instance->includes();
			}

			return self::$instance;
		}

		/**
		 * Throw error on object clone as this only needs to be instatiated once.
		 *
		 * @since 1.0
		 * @access protected
		 * @return void
		 */
		public function __clone() {
			wp_die( esc_textarea( __( 'This class can only be instantiated once.', 'pjpluginboiler' ) ) );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @since 1.0
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			wp_die( esc_textarea( __( 'This class can only be instantiated once.', 'pjpluginboiler' ) ) );
		}

		/**
		 * Include required files.
		 *
		 * @access private
		 * @since 1.0
		 * @return void
		 */
		private function includes() {

			/**
			 * Frontend Things
			 */
			require PJPLUGINBOILER_PLUGIN_DIR . 'includes/frontend/php/enqueue-scripts.php';

			/**
			 * Admin Things
			 */
			require PJPLUGINBOILER_PLUGIN_DIR . 'includes/admin/php/enqueue-scripts.php';

			/**
			 * API Things
			 */
			//require PJPLUGINBOILER_PLUGIN_DIR . 'includes/api/endpoints/';

			/**
			 * Other code unspecific to the frontend or admin specifically.
			 */
			require PJPLUGINBOILER_PLUGIN_DIR . 'includes/other/php/misc-functions.php';

		}

		/**
		 * Loads the plugin language files.
		 *
		 * @since 1.0
		 * @return void
		 */
		public function load_textdomain() {

			// Load the included language files.
			load_plugin_textdomain( 'pjpluginboiler', false, PJPLUGINBOILER_PLUGIN_FILE . '/languages/' );

			// Load any custom language files from /wp-content/languages/pjpluginboiler for the current locale.
			$locale = apply_filters( 'plugin_locale', get_locale(), 'pjpluginboiler' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'pjpluginboiler', $locale );
			load_textdomain( 'pjpluginboiler', WP_LANG_DIR . '/pjpluginboiler/' . $mofile );

		}

	}

}

/**
 * Function which returns the Pjpluginboiler Singleton
 *
 * @since 1.0
 * @return Pjpluginboiler
 */
function pjpluginboiler() {
	return Pjpluginboiler::instance();
}

/**
 * Start Pjpluginboiler.
 *
 * @since 1.0
 * @return Pjpluginboiler
 */
function pjpluginboiler_initialize() {
	return pjpluginboiler();
}
add_action( 'plugins_loaded', 'pjpluginboiler_initialize' );
