<?php

/**
 * Plugin Name: Write a Story
 * Plugin URI: https://www.kinhview.vn/
 * Description: Plugin to write story fastly
 * Version: 0.1
 * Author: kinhroi
 * Author URI: https://www.kinhview.vn/
 **/

 defined( 'ABSPATH' ) || exit;

include 'ws_admin.php';
include 'block/index.php';
include 'plugin-sidebar/plugin-sidebar.php';
// require plugin_dir_path( __FILE__ ) . 'block/block.php';

// Register css
add_action('wp_enqueue_scripts', 'vsb_register_style');
function vsb_register_style()
{
    wp_register_style('vsb_style', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_style('vsb_style');
}
