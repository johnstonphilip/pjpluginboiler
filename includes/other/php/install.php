<?php
/**
 * Pjpluginboiler
 *
 * @package     Pjpluginboiler
 * @subpackage  Classes/Pjpluginboiler
 * @copyright   Copyright (c) 2018, Pjpluginboiler
 * @license     https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Install
 *
 * Runs on plugin install
 *
 * @since 1.0
 * @global $wpdb
 * @param  bool $network_wide If the plugin is being network-activated.
 * @return void
 */
function pjpluginboiler_install( $network_wide = false ) {

	global $wpdb;

	if ( is_multisite() && $network_wide ) {

		foreach ( $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs LIMIT 100" ) as $blog_id ) { // phpcs:ignore

			switch_to_blog( $blog_id );
			pjpluginboiler_run_install();
			restore_current_blog();

		}
	} else {

		pjpluginboiler_run_install();

	}

}
register_activation_hook( TESTIMONIAL_TOAST_PLUGIN_FILE, 'pjpluginboiler_install' );

/**
 * Install
 *
 * Runs on plugin install
 *
 * @since 1.0
 * @return void
 */
function pjpluginboiler_run_install() {
}