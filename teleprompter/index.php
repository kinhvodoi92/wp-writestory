<?php
$content = $_POST['ws_content'] ?? "Type or cut and paste your script here";
?>

<!DOCTYPE html>
<html>

<head>
    <title>CuePrompter.com - The Online Teleprompter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./prompter.css">
</head>

<body>
    <nav>
        <button id="play-pause" title="Play / Pause [Space]">
            <svg id="play" xmlns="http://www.w3.org/2000/svg" height="40" width="40">
                <path d="M13.333 31.583V8.25l18.334 11.667Zm2.792-11.666Zm0 6.625L26.5 19.917l-10.375-6.625Z" />
            </svg>
            <svg id="pause" xmlns="http://www.w3.org/2000/svg" height="40" width="40">
                <path d="M23.458 31.667V8.333H30v23.334Zm-13.458 0V8.333h6.542v23.334Z" />
            </svg>
        </button>
        <button id="align" title="Align text left / center">
            <svg id="center" xmlns="http://www.w3.org/2000/svg" height="40" width="40">
                <path d="M5 35v-2.792h30V35Zm6.792-6.792v-2.791H28.25v2.791ZM5 21.375v-2.75h30v2.75Zm6.792-6.792v-2.791H28.25v2.791ZM5 7.792V5h30v2.792Z" />
            </svg>
            <svg id="left" xmlns="http://www.w3.org/2000/svg" height="40" width="40">
                <path d="M5 35v-2.792h30V35Zm0-6.792v-2.791h19.792v2.791Zm0-6.833v-2.75h30v2.75Zm0-6.792v-2.791h19.792v2.791Zm0-6.791V5h30v2.792Z" />
            </svg>
        </button>
        <button id="flipx" title="Mirror text horizontally">
            <svg xmlns="http://www.w3.org/2000/svg" height="40" width="40">
                <path d="M15.875 35H7.792q-1.125 0-1.959-.833Q5 33.333 5 32.208V7.792q0-1.125.833-1.959Q6.667 5 7.792 5h8.083v2.792H7.792v24.416h8.083Zm2.792 3.333V1.667h2.791v36.666ZM32.208 7.792h-.375V5h.375q1.125 0 1.959.833.833.834.833 1.959v.375h-2.792Zm0 14.291v-4.166H35v4.166Zm0 12.917h-.375v-2.792h.375v-.375H35v.375q0 1.125-.833 1.959-.834.833-1.959.833Zm0-19.875v-4.167H35v4.167Zm0 13.917v-4.167H35v4.167Zm-8 5.958v-2.792h4.834V35Zm0-27.208V5h4.834v2.792Z" />
            </svg>
        </button>
        <button id="flipy" title="Mirror text vertically">
            <svg xmlns="http://www.w3.org/2000/svg" height="40" width="40">
                <path d="M 5 15.875 L 5 7.792 C 5 7.042 5.278 6.389 5.833 5.833 C 6.389 5.278 7.042 5 7.792 5 L 32.208 5 C 32.958 5 33.611 5.278 34.167 5.833 C 34.722 6.389 35 7.042 35 7.792 L 35 15.875 L 32.208 15.875 L 32.208 7.792 L 7.792 7.792 L 7.792 15.875 L 5 15.875 Z M 1.667 18.667 L 38.333 18.667 L 38.333 21.458 L 1.667 21.458 L 1.667 18.667 Z M 32.208 32.208 L 32.208 31.833 L 35 31.833 L 35 32.208 C 35 32.958 34.722 33.611 34.167 34.167 C 33.611 34.722 32.958 35 32.208 35 L 31.833 35 L 31.833 32.208 L 32.208 32.208 Z M 17.917 32.208 L 22.083 32.208 L 22.083 35 L 17.917 35 L 17.917 32.208 Z M 5 32.208 L 5 31.833 L 7.792 31.833 L 7.792 32.208 L 8.167 32.208 L 8.167 35 L 7.792 35 C 7.042 35 6.389 34.722 5.833 34.167 C 5.278 33.611 5 32.958 5 32.208 Z M 24.875 32.208 L 29.042 32.208 L 29.042 35 L 24.875 35 L 24.875 32.208 Z M 10.958 32.208 L 15.125 32.208 L 15.125 35 L 10.958 35 L 10.958 32.208 Z M 5 24.208 L 7.792 24.208 L 7.792 29.042 L 5 29.042 L 5 24.208 Z M 32.208 24.208 L 35 24.208 L 35 29.042 L 32.208 29.042 L 32.208 24.208 Z" />
            </svg>
        </button>
        <button id="expand" title="Expand">
            <svg xmlns="http://www.w3.org/2000/svg" height="40" width="40">
                <path d="m20 25.625-10-10 1.958-1.958L20 21.708l8.042-8.041 1.958 2Z" />
            </svg>
        </button>
        <div class="drawer">
            <div>
                <input type="color" id="bg-color" value="#000000">
                <div class="disable-select">Background color</div>
            </div>
            <div>
                <input type="color" id="text-color" value="#ffffff">
                <div class="disable-select">Text color</div>
            </div>
            <div>
                <input id="text-size" type="range" min="30" max="180" value="58" step="1">
                <div class="disable-select">Text size: <span id="text-size-display">58</span>px</div>
            </div>
            <div>
                <input id="margin" type="range" min="0" max="40" value="5" step="1">
                <div class="disable-select">Margin: <span id="margin-display">5</span>%</div>
            </div>
            <div>
                <input id="speed" type="range" min="1" max="50" value="10" step="1">
                <div class="disable-select">Speed: <span id="speed-display">10</span></div>
            </div>
        </div>
    </nav>
    <div class="content" spellcheck="false" contenteditable="true">
        <?= $content ?>
    </div>
    <div id="triangle" style="display: none"></div>
    <script src='./prompter.js' type="text/javascript"></script>
</body>

</html>
<?php
