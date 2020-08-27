<?php
/**
 * Pjpluginboiler
 *
 * @package     Pjpluginboiler
 * @subpackage  Classes/Pjpluginboiler
 * @copyright   Copyright (c) 2020, Pjpluginboiler
 * @license     https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since       1.0.0
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue a new Gutenberg block
 *
 * @since  1.0.0
 * @return void
 */
function pjpluginboiler_enqueue_block() {

	$dependencies = require Pjpluginboiler_PLUGIN_DIR . 'includes/frontend/js/build/Pjpluginboiler.asset.php';

	// Include the frontend component so it can render inside Gutenberg.
	wp_register_script( 'Pjpluginboiler_block', Pjpluginboiler_PLUGIN_URL . 'includes/frontend/js/build/Pjpluginboiler.js', $dependencies['dependencies'], time(), true );

	// Register the block.
	register_block_type(
		'Pjpluginboiler/Pjpluginboiler',
		array(
			'editor_script' => 'Pjpluginboiler_block',
			'editor_style'  => 'Pjpluginboiler_block_editor',
		)
	);

	wp_register_style(
		'Pjpluginboiler_block_editor',
		Pjpluginboiler_PLUGIN_URL . 'includes/frontend/css/build/Pjpluginboiler.css',
		array( 'wp-edit-blocks' ),
		time()
	);

	wp_enqueue_script( 'Pjpluginboiler_block' );
}
add_action( 'init', 'pjpluginboiler_enqueue_block' );

/**
 * Enqueue a react component outside Gutenberg.
 *
 * @since  1.0.0
 * @return void
 */
function pjpluginboiler_enqueue_custom() {

	$dependencies = require Pjpluginboiler_PLUGIN_DIR . 'includes/frontend/js/build/Pjpluginboiler.asset.php';

	// Include the frontend component so it can render inside Gutenberg.
	wp_enqueue_script( 'Pjpluginboiler_block', Pjpluginboiler_PLUGIN_URL . 'includes/frontend/js/frontend/Pjpluginboiler.js', $dependencies['dependencies'], time(), true );

	wp_enqueue_style(
		'Pjpluginboiler_block_editor',
		Pjpluginboiler_PLUGIN_URL . 'includes/frontend/css/build/Pjpluginboiler.css',
		array( 'wp-edit-blocks' ),
		time()
	);
}
add_action( 'wp_enqueue_scripts', 'pjpluginboiler_enqueue_custom' );
