<?php

/**
 * Plugin Name: Write a Story
 * Plugin URI: https://www.kinhview.vn/
 * Description: Plugin to write story fastly
 * Version: 0.1
 * Author: kinhroi
 * Author URI: https://www.kinhview.vn/
 **/

defined('ABSPATH') || exit;

include 'ws_admin_db.php';
include 'ws_admin.php';
include 'block/index.php';

// Register css
add_action('wp_enqueue_scripts', 'vsb_register_style');
function vsb_register_style()
{
    wp_register_style('vsb_style', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_style('vsb_style');
}

// add_filter('page_rewrite_rules', 'wpse7243_page_rewrite_rules');
// function wpse7243_page_rewrite_rules($rewrite_rules)
// {
//     end($rewrite_rules);
//     $rewrite_rules += array(
//         'teleprompter' => '2022/03/10/chao-moi-nguoi/',
//     );
//     return $rewrite_rules;
// }

// add_filter('rewrite_rules_array', 'wp_insertMyRewriteRules');
// // Adding a new rule
// function wp_insertMyRewriteRules($rules)
// {
//     // add_rewrite_rule('teleprompter', 'index.php/category/khong-phan-loai');
//     $newrules = array();
//     $newrules['teleprompter'] = "index.php/wp-content/plugins/writestory-plugin/block/ws_user_teleprompter.php";
//     return $newrules + $rules;
// }

// add_filter('init', 'flushRules');
// // Remember to flush_rules() when adding rules->nhớ là pải chạy cái này (hay pải flush) thì rewrite mới có tác dụng.
// function flushRules()
// {
//     global $wp_rewrite;
//     $wp_rewrite->flush_rules();
// }