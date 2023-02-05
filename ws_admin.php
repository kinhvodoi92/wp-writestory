<?php
include 'ws_admin_blocks.php';
 include 'ws_admin_add_questions.php';

global $plugin_slug;
$plugin_slug = 'writestory';

register_activation_hook(__FILE__, 'writestory_install_db');
add_action('plugins_loaded', 'writestory_install_db');
add_action('admin_init', 'vsb_register_admin_style');
add_action('admin_init', 'register_script');
add_filter('plugin_action_links_writestory-plugin/index.php', 'settings_link');
add_action('admin_menu', 'add_menu');

function writestory_install_db()
{
    // require_once plugin_dir_path(__FILE__) . 'ws_admin_db.php';
    WSAdminDB::instance()->writestory_update_db_check();
}

// Register css
function vsb_register_admin_style()
{
    wp_register_style('vsb_admin_style', plugin_dir_url(__FILE__) . 'css/admin.css');
    wp_enqueue_style('vsb_admin_style');
}

// Register Javascript
function register_script()
{
    wp_register_script('admin_scripts', plugin_dir_url(__FILE__) . 'js/admin.js');
    wp_enqueue_script('admin_scripts');
}

function settings_link($links)
{
    global $plugin_slug;
    $url = esc_url(add_query_arg(
        'page',
        $plugin_slug,
        get_admin_url() . 'admin.php'
    ));
    // Create the link.
    $settings_link = "<a href='$url'>" . __('Settings') . '</a>';
    // Adds the link to the first of the array.
    array_unshift(
        $links,
        $settings_link
    );
    return $links;
}

// Add Admin Menu
function add_menu()
{
    global $plugin_slug;
    add_menu_page(
        'Write a Story Configuration',
        'Write a Story',
        'manage_options',
        $plugin_slug . '_main_menu',
        '',
        plugin_dir_url(__FILE__) . 'assets/menu_icon.png'
    );

    add_submenu_pages();
}

function add_submenu_pages()
{
    global $plugin_slug;

    add_submenu_page(
        $plugin_slug . '_main_menu',
        'Questions Blocks',
        'Blocks',
        'manage_options',
        $plugin_slug . '_main_menu',
        'init_list_blocks_page',
    );

    add_submenu_page(
        $plugin_slug . '_main_menu',
        'Add New Questions Block',
        'Add New',
        'manage_options',
        $plugin_slug . '_add_new',
        'init_add_page',
    );
}
