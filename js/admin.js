var questionCount = 0;

function addQuestion(value) {
    questionCount++;
    var i = questionCount;

    var div = document.getElementById("question-list");
    var question = document.createElement("div");
    question.innerHTML = `<div id="writestory-admin-question-${i}" class="question-item">
        <strong style="margin-bottom: 4px;"> Question ${questionCount}:</strong >
            <div><input class="vsb_admin_input" name="questions[]" placeholder="Enter question ${questionCount}" required value="${value ?? ""}" />
            <button type="button" value="Remove" onclick="remove_question(${i})">Remove</button>
            </div>
        </div>`;
    div.appendChild(question);
}

function remove_question(index) {
    var element = document.getElementById(`writestory-admin-question-${index}`);
    if (element && element.parentNode) element.parentNode.removeChild(element);
}