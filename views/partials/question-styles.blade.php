@push('head')
<style>
.question {
    padding: 20px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: stretch;
}
.upcoming .question-body .text {
    font-weight: bold;
}
.question-body .type {
    float: right;
    margin-left: 20px;
}
.question.prev {
    border: solid 1px #ddd;
    border-radius: 4px;
}
.question-date {
    width: 4em;
    border-right: solid 1px #ddd;
    padding-right: 20px;
}
.question-date div {
    text-align: right;
    font-weight: bold;
}
.question-body {
    flex: 4;
    padding-left: 20px;
}
.question-body .prompt {
    margin-bottom: 0px;
}
.question-body .text,
.question-body .action {
    margin-top: 0px;
    margin-bottom: 0px;
}
.question.next .question-body .text {
    font-weight: bold;
    font-size: 1.2em;
}
.question-change {
    margin-right: -20px;
}
.answers p {
    font-size: 0.9em;
    color: #888;
}
</style>
@endpush
