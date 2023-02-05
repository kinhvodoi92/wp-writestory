<?php

// $question_title = $_POST["question-title"];
// $question_desc = $_POST["question-description"];
// $questions

if (isset($_POST["questions"])) {
    WSAdminDB::instance()->addQuestion(
        $_POST["question-title"], 
        $_POST["question-description"], 
        $_POST["questions"]
    );
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

function init_add_page()
{
    echo file_get_contents(plugin_dir_url(__FILE__) . 'html/admin.html');
?>
    <form method="POST" action="">
        <?php
        do_settings_sections('ws_setting_page');
        submit_button("Save");
        ?>
    </form>
<?php
}

function content()
{
?>
    <div class="vertical-layout">
        <p>Add name of Questions Block</p>
        <input class="vsb_admin_input" type="text" name="question-title" placeholder="Name of Block"/>
    </div>
    <div class="vertical-layout">
        <p>Description</p>
        <textarea class="vsb_admin_input" style="height: 100px;" type="text" name="question-description"></textarea>
    </div>
    <p>Add list of questions below</p>
    <div id="question-list">
        <script>
            addQuestion();
        </script>
    </div>
    <a onclick="addQuestion()">+ Add Question</a>
<?php
}
