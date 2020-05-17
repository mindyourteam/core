const message = sessionStorage.getItem('flash');
if (message) {
    sessionStorage.removeItem('flash');
    UIkit.notification(`<span uk-icon='icon: check'></span> ${message}`, {
        pos: 'top-right',
        status: 'success'
    });
}
const updated = sessionStorage.getItem('updated');
if (updated) {
    sessionStorage.removeItem('updated');
    const item = document.getElementById("question-" + updated);
    item.parentElement.classList.add('updated');
}

let question_id;

function create() {
    question_id = null;
    document.getElementById("verb").innerHTML = "anlegen";
    document.getElementById("question-body").value = "";
    document.getElementById("question-type").value = "---";
    document.getElementById("question-min").value = "";
    document.getElementById("question-max").value = "";

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

function item_text(question, seq) {
    const result = `<div class="type">${question.printable_type}</div>
            <p class="text">${question.body}</p>`;

    if (seq == '0') {
        return result + `<p class="action"><a href="#" onclick="edit(JSON.parse(document.getElementById('question-${question.id}').dataset.question))">Bearbeite</a> 
        diese Frage oder <a href="#" onclick="del(${question.id})">lösche</a> sie.</p>
`
    }
    else {
        return result + `<p class="action">Stelle diese Frage <a href="#" onclick="next(${question.id})">als nächstes</a>, 
                <a href="#" onclick="edit(JSON.parse(document.getElementById('question-${question.id}').dataset.question))">bearbeite</a> 
                oder <a href="#" onclick="del(${question.id})">lösche</a> sie.</p>`;
    }
}

function save(event) {
    const body_field = document.getElementById("question-body");
    const type_field = document.getElementById("question-type");
    const min_field = document.getElementById("question-min");
    const max_field = document.getElementById("question-max");
    const data = {
        body: body_field.value,
        type: type_field.value,
        min: min_field.value,
        max: max_field.value
    };
    const csrf = document.getElementById('overlay-text')._token.value;

    msg = [];
    if (!data['body']) {
        msg.push('Gib bitte einen Fragetext ein');
        body_field.classList.add('uk-form-danger');
    }
    else {
        body_field.classList.remove('uk-form-danger');
    }
    if (data['type'] == '---') {
        msg.push('Wähle bitte einen Fragetyp');
        type_field.classList.add('uk-form-danger');
    }
    else {
        type_field.classList.remove('uk-form-danger');
    }
    if (data['type'] == '1to5' || data['type'] == '1to10') {
        if (!data['min']) {
            msg.push('Text für den min. Wert fehlt');
            min_field.classList.add('uk-form-danger');
        }
        else {
            min_field.classList.remove('uk-form-danger');
        }
        if (!data['max']) {
            msg.push('Text für den max. Wert fehlt');
            max_field.classList.add('uk-form-danger');
        }
        else {
            max_field.classList.remove('uk-form-danger');
        }
    }
    if (msg.length > 0) {
        event.preventDefault();
        const message = msg.join('<br>');
        UIkit.notification(message, {
            pos: 'top-right',
            status: 'danger'
        });
        return;
    }

    let method, url;
    if (question_id) {
        method = "PUT";
        url = "/culture/" +  question_id;
    }
    else {
        method = "POST";
        url = "/culture";
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
            item.innerHTML = item_text(data.question, item.dataset.seq);

            item.parentElement.classList.add('updated');
            UIkit.notification(`<span uk-icon='icon: check'></span> ${data.message}`, {
                pos: 'top-right',
                status: 'success'
            });
            off();
        }
        else {
            console.log("Created:", data);
            sessionStorage.setItem('flash', data.message);
            sessionStorage.setItem('updated', data.question.id);
            location.reload();
        }
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
        sessionStorage.setItem('updated', data.question.id);
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
