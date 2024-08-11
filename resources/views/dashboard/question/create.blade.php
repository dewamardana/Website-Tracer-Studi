
@extends('dashboard.Layout.main')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Questions</h1>
</div>

<form method="POST" action="/">
    @csrf
    <div class="mb-3">
        <label for="form-title-input" class="form-label fs-2 fw-bold">Judul Form</label>
        <input type="text" class="form-control" id="form-title-input" name="form_title_main" required>
    </div>
    
    <div id="questions-container">
        <div class="question-item mb-4">
            <div class="mb-3">
                <div class="row">
                    <div class="col text-start">
                        <label for="question-title" class="form-label fs-4 fw-bold">Judul Pertanyaan</label>
                    </div>
                    <div class="col text-end">
                        <button type="button" class="btn btn-danger remove-question">Remove Question</button>
                    </div>
                </div>
                <div class="text-bg-light toolbar">
                    <button type="button" class="btn" data-command="bold"><b>B</b></button>
                    <button type="button" class="btn" data-command="italic"><i>I</i></button>
                    <button type="button" class="btn" data-command="underline"><u>U</u></button>
                    <button type="button" class="btn" data-command="createLink">Link</button>
                </div>
                <div contenteditable="true" class="editor form-control"></div>
                <input type="hidden" name="questions[0][question_title]" class="question-title">
            </div>
            <div class="mb-3">
                <label for="question" class="form-label">Question</label>
                <div class="text-bg-light toolbar">
                    <button type="button" class="btn" data-command="bold"><b>B</b></button>
                    <button type="button" class="btn" data-command="italic"><i>I</i></button>
                    <button type="button" class="btn" data-command="underline"><u>U</u></button>
                    <button type="button" class="btn" data-command="createLink">Link</button>
                </div>
                <div contenteditable="true" class="editor form-control"></div>
                <input type="hidden" name="questions[0][question]" class="question-content">
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-control type-select" name="questions[0][type]" required>
                    <option value="text">Text</option>
                    <option value="radio">Radio</option>
                    <option value="dropdown">Dropdown</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="date">Date</option>
                    <option value="email">Email</option>
                    <option value="number">Number</option>
                    <option value="range">Range</option>
                    <option value="time">Time</option>
                </select>
            </div>
            <div class="mb-3 options-container" style="display: none;">
                <label class="form-label">Options</label>
                <div class="options-list">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="questions[0][options][]" placeholder="Option">
                        <button type="button" class="btn btn-danger remove-option">Remove</button>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary add-option">Add Option</button>
            </div>
            <div class="mb-3">
                <div class="row text-start">
                    <div class="col-sm-1 col-md-1">
                        <div class="form-check">
                            <label for="flexRadioDefault1" class="form-label">Required</label>
                        </div>
                    </div>
                    <div class="col-sm-1 col-md-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[0][required]" id="flexRadioDefault1" value="true">
                            <label class="form-check-label" for="flexRadioDefault1">Ya </label>
                        </div>
                    </div>
                    <div class="col-sm-1 col-md-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[0][required]" id="flexRadioDefault2" value="false">
                            <label class="form-check-label" for="flexRadioDefault2">Tidak </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-secondary" id="add-question">Add Question</button>
    <button type="submit" class="btn btn-primary">Create</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let questionIndex = 1;

        function toggleOptions(container, type) {
            const optionsContainer = container.querySelector('.options-container');
            if (['radio', 'dropdown', 'checkbox'].includes(type)) {
                optionsContainer.style.display = 'block';
            } else {
                optionsContainer.style.display = 'none';
            }
        }

        function initializeToolbar(editor) {
            const toolbar = editor.previousElementSibling;
            toolbar.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', () => {
                    const command = button.getAttribute('data-command');
                    if (command === 'createLink') {
                        const url = prompt('Enter the link here: ', 'http://');
                        document.execCommand(command, false, url);
                    } else {
                        document.execCommand(command, false, null);
                    }
                });
            });
        }

        function initializeEditor(editor) {
            editor.addEventListener('input', () => {
                const hiddenInput = editor.nextElementSibling;
                hiddenInput.value = editor.innerHTML;
            });
            initializeToolbar(editor);
        }

        function updateRemoveButtons() {
            const removeButtons = document.querySelectorAll('.remove-question');
            if (removeButtons.length === 1) {
                removeButtons[0].disabled = true;
            } else {
                removeButtons.forEach(button => button.disabled = false);
            }
        }

        document.querySelectorAll('.editor').forEach(editor => {
            initializeEditor(editor);
        });

        document.getElementById('add-question').addEventListener('click', function () {
            const questionsContainer = document.getElementById('questions-container');
            const newQuestion = document.createElement('div');
            newQuestion.classList.add('question-item', 'mb-4');
            newQuestion.innerHTML = `
                <div class="mb-3">
                    <div class="row">
                        <div class="col text-start">
                            <label for="question-title" class="form-label fs-4 fw-bold">Judul Pertanyaan</label>
                        </div>
                        <div class="col text-end">
                            <button type="button" class="btn btn-danger remove-question">Remove Question</button>
                        </div>
                    </div>
                    <div class="text-bg-light toolbar">
                        <button type="button" class="btn" data-command="bold"><b>B</b></button>
                        <button type="button" class="btn" data-command="italic"><i>I</i></button>
                        <button type="button" class="btn" data-command="underline"><u>U</u></button>
                        <button type="button" class="btn" data-command="createLink">Link</button>
                    </div>
                    <div contenteditable="true" class="editor form-control"></div>
                    <input type="hidden" name="questions[${questionIndex}][question_title]" class="question-title">
                </div>
                <div class="mb-3">
                    <label for="question" class="form-label">Question</label>
                    <div class="text-bg-light toolbar">
                        <button type="button" class="btn" data-command="bold"><b>B</b></button>
                        <button type="button" class="btn" data-command="italic"><i>I</i></button>
                        <button type="button" class="btn" data-command="underline"><u>U</u></button>
                        <button type="button" class="btn" data-command="createLink">Link</button>
                    </div>
                    <div contenteditable="true" class="editor form-control"></div>
                    <input type="hidden" name="questions[${questionIndex}][question]" class="question-content">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-control type-select" name="questions[${questionIndex}][type]" required>
                        <option value="text">Text</option>
                        <option value="radio">Radio</option>
                        <option value="dropdown">Dropdown</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="date">Date</option>
                        <option value="email">Email</option>
                        <option value="number">Number</option>
                        <option value="range">Range</option>
                        <option value="time">Time</option>
                    </select>
                </div>
                <div class="mb-3 options-container" style="display: none;">
                    <label class="form-label">Options</label>
                    <div class="options-list">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="questions[${questionIndex}][options][]" placeholder="Option">
                            <button type="button" class="btn btn-danger remove-option">Remove</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary add-option">Add Option</button>
                </div>
                <div class="mb-3">
                <div class="row text-start">
                    <div class="col-sm-1 col-md-1">
                        <div class="form-check">
                            <label for="flexRadioDefault1" class="form-label">Required</label>
                        </div>
                    </div>
                    <div class="col-sm-1 col-md-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionIndex}][required]" id="flexRadioDefault1" value="true">
                            <label class="form-check-label" for="flexRadioDefault1">Ya </label>
                        </div>
                    </div>
                    <div class="col-sm-1 col-md-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[${questionIndex}][required]" id="flexRadioDefault2" value="false">
                            <label class="form-check-label" for="flexRadioDefault2">Tidak </label>
                        </div>
                    </div>
                </div>
            </div>
            `;
            questionsContainer.appendChild(newQuestion);
            initializeEditor(newQuestion.querySelector('.editor'));
            questionIndex++;
            updateRemoveButtons();
        });

        document.getElementById('questions-container').addEventListener('change', function (e) {
            if (e.target && e.target.classList.contains('type-select')) {
                const container = e.target.closest('.question-item');
                toggleOptions(container, e.target.value);
            }
        });

        document.getElementById('questions-container').addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-question')) {
                e.target.closest('.question-item').remove();
                updateRemoveButtons();
            }

            if (e.target && e.target.classList.contains('add-option')) {
                const optionsList = e.target.closest('.question-item').querySelector('.options-list');
                const newOption = document.createElement('div');
                newOption.classList.add('input-group', 'mb-2');
                newOption.innerHTML = `
                    <input type="text" class="form-control" name="questions[${questionIndex}][options][]" placeholder="Option">
                    <button type="button" class="btn btn-danger remove-option">Remove</button>
                `;
                optionsList.appendChild(newOption);
            }

            if (e.target && e.target.classList.contains('remove-option')) {
                e.target.parentElement.remove();
            }
        });

        document.querySelector('form').addEventListener('submit', () => {
            document.querySelectorAll('.editor').forEach(editor => {
                const hiddenInput = editor.nextElementSibling;
                hiddenInput.value = editor.innerHTML;
            });
        });

        updateRemoveButtons();
    });
</script>

@endsection




