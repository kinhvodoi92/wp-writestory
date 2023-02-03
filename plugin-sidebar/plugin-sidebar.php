<?php
/**
 * Plugin Name: Gutenberg Examples Sidebar Example
 * Plugin URI: https://github.com/WordPress/gutenberg-examples
 * Description: This is a plugin demonstrating how to add a sidebar in the block editor.
 * Version: 1.0.0
 * Author: the Gutenberg Team
 *
 * @package gutenberg-examples
 */

// Init. Register scripts and styles.
function sidebar_plugin_register1() {
	wp_register_script(
		'plugin-sidebar-js1',
		plugins_url( 'plugin-sidebar.js', __FILE__ ),
		array(
			'wp-plugins',
			'wp-edit-post',
			'wp-element',
			'wp-components'
		)
	);
	wp_register_style(
		'plugin-sidebar-css1',
		plugins_url( 'plugin-sidebar.css', __FILE__ )
	);
}
add_action( 'init', 'sidebar_plugin_register1' );

// Enqueue scripts and style.
function sidebar_plugin_script_enqueue1() {
	wp_enqueue_script( 'plugin-sidebar-js1' );
	wp_enqueue_style( 'plugin-sidebar-css1' );
}
add_action( 'enqueue_block_editor_assets', 'sidebar_plugin_script_enqueue1' );

// Register post meta field.
register_post_meta( 'post', 'sidebar_plugin_meta_block_field1', array(
	'show_in_rest' => true,
	'single' => true,
	'type' => 'string',
) );
