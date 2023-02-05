<?php

defined('ABSPATH') || exit;

global $block_id;

add_action('wp_footer', 'check_submit_story');
function check_submit_story()
{
    if (isset($_POST['answers'])) {
        global $block_id;
        $answers = $_POST['answers'];
        $action = $_POST['writestory_action'] ?? 'txt';
?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
        <script>
            <?php
            $content = '';
            $questions = ws_get_questions($block_id);
            $answer_count = count($answers);
            for ($i = 0; $i < count($questions); $i++) {
                $question = $questions[$i];
                $answer = $i < $answer_count ? $answers[$i] : '';
                $order = $i + 1;
                $content .= $order . ". " . $question . "\r\n";
                $content .= $answer;
                $content .= '\r\n\r\n';
            }
            ?>

            window.onload = async function() {
                var type = '<?= $action ?>';
                var content = `<?= $content ?>`;
                if (type === 'copy') {
                    //Copy to Clipboard
                    if (window.isSecureContext) {
                        await navigator.clipboard.writeText(content);
                        alert("Copied Story!");
                    } else {
                        alert("⛔️ Your website is not trusted!\nCan not Copy story to Clipboard.");
                    }
                } else if (type === 'pdf') {
                    var doc = new jsPDF()

                    doc.text(content, 10, 10)
                    doc.save('story.pdf')
                } else {
                    const blob = new Blob([content], {
                        type: "text/plain"
                    });
                    const url = URL.createObjectURL(blob);
                    const domNode = document.createElement('a');
                    domNode.download = 'story.txt';
                    domNode.href = url;
                    domNode.style.display = 'none';
                    document.body.appendChild(domNode);
                    domNode.click();
                    document.body.removeChild(domNode);
                }
            }
        </script>
<?php
    }
}

function write_story_block()
{
    if (!function_exists('register_block_type')) {
        return;
    }
    register_block_type(__DIR__, [
        'render_callback' => function ($args) {
            $block_id = $args['block_id'];
            if (!isset($block_id)) return null;
            return write_story_block_content(
                array(
                    'id' => $block_id,
                )
            );
        }
    ]);
}
add_action('init', 'write_story_block');

// add_action('generate_rewrite_rules', 'ws_rewrite_prompter_rule');
// function ws_rewrite_prompter_rule()
// {
//     global $wp_rewrite;

//     $new_rules = array(
//         'teleprompter$' => 'plugin_dir_url(__FILE__) . 'ws_user_teleprompter.php'',
//     );
//     $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
// }

function write_story_block_content($args)
{
    $prompter_url = plugin_dir_url(__FILE__) . '../teleprompter/index.php';

    global $block_id;
    $block_id = $args['id'];
    $questions = ws_get_questions($block_id);
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
        '<select id="writestory_action" name="writestory_action">
        <option value="txt" selected>Export to .txt</option>
        <option value="pdf">Export to .pdf</option>
        <option value="copy">Copy to Clipboard</option>
      </select>
      <input type="submit" value="Export Story"/>
        </div></form>
        <div class="ws_prompter_container">
        <p class="esittely">
                    Type or cut and paste your script to the form below. Press the button to start the prompter.	<br>
                    If text needs editing, just close the prompter window and restart with the new script.<br>
                    </p>
        <form action="' . $prompter_url . '" target="_new" method="POST">
                        <textarea id="ws_teleprompter_text" name="ws_content" style="height: 200px;" placeholder="Type or cut and paste your script here"></textarea>
                        <p class="copy" align="right"> (max. 10.000 characters)			</p>
                        <table class="copy">
                            <tbody><tr>
                                <td valign="top">	<b>Prompter Width</b><br>
                                    <input type="radio" name="scrsize" value="small"> Narrow<br>
                                    <input type="radio" name="scrsize" value="big" checked="checked"> Wide<br>
                                    <input type="radio" name="scrsize" value="max"> Max<br>
                                </td>
                                <td valign="top">
                                    <b>Prompter Height</b><br>
                                    <input type="radio" name="scrhgt" value="normal" checked="checked"> 500 pixel<br>
                                    <input type="radio" name="scrhgt" value="high"> 725 pixel
                                </td>
                                <td valign="top">
                                    <b>Reverse Mirror</b><br>
                                    <input type="radio" name="mirror" value="no" checked="checked"> Normal <br>
                                    <input type="radio" name="mirror" value="yes"> Mirrored <br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>Font Size</b><br>
                                    <input type="radio" name="fntsize" value="small"> Small<br>
                                    <input type="radio" name="fntsize" value="big" checked="checked"> Big<br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <b>Set colors</b><br>
                                    <input type="radio" name="colo" value="colo1" checked="checked"> White text - black background<br>
                                    <input type="radio" name="colo" value="colo2"> Black text - white background<br>
                                    <input type="radio" name="colo" value="colo3"> Black text - yellow background<br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right">
                                    <br>
                                    <button type="submit">Start New Prompter</button>
                                </td>
                            </tr>
                        </tbody></table>
                        <br>	</form>
                        </div>';
}

function ws_get_questions($block_id)
{
    $question = WSAdminDB::instance()->fetchQuestion($block_id);
    $questions = $question ? json_decode($question->questions) : [];
    return $questions ?? [];
}

function ws_short_code_content($args)
{
    return write_story_block_content($args);
}
add_shortcode('writestory_shortcode', 'ws_short_code_content');
add_filter('widget_text', 'do_shortcode');
