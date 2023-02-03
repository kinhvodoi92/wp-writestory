<?php

defined('ABSPATH') || exit;

$questions = get_option("ws_questions");

$answers = $_POST['answers'];
if (isset($answers)) {
?>
    <script>
        <?php
        $content = '';
        $answer_count = count($answers);
        for ($i = 0; $i < count($questions); $i++) {
            $question = $questions[$i];
            $answer = $i < $answer_count ? $answers[$i] : '';
            $order = $i + 1;
            $content .= $order . ". " . $question . "\n";
            $content .= preg_replace('/^"(.*)"$/', '$1', json_encode($answer));
            $content .= '\n\n';
        }
        ?>

        window.open('data:text/csv;charset=utf-8,' + `<?= $content ?>`, "_new");

        window.onload = function() {
            var mapForm = document.createElement("form");
            mapForm.target = "_blank";
            mapForm.method = "POST";
            mapForm.action = "https://cueprompter.com/teleprompter.php";

            var mapInput = document.createElement("input");
            mapInput.type = "text";
            mapInput.name = "sisalto";
            mapInput.value = `<?= $content ?>`.replace(/\n/g, '<br />');
            mapForm.appendChild(mapInput);

            document.body.appendChild(mapForm);

            map = window.open("", "_blank");

            if (map) {
                mapForm.submit();
            } else {
                alert('You must allow popups for this map to work.');
            }
        }
    </script>
<?php
}

function write_story_block()
{
    if (!function_exists('register_block_type')) {
        return;
    }
    register_block_type(__DIR__, [
        'render_callback' => function () {
            return write_story_block_content();
        }
    ]);

    // $asset_file = include(plugin_dir_path(__FILE__) . 'block.asset.php');
    // wp_enqueue_script(
    //     'answer-block-script',
    //     plugin_dir_url(__FILE__) . 'block.js',
    //     $asset_file['questions'],
    //     null,
    //     true
    // );
}
add_action('init', 'write_story_block');

function write_story_block_content()
{
    global $questions;
    $html = '';
    for ($i = 0; $i < count($questions); $i++) {
        $question = $questions[$i];
        $order = $i + 1;
        $html .= '<div class="writestory-block-item">
            <strong>' . $order . '. ' . $question . '</strong>
            <textarea name="answers[]" ></textarea>
            </div>';
    }
    return '<form method="POST" action="">
    <div class="writestory-block">
    <a class="writestory-block-title">Write a Story</a>'
        . $html .
        '<input type="submit" value="Export Story" style="align-self: right !important;"/>
        </div></form>';
}
