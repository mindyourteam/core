const message = sessionStorage.getItem('flash');
if (message) {
    sessionStorage.removeItem('flash');
    UIkit.notification(`<span uk-icon='icon: check'></span> ${message}`, {
        pos: 'top-right',
        status: 'success'
    });
}

let question_id;

function create() {
    question_id = null;
    document.getElementById("verb").innerHTML = "anlegen";
    document.getElementById("question-name").value = "";
    document.getElementById("question-description").value = "";
    document.getElementById("question-roadmap").value = "---";
    document.getElementById("question-effort").value = "---";
    document.getElementById("question-eisenhower").value = "---";

    UIkit.modal(document.getElementById("overlay")).show();
}

function edit(question) {
    question_id = question.id;
    document.getElementById("verb").innerHTML = "bearbeiten";
    document.getElementById("question-body").value = question.body;
    document.getElementById("question-type").value = question.type;
    document.getElementById("question-min").value = question.min;
    document.getElementById("question-max").value = question.max;

    UIkit.modal(document.getElementById("overlay")).show();
}

function off() {
    UIkit.modal(document.getElementById("overlay")).hide();
}

function item_text(question) {
    return `<div class="type">${question.printable_type}</div>
            <p class="text">${question.body}</p>
            <p class="action">Stelle diese Frage <a href="">als nächstes</a>, 
                <a href="#" onclick="edit(JSON.parse(document.getElementById('question-${question.id}').dataset.question))">bearbeite</a> 
                oder <a href="">lösche</a> sie.</p>`;
}

function save() {
    const data = {
        body: document.getElementById("question-body").value,
        type: document.getElementById("question-type").value,
        min: document.getElementById("question-min").value,
        max: document.getElementById("question-max").value
    };
    const csrf = document.getElementById('overlay-text')._token.value;

    let method, url;
    if (question_id) {
        method = "PUT";
        url = "/culture/" +  question_id;
    }
    else {
        method = "POST";
        url = "/culture/{{ $question->id }}";
    }
    
    fetch(url, {
        method: method, 
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Concent-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log("Saved:", data);

        const updated = document.getElementsByClassName('updated');
        for (let el of updated) {
            el.classList.remove('updated');
        }

        const item = document.getElementById("question-" + data.question.id);

        if (item) {
            item.dataset.question = JSON.stringify(data.question);
            item.innerHTML = item_text(data.question);

            item.parentElement.classList.add('updated');
            UIkit.notification(`<span uk-icon='icon: check'></span> ${data.message}`, {
                pos: 'top-right',
                status: 'success'
            });
        }
        else {
            const li = document.createElement("LI");
            li.innerHTML = `<div class="float-right">
                    <a href="#" class="icon" onclick="edit(JSON.parse(document.getElementById('question-${data.question.id}').dataset.question))">✎</a>
                </div>
                <span id="question-${data.question.id}" data-question="${JSON.stringify(data.question)}">
                    ${item_text(data.question)}
                </span>`;

            li.classList.add('updated');
            document.getElementById("questions").appendChild(li);
            document.getElementById("empty").style.display = "none";   
        }
        off();
    });
}

function next(question_id) {
    const csrf = document.getElementById('overlay-text')._token.value;

    fetch('/culture/' + question_id + '/next', {
        method: 'POST', 
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Concent-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log("Next:", data);
        sessionStorage.setItem('flash', data.message);
        location.reload();
    });
}


function del(question_id) {
    const csrf = document.getElementById('overlay-text')._token.value;

    fetch('/culture/' + question_id + '/del', {
        method: 'POST', 
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Concent-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log("Del:", data);
        sessionStorage.setItem('flash', data.message);
        location.reload();
    });
}
