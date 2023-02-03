<?php

$questions = $_POST["questions"];

if (isset($questions)) {
    update_option("ws_questions", $questions);
}

// Register css
add_action('admin_init', 'vsb_register_admin_style');
function vsb_register_admin_style()
{
    wp_register_style('vsb_admin_style', plugin_dir_url(__FILE__) . 'css/admin.css');
    wp_enqueue_style('vsb_admin_style');
}

// Register Javascript
add_action('admin_init', 'register_script');
function register_script()
{
    wp_register_script('admin_scripts', plugin_dir_url(__FILE__) . 'js/admin.js');
    wp_enqueue_script('admin_scripts');
}

add_filter('plugin_action_links_writestory/index.php', 'settings_link');
function settings_link($links)
{
    $url = esc_url(add_query_arg(
        'page',
        'writestory',
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
add_action('admin_menu', 'add_menu');
function add_menu()
{
    add_menu_page(
        'Write a Story Configuration',
        'Write a Story',
        'manage_options',
        'writestory',
        'init_page',
        plugin_dir_url(__FILE__) . 'assets/menu_icon.jpeg'
    );
}

function init_page()
{
    echo file_get_contents(plugin_dir_url(__FILE__) . 'html/admin.html');
?>
    <form method="POST" action="">
        <?php
        settings_fields('ws_question_group');
        do_settings_sections('ws_setting_page');
        submit_button("Save");
        ?>
    </form>
<?php
}

add_action('admin_init', 'ws_settings');
function ws_settings()
{

    add_settings_section(
        'ws_question_section',
        'Questions',
        'content',
        'ws_setting_page'
    );
}

function content()
{
    echo '<p>Add list of questions below</p>';
?>
    <div id="question-list">
        <script>
            <?php
            $questions = get_option("ws_questions");
            $size = count($questions);
            if ($size > 0) {
                for ($i = 0; $i < $size; $i++) {
                    $question = $questions[$i];
            ?>
                    addQuestion('<?= $question ?>');
                <?php
                }
            } else {
                ?>
                addQuestion();
            <?php
            }
            ?>
        </script>
    </div>
    <a onclick="addQuestion()">+ Add Question</a>
<?php
}
