<?php

// $question_title = $_POST["question-title"];
// $question_desc = $_POST["question-description"];
// $questions

global $block_id, $success, $question_title, $question_desc, $questions;

if (isset($_POST["questions"])) {
    $question_title = $_POST["question-title"];
    $desc = $_POST["question-description"];
    $block_id = $_POST["id"];
    if ($block_id) {
        $success = WSAdminDB::instance()->updateQuestion(
            $block_id,
            $question_title,
            $desc,
            $_POST["questions"]
        );
    } else {
        $success = WSAdminDB::instance()->addQuestion(
            $question_title,
            $desc,
            $_POST["questions"]
        );
    }
}

if (isset($_GET["id"])) {
    $block_id = $_GET["id"];
    $question = WSAdminDB::instance()->fetchQuestion($block_id);
    if ($question) {
        $question_title = $question->title;
        $question_desc = $question->description;
        $questions = json_decode($question->questions);
    }
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
    global $block_id;
    echo file_get_contents(plugin_dir_url(__FILE__) . 'html/admin.html');
?>
    <form method="POST" action="">
        <?php
        do_settings_sections('ws_setting_page');
        submit_button($block_id ? "Save" : "Add");
        ?>
    </form>
<?php
}

function content()
{
    global $block_id, $success, $question_title, $question_desc, $questions;
    if ($success) {
        echo '<div class="notice notice-success is-dismissible"><p>' . ($block_id ? "Update" : "Add") . ' Questions Block successful!</p></div>';
    } else if (isset($success) && !$success) {
        echo '<div class="notice notice-error is-dismissible"><p>Add Questions Block failed. Check input data!</p></div>';
    }

    if ($block_id) {
        echo '<input name="id" value="' . $block_id . '" hidden />';
    }
?>
    <div class="vertical-layout">
        <p>Add name of Questions Block</p>
        <input class="vsb_admin_input" type="text" name="question-title" placeholder="Name of Block" required value="<?= $question_title ?>" />
    </div>
    <div class="vertical-layout">
        <p>Description</p>
        <textarea class="vsb_admin_input" style="height: 100px;" type="text" name="question-description"><?= $question_desc ?></textarea>
    </div>
    <p>Add list of questions below</p>
    <div id="question-list">
        <script>
            <?php
            $count = count($questions ?? []);
            if ($count === 0) {
            ?>
                addQuestion();
            <?php
            }
            for ($i = 0; $i < $count; $i++) {
                $question = $questions[$i];
            ?>
                addQuestion('<?= $question ?>');
            <?php

            }
            ?>
        </script>
    </div>
    <a onclick="addQuestion()">+ Add Question</a>
<?php
}
