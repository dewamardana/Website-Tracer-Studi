@extends('dashboard.Layout.main')

@section('main')
@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <div class="alert alert-primary" role="alert">
                    <li>{{ $error }}</li>
                </div>
            @endforeach
        </ul>
    </div>
@endif


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Template</h1>
</div>
<a href="{{ route('templateDetail', ['kategori' => $template->kategori_id]) }}" class="btn btn-success mt-2 mb-2">Kembali</a>

<form method="POST" action="/dashboard/menutemplate/template/{{ $template->id }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="form-title-input" class="form-label fs-2 fw-bold">Judul Form</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="form-title-input" name="nama"
        value="{{ old('nama', $template->nama) }}" required>
        @error('nama')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="kategori_id" class="form-label">Kategori</label>
        <select class="form-select form-select-lg mb-3 @error('kategori_id') is-invalid @enderror" aria-label="Large select example" id="kategori_id" name="kategori_id" required>
            <option selected disabled>Pilih Kategori</option>
            @foreach ($kategori as $t)
                <option value="{{ $t->id }}" {{ old('kategori_id', $template->kategori_id) == $t->id ? 'selected' : '' }}>{{ $t->nama }}</option>
            @endforeach
        </select>
        @error('kategori_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div id="questions-container">
        @foreach(old('questions', $template->questions) as $index => $question)
            <div class="question-item mb-4" data-index="{{ $index }}">
                <div class="mb-3">
                    <div class="row">
                        <div class="col text-start">
                            <label class="form-label">Judul Pertanyaan</label>
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
                    <div contenteditable="true" class="editor form-control">{{ old('questions.'.$index.'.question', $question['question'] ?? '') }}</div>
                    <input type="hidden" name="questions[{{ $index }}][question]" class="question-content" value="{{ old('questions.'.$index.'.question', $question['question'] ?? '') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select class="form-control type-select" name="questions[{{ $index }}][type]" required>
                        <option value="text" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'text' ? 'selected' : '' }}>Text</option>
                        <option value="radio" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'radio' ? 'selected' : '' }}>Radio</option>
                        <option value="dropdown" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                        <option value="checkbox" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                        <option value="date" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'date' ? 'selected' : '' }}>Date</option>
                        <option value="email" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="number" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'number' ? 'selected' : '' }}>Number</option>
                        <option value="range" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'range' ? 'selected' : '' }}>Range</option>
                        <option value="time" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'time' ? 'selected' : '' }}>Time</option>
                    </select>
                </div>
                <div class="mb-3 options-container" style="display: {{ in_array(old('questions.'.$index.'.type', $question['type'] ?? ''), ['radio', 'dropdown', 'checkbox']) ? 'block' : 'none' }};">
                    <label class="form-label">Options</label>
                    <div class="options-list">
                        @foreach(old('questions.'.$index.'.options', $question['options'] ?? []) as $option)
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="questions[{{ $index }}][options][]" value="{{ $option }}" placeholder="Option">
                                <button type="button" class="btn btn-danger remove-option">Remove</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-secondary add-option">Add Option</button>
                </div>
                <div class="mb-3">
                    <div class="row text-start">
                        <div class="col-sm-1 col-md-1">
                            <div class="form-check">
                                <label class="form-label">Required</label>
                            </div>
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="questions[{{ $index }}][required]" value="1" {{ old('questions.'.$index.'.required', $question['required'] ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label">Ya </label>
                            </div>
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="questions[{{ $index }}][required]" value="0" {{ old('questions.'.$index.'.required', $question['required'] ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label">Tidak </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button type="button" class="btn btn-secondary" id="add-question">Add Question</button>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let questionIndex = {{ count(old('questions', $template->questions)) }};

        function initializeEditor(editor) {
            editor.addEventListener('input', () => {
                const hiddenInput = editor.nextElementSibling;
                hiddenInput.value = editor.innerHTML;
            });
            initializeToolbar(editor);
        }

        function initializeToolbar(editor) {
            const toolbar = editor.previousElementSibling;
            toolbar.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', () => {
                    document.execCommand(button.getAttribute('data-command'), false, null);
                });
            });
        }

        function toggleOptions(container, type) {
            const optionsContainer = container.querySelector('.options-container');
            optionsContainer.style.display = ['radio', 'dropdown', 'checkbox'].includes(type) ? 'block' : 'none';
        }

        function updateRemoveButtons() {
            const removeButtons = document.querySelectorAll('.remove-question');
            removeButtons.forEach(button => button.disabled = removeButtons.length === 1);
        }

        function createQuestionTemplate(index) {
            return `
                <div class="question-item mb-4" data-index="${index}">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col text-start">
                                <label class="form-label">Judul Pertanyaan</label>
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
                        <input type="hidden" name="questions[${index}][question]" class="question-content">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-control type-select" name="questions[${index}][type]" required>
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
                        <div class="options-list"></div>
                        <button type="button" class="btn btn-secondary add-option">Add Option</button>
                    </div>
                    <div class="mb-3">
                        <div class="row text-start">
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <label class="form-label">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="questions[${index}][required]" value="1">
                                    <label class="form-check-label">Ya </label>
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="questions[${index}][required]" value="0">
                                    <label class="form-check-label">Tidak </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
        }

        document.getElementById('add-question').addEventListener('click', function () {
            const container = document.getElementById('questions-container');
            container.insertAdjacentHTML('beforeend', createQuestionTemplate(questionIndex));
            initializeEditor(container.lastElementChild.querySelector('.editor'));
            questionIndex++;
            updateRemoveButtons();
        });

        document.getElementById('questions-container').addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-question')) {
                event.target.closest('.question-item').remove();
                updateRemoveButtons();
            }

            if (event.target.classList.contains('add-option')) {
                const optionsList = event.target.closest('.options-container').querySelector('.options-list');
                optionsList.insertAdjacentHTML('beforeend', `
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="questions[${event.target.closest('.question-item').dataset.index}][options][]" placeholder="Option">
                        <button type="button" class="btn btn-danger remove-option">Remove</button>
                    </div>`);
            }

            if (event.target.classList.contains('remove-option')) {
                event.target.closest('.input-group').remove();
            }
        });

        document.getElementById('questions-container').addEventListener('change', function (event) {
            if (event.target.classList.contains('type-select')) {
                const type = event.target.value;
                const container = event.target.closest('.question-item');
                toggleOptions(container, type);
            }
        });

        // Initialize existing editors
        document.querySelectorAll('.editor').forEach(initializeEditor);
    });
</script>
@endsection













@extends('dashboard.Layout.main')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Formulir</h1>
</div>
<a href="/dashboard/menutemplate" class="btn btn-success mt-2 mb-2">Kembali</a>

<form method="POST" action="/dashboard/menutemplate/template">
    @csrf
    <div class="mb-3">
        <label for="form-title-input" class="form-label fs-2 fw-bold">Judul Template</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="form-title-input" name="nama"
        value="{{ old('nama') }}" required>
        @error('nama')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="kategori_id" class="form-label">Kategori</label>
        <select class="form-select form-select-lg mb-3 @error('kategori_id') is-invalid @enderror" aria-label="Large select example" id="kategori_id" name="kategori_id" required>
            <option selected disabled>Pilih Kategori</option>
            @foreach ($kategori as $k)
                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
            @endforeach
        </select>
        @error('kategori_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div id="questions-container">
        @if(old('questions'))
            @foreach(old('questions') as $index => $question)
                <div class="question-item mb-4" data-index="{{ $index }}">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col text-start">
                                <label class="form-label">Judul Pertanyaan</label>
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
                        <div contenteditable="true" class="editor form-control">{{ old('questions.'.$index.'.question') }}</div>
                        <input type="hidden" name="questions[{{ $index }}][question]" class="question-content" value="{{ old('questions.'.$index.'.question') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-control type-select" name="questions[{{ $index }}][type]" required>
                            <option value="text" {{ old('questions.'.$index.'.type') == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="radio" {{ old('questions.'.$index.'.type') == 'radio' ? 'selected' : '' }}>Radio</option>
                            <option value="dropdown" {{ old('questions.'.$index.'.type') == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                            <option value="checkbox" {{ old('questions.'.$index.'.type') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                            <option value="date" {{ old('questions.'.$index.'.type') == 'date' ? 'selected' : '' }}>Date</option>
                            <option value="email" {{ old('questions.'.$index.'.type') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="number" {{ old('questions.'.$index.'.type') == 'number' ? 'selected' : '' }}>Number</option>
                            <option value="range" {{ old('questions.'.$index.'.type') == 'range' ? 'selected' : '' }}>Range</option>
                            <option value="time" {{ old('questions.'.$index.'.type') == 'time' ? 'selected' : '' }}>Time</option>
                        </select>
                    </div>
                    <div class="mb-3 options-container" style="display: {{ in_array(old('questions.'.$index.'.type'), ['radio', 'dropdown', 'checkbox']) ? 'block' : 'none' }};">
                        <label class="form-label">Options</label>
                        <div class="options-list">
                            @if(old('questions.'.$index.'.options'))
                                @foreach(old('questions.'.$index.'.options') as $option)
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="questions[{{ $index }}][options][]" value="{{ $option }}" placeholder="Option">
                                        <button type="button" class="btn btn-danger remove-option">Remove</button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-secondary add-option">Add Option</button>
                    </div>
                    <div class="mb-3">
                        <div class="row text-start">
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <label class="form-label">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="questions[{{ $index }}][required]" value="1" {{ old('questions.'.$index.'.required') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label">Ya </label>
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="questions[{{ $index }}][required]" value="0" {{ old('questions.'.$index.'.required') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label">Tidak </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="section" class="form-label">Section</label>
                        <select class="form-select form-select-lg mb-3 @error('section') is-invalid @enderror" aria-label="Large select example" id="section" name="questions[{{ $index }}][section]" required>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('questions.'.$index.'.section') == $i ? 'selected' : '' }}>{{ $i }}</option> 
                            @endfor    
                        </select>
                        @error('section')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <button type="button" class="btn btn-secondary" id="add-question">Add Question</button>
    <button type="submit" class="btn btn-primary">Create</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let questionIndex = {{ old('questions') ? count(old('questions')) : 0 }};
        
        function toggleOptions(container, type) {
            const optionsContainer = container.querySelector('.options-container');
            optionsContainer.style.display = ['radio', 'dropdown', 'checkbox'].includes(type) ? 'block' : 'none';
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
            removeButtons.forEach(button => button.disabled = removeButtons.length === 1);
        }

        function createQuestionTemplate(index) {
            return `
                <div class="question-item mb-4" data-index="${index}">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col text-start">
                                <label class="form-label">Judul Pertanyaan</label>
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
                        <input type="hidden" name="questions[${index}][question]" class="question-content">         
                    </div>  
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-control type-select" name="questions[${index}][type]" required>
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
                                <input type="text" class="form-control" name="questions[${index}][options][]" placeholder="Option">
                                <button type="button" class="btn btn-danger remove-option">Remove</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary add-option">Add Option</button>
                    </div>
                    <div class="mb-3">
                        <div class="row text-start">
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <label class="form-label">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="questions[${index}][required]" value="1">
                                    <label class="form-check-label">Ya </label>
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="questions[${index}][required]" value="0">
                                    <label class="form-check-label">Tidak </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="section" class="form-label">Section</label>
                        <select class="form-select form-select-lg mb-3 @error('section') is-invalid @enderror" aria-label="Large select example" id="section" name="questions[${index }][section]" required>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}</option> 
                            @endfor    
                        </select>
                        @error('section')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            `;
        }

        document.getElementById('add-question').addEventListener('click', function () {
            const questionsContainer = document.getElementById('questions-container');
            const newQuestion = document.createElement('div');
            newQuestion.innerHTML = createQuestionTemplate(questionIndex);
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
                const container = e.target.closest('.question-item');
                const optionsList = container.querySelector('.options-list');
                const newOption = document.createElement('div');
                newOption.classList.add('input-group', 'mb-2');
                newOption.innerHTML = `
                    <input type="text" class="form-control" name="questions[${container.dataset.index}][options][]" placeholder="Option">
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

            // Remove empty options
            document.querySelectorAll('input[name^="questions"][name$="[options][]"]').forEach(input => {
                if (!input.value.trim()) {
                    input.parentElement.remove();
                }
            });
        });

        updateRemoveButtons();

        // Initialize existing editors
        document.querySelectorAll('.editor').forEach(editor => initializeEditor(editor));
    });
</script>

@endsection






@extends('dashboard.Layout.main')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Formulir</h1>
</div>
<a href="/dashboard/menutemplate" class="btn btn-success mt-2 mb-2">Kembali</a>

<form method="POST" action="/dashboard/menutemplate/template">
    @csrf
    <div class="mb-3">
        <label for="form-title-input" class="form-label fs-2 fw-bold">Judul Template</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="form-title-input" name="nama"
        value="{{ old('nama') }}" required>
        @error('nama')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="kategori_id" class="form-label">Kategori</label>
        <select class="form-select form-select-lg mb-3 @error('kategori_id') is-invalid @enderror" aria-label="Large select example" id="kategori_id" name="kategori_id" required>
            <option selected disabled>Pilih Kategori</option>
            @foreach ($kategori as $k)
                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
            @endforeach
        </select>
        @error('kategori_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div id="questions-container">
        @if(old('questions'))
            @foreach(old('questions') as $index => $question)
                <div class="question-item mb-4" data-index="{{ $index }}">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col text-start">
                                <label class="form-label">Judul Pertanyaan</label>
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
                        <div contenteditable="true" class="editor form-control">{{ old('questions.'.$index.'.question') }}</div>
                        <input type="hidden" name="questions[{{ $index }}][question]" class="question-content" value="{{ old('questions.'.$index.'.question') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-control type-select" name="questions[{{ $index }}][type]" required>
                            <option value="text" {{ old('questions.'.$index.'.type') == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="radio" {{ old('questions.'.$index.'.type') == 'radio' ? 'selected' : '' }}>Radio</option>
                            <option value="dropdown" {{ old('questions.'.$index.'.type') == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                            <option value="checkbox" {{ old('questions.'.$index.'.type') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                            <option value="date" {{ old('questions.'.$index.'.type') == 'date' ? 'selected' : '' }}>Date</option>
                            <option value="email" {{ old('questions.'.$index.'.type') == 'email' ? 'selected' : '' }}>Email</option>
                            <option value="number" {{ old('questions.'.$index.'.type') == 'number' ? 'selected' : '' }}>Number</option>
                            <option value="range" {{ old('questions.'.$index.'.type') == 'range' ? 'selected' : '' }}>Range</option>
                            <option value="time" {{ old('questions.'.$index.'.type') == 'time' ? 'selected' : '' }}>Time</option>
                        </select>
                    </div>
                    <div class="mb-3 options-container" style="display: {{ in_array(old('questions.'.$index.'.type'), ['radio', 'dropdown', 'checkbox']) ? 'block' : 'none' }};">
                        <label class="form-label">Options</label>
                        <div class="options-list">
                            @if(old('questions.'.$index.'.options'))
                                @foreach(old('questions.'.$index.'.options') as $option)
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="questions[{{ $index }}][options][]" value="{{ $option }}" placeholder="Option">
                                        <button type="button" class="btn btn-danger remove-option">Remove</button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-secondary add-option">Add Option</button>
                    </div>
                    <div class="mb-3">
                        <div class="row text-start">
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <label class="form-label">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="questions[{{ $index }}][required]" value="1" {{ old('questions.'.$index.'.required') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label">Ya </label>
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="questions[{{ $index }}][required]" value="0" {{ old('questions.'.$index.'.required') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label">Tidak </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="section" class="form-label">Section</label>
                        <select class="form-select form-select-lg mb-3 @error('section') is-invalid @enderror" aria-label="Large select example" id="section" name="questions[{{ $index }}][section]" required>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('questions.'.$index.'.section') == $i ? 'selected' : '' }}>{{ $i }}</option> 
                            @endfor    
                        </select>
                        @error('section')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="questin-requirment" class="form-label">Question Requirment</label>
                        <select class="form-select form-select-lg mb-3 @error('questin-requirment') is-invalid @enderror" aria-label="Large select example" id="questin-requirment" name="questin-requirment" required>
                            <option selected disabled>Pilih Syarat</option>
                            @if(is_array(old('questions')))
                                @foreach(old('questions') as $i => $q)
                                    <option value="{{ $i }}"> {{ old('questions.'.$i.'.question') }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('questin-requirment')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <button type="button" class="btn btn-secondary" id="add-question">Add Question</button>
    <button type="submit" class="btn btn-primary">Create</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let questionIndex = {{ old('questions') ? count(old('questions')) : 0 }};
        
        function toggleOptions(container, type) {
            const optionsContainer = container.querySelector('.options-container');
            optionsContainer.style.display = ['radio', 'dropdown', 'checkbox'].includes(type) ? 'block' : 'none';
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
            removeButtons.forEach(button => button.disabled = removeButtons.length === 1);
        }

        function createQuestionTemplate(index) {
            return `
                <div class="question-item mb-4" data-index="${index}">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col text-start">
                                <label class="form-label">Judul Pertanyaan</label>
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
                        <input type="hidden" name="questions[${index}][question]" class="question-content">         
                    </div>  
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-control type-select" name="questions[${index}][type]" required>
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
                                <input type="text" class="form-control" name="questions[${index}][options][]" placeholder="Option">
                                <button type="button" class="btn btn-danger remove-option">Remove</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary add-option">Add Option</button>
                    </div>
                    <div class="mb-3">
                        <div class="row text-start">
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <label class="form-label">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="questions[${index}][required]" value="1">
                                    <label class="form-check-label">Ya </label>
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="questions[${index}][required]" value="0">
                                    <label class="form-check-label">Tidak </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="section" class="form-label">Section</label>
                        <select class="form-select form-select-lg mb-3 @error('section') is-invalid @enderror" aria-label="Large select example" id="section" name="questions[${index }][section]" required>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}</option> 
                            @endfor    
                        </select>
                        @error('section')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="questin-requirment" class="form-label">Question Requirment</label>
                    <select class="form-select form-select-lg mb-3 @error('questin-requirment') is-invalid @enderror" aria-label="Large select example" id="questin-requirment" name="questin-requirment" required>
                        <option selected disabled>Pilih Syarat</option>
                        @if(is_array(old('questions')))
                            @foreach(old('questions') as $i => $q)
                                <option value="{{ $i }}"> {{ old('questions.'.$i.'.question') }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('questin-requirment')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            `;
        }

        document.getElementById('add-question').addEventListener('click', function () {
            const questionsContainer = document.getElementById('questions-container');
            const newQuestion = document.createElement('div');
            newQuestion.innerHTML = createQuestionTemplate(questionIndex);
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
                const container = e.target.closest('.question-item');
                const optionsList = container.querySelector('.options-list');
                const newOption = document.createElement('div');
                newOption.classList.add('input-group', 'mb-2');
                newOption.innerHTML = `
                    <input type="text" class="form-control" name="questions[${container.dataset.index}][options][]" placeholder="Option">
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

            // Remove empty options
            document.querySelectorAll('input[name^="questions"][name$="[options][]"]').forEach(input => {
                if (!input.value.trim()) {
                    input.parentElement.remove();
                }
            });
        });

        updateRemoveButtons();

        // Initialize existing editors
        document.querySelectorAll('.editor').forEach(editor => initializeEditor(editor));
    });
</script>

@endsection




{{-- halaman edit --}}



@extends('dashboard.Layout.main')

@section('main')
@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    <li>{{ $error }}</li>
                </div>
            @endforeach
        </ul>
    </div>
@endif
@if (session('warning'))
    <div class="alert alert-warning mt-1" role="alert">
		{{ session('warning') }}
  	</div>
@endif


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Template</h1>
</div>
<a href="{{ route('templateDetail', ['kategori' => $template->kategori->slug]) }}" class="btn btn-success mt-2 mb-2">Kembali</a>

<form method="POST" action="/dashboard/menutemplate/template/{{ $template->slug }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="nama" class="form-label fs-2 fw-bold">Judul Form</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
        value="{{ old('nama', $template->nama) }}" required>
        @error('nama')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div class="mb-3">
        <label for="kategori_id" class="form-label">Kategori</label>
        <select class="form-select form-select-lg mb-3 @error('kategori_id') is-invalid @enderror" aria-label="Large select example" id="kategori_id" name="kategori_id" required>
            <option selected disabled>Pilih Kategori</option>
            @foreach ($kategori as $t)
                <option value="{{ $t->id }}" {{ old('kategori_id', $template->kategori_id) == $t->id ? 'selected' : '' }}>{{ $t->nama }}</option>
            @endforeach 
        </select>
        @error('kategori_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    
    <div id="questions-container">
        @foreach(old('questions', $template->questions) as $index => $question)
            <div class="question-item mb-5" data-index="{{ $index }}">
                <div class="col text-end">
                    <button type="button" class="btn btn-danger remove-question">Remove Question</button>
                </div>

                <div class="row">
                    <div class="col">

                        <div class="mb-3">
                            <label class="form-label">Judul Pertanyaan</label>
                            <div class="text-bg-light toolbar">
                                <button type="button" class="btn" data-command="bold"><b>B</b></button>
                                <button type="button" class="btn" data-command="italic"><i>I</i></button>
                                <button type="button" class="btn" data-command="underline"><u>U</u></button>
                                <button type="button" class="btn" data-command="createLink">Link</button>
                            </div>
                            <div contenteditable="true" class="editor form-control">{{ old('questions.'.$index.'.question', $question['question'] ?? '') }}</div>
                            <input type="hidden" name="questions[{{ $index }}][question]" class="question-content" value="{{ old('questions.'.$index.'.question', $question['question'] ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select class="form-control type-select" name="questions[{{ $index }}][type]" required>
                                <option value="text" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'text' ? 'selected' : '' }}>Text</option>
                                <option value="radio" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'radio' ? 'selected' : '' }}>Radio</option>
                                <option value="dropdown" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                                <option value="checkbox" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                <option value="date" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'date' ? 'selected' : '' }}>Date</option>
                                <option value="email" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="number" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'number' ? 'selected' : '' }}>Number</option>
                                <option value="range" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'range' ? 'selected' : '' }}>Range</option>
                                <option value="time" {{ old('questions.'.$index.'.type', $question['type'] ?? '') == 'time' ? 'selected' : '' }}>Time</option>
                            </select>
                        </div>
                        <div class="mb-3 options-container" style="display: {{ in_array(old('questions.'.$index.'.type', $question['type'] ?? ''), ['radio', 'dropdown', 'checkbox']) ? 'block' : 'none' }};">
                            <label class="form-label">Options</label>
                            <div class="options-list">
                                @foreach(old('questions.'.$index.'.options', $question['options'] ?? []) as $option)
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="questions[{{ $index }}][options][]" value="{{ $option }}" placeholder="Option">
                                        <button type="button" class="btn btn-danger remove-option">Remove</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-secondary add-option">Add Option</button>
                        </div>
                        <div class="mb-3">
                            <div class="row row-cols-auto">
                                <div class="col">
                                    <div class="form-check">
                                        <label class="form-label">Required</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="questions[{{ $index }}][required]" value="1" {{ old('questions.'.$index.'.required', $question['required'] ?? '') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label">Ya </label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="questions[{{ $index }}][required]" value="0" {{ old('questions.'.$index.'.required', $question['required'] ?? '') == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label">Tidak </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col">

                        <div class="mb-3 mt-4">
                            <label for="question-requirment" class="form-label">Question Requirement</label>
                            <select class="form-select form-select-lg mb-3 @error('questions.'.$index.'.question-requirment') is-invalid @enderror"
                                aria-label="Large select example" id="question-requirment"
                                name="questions[{{ $index }}][question-requirment]">
                                <option value="" disabled {{ empty(old('questions.'.$index.'.question-requirment', $question['question_requirment'] ?? '')) ? 'selected' : '' }}>Pilih Syarat</option>

                                @foreach($template->questions as $q)
                                    @if($q->id != ($question['id'] ?? null) && in_array($q->type, ['radio', 'dropdown', 'checkbox']))
                                        <option value="{{ $q->id }}"
                                            {{ old('questions.'.$index.'.question-requirment', $question['question_requirment'] ?? '') == $q->id ? 'selected' : '' }}>
                                            {{ $q->question }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('questions.'.$index.'.question-requirment')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="question-requirment-value" class="form-label">Question Requirement Value</label>
                            <select class="form-select form-select-lg mb-3 @error('question-requirment-value') is-invalid @enderror" aria-label="Large select example" id="question-requirment-value-{{ $index }}" name="questions[{{ $index }}][question-requirment-value]">
                                <option value="none" disabled>Pilih Syarat</option>
                                @if(old('questions.'.$index.'.question-requirment-value'))
                                    @php
                                        // Ambil opsi yang sesuai dengan pertanyaan yang dipilih
                                        $selectedRequirement = old('questions.'.$index.'.question-requirment');
                                        $options = $kategori->find($selectedRequirement)->options ?? [];
                                    @endphp
                                    @foreach($options as $option)
                                        <option value="{{ $option }}" {{ old('questions.'.$index.'.question-requirment-value') == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('question-requirment-value')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        
                        <div class="mb-3">
                            <label for="section" class="form-label">Section</label>
                            <select class="form-select form-select-lg mb-3" aria-label="Large select example" id="section" name="questions[{{ $index }}][section]" required>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('questions.'.$index.'.section', $question['section'] ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor    
                            </select>
                        </div>

                    </div>
                </div>  
            </div>
        @endforeach
    </div>
    <button type="button" class="btn btn-secondary" id="add-question">Add Question</button>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // let questionIndex = {{ old('questions') ? count(old('questions')) : 0 }};
        let questionIndex = @json(old('questions') ? count(old('questions')) : 0);
        let formData = {};
        updateRequirementValues();

        function toggleOptions(container, type) {
            const optionsContainer = container.querySelector('.options-container');
            optionsContainer.style.display = ['radio', 'dropdown', 'checkbox'].includes(type) ? 'block' : 'none';
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
            removeButtons.forEach(button => button.disabled = removeButtons.length === 1);
        }
    

        function createQuestionTemplate(index, question, questionsList) {
            return `
                <div class="question-item mt-5" data-index="${index}">
                    <div class="col text-end">
                        <button type="button" class="btn btn-danger remove-question">Remove Question</button>
                    </div>
                    <div class="row g-4 border-bottom border-2 border-primary">
                        <div class="col">
                            <div class="mb-3">
                                <div class="col text-start">
                                    <label class="form-label">Judul Pertanyaan</label>
                                </div>   
                                <div class="text-bg-light toolbar">
                                    <button type="button" class="btn" data-command="bold"><b>B</b></button>
                                    <button type="button" class="btn" data-command="italic"><i>I</i></button>
                                    <button type="button" class="btn" data-command="underline"><u>U</u></button>
                                    <button type="button" class="btn" data-command="createLink">Link</button>
                                </div>
                                <div contenteditable="true" class="editor form-control"></div>
                                <input type="hidden" name="questions[${index}][question]" class="question-content" value="${question}">         
                            </div>  
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select class="form-control type-select" name="questions[${index}][type]">
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
                                        <input type="text" class="form-control" name="questions[${index}][options][]" placeholder="Option">
                                        <button type="button" class="btn btn-danger remove-option">Remove</button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary add-option">Add Option</button>
                            </div>  
                            <div class="mb-3">
                                <div class="row row-cols-auto">
                                    <div class="col">
                                        <div class="form-check">
                                            <label class="form-label">Required</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="questions[${index}][required]" value="1">
                                            <label class="form-check-label">Ya </label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="questions[${index}][required]" value="0">
                                            <label class="form-check-label">Tidak </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col"> 
                            <div class="mb-3 mt-4">
                                <label for="question-requirment" class="form-label">Question Requirement</label>
                                <select class="form-select form-select-lg mb-3" aria-label="Large select example" id="question-requirment" name="questions[${index}][question-requirment]">
                                    <option value="None" selected disabled>Pilih Syarat</option> 
                                    ${questionsList.map((q) => `<option value="${q.id}">${q.question}</option>`).join('')}
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="question-requirment-value" class="form-label">Value from Question Requirement</label>
                                <select class="form-select form-select-lg mb-3" aria-label="Select example" id="question-requirment-value" name="questions[${index}][question-requirment-value]">
                                    <option value="None" selected disabled>Pilih Nilai</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="section" class="form-label">Section</label>
                                <select class="form-select form-select-lg mb-3" aria-label="Large select example" id="section" name="questions[${index}][section]">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option> 
                                    @endfor    
                                </select>
                                @error('section')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>    
                </div>
            `;
        }

        document.addEventListener('change', function(event) {
            if (event.target.id === `question-requirment`) {
                const selectedValue = event.target.value;
                const questionItem = event.target.closest('.question-item');
                const valueField = questionItem.querySelector('#question-requirment-value');
                valueField.value = selectedValue; // Set the value in the new field
            }
        });

        
        // ${questionsList.map((q, idx) => idx !== index ? `<option value="${q}">${q}</option>` : '').join('')}

        function updateFormData() {
            formData['questions'] = [];
            document.querySelectorAll('.question-item').forEach((questionItem, index) => {
                let questionData = {};
                questionData['question'] = questionItem.querySelector('.question-content').value;
                questionData['type'] = questionItem.querySelector('.type-select').value;

                
                
                
                if (['radio', 'dropdown', 'checkbox'].includes(questionData['type'])) {
                    const requiredInput = questionItem.querySelector('input[name="questions[' + index + '][required]"]:checked');
                    questionData['required'] = requiredInput ? requiredInput.value : null;

                    questionData['options'] = [];
                    questionItem.querySelectorAll('.options-list input').forEach(optionInput => {
                        if(optionInput.value.trim() !== '') { // Pastikan opsi tidak kosong
                            questionData['options'].push(optionInput.value.trim());
                        }
                    });
                }

                if(questionData['question'] && questionData['type']) {
                    formData['questions'].push(questionData);
                }

            });
            console.log('Updated formData:', formData);
        }

        // Menampilkan nilai opsi yang dipilih di field "Value from Question Requirement"
        document.addEventListener('change', function(event) {
            if (event.target.matches('select[name^="questions"][name$="[question-requirment]"]')) {
                const questionItem = event.target.closest('.question-item');
                const valueSelect = questionItem.querySelector('select[name$="[question-requirment-value]"]');
                const selectedRequirement = event.target.value;

                // Kosongkan select value field
                valueSelect.innerHTML = '<option value="None" selected disabled>Pilih Nilai</option>'; // Reset options

                // Temukan pertanyaan yang dipilih sebagai syarat
                const selectedQuestionItem = Array.from(document.querySelectorAll('.question-item'))
                    .find(item => item.querySelector('.question-content').value === selectedRequirement);

                // Ambil nilai opsi yang sesuai dari pertanyaan yang dipilih
                if (selectedQuestionItem) {
                    const options = selectedQuestionItem.querySelectorAll('.options-list input');
                    const selectedOptions = Array.from(options)
                        .filter(input => input.value && input.value.trim() !== '')  // Pastikan opsi tidak kosong
                        .map(input => input.value);  // Ambil nilai dari input

                    // Tambahkan opsi ke select value field
                    selectedOptions.forEach(option => {
                        const newOption = document.createElement('option');
                        newOption.value = option;
                        newOption.textContent = option;
                        valueSelect.appendChild(newOption);
                    });
                }else {
                // Jika tidak ada pertanyaan yang dipilih, set value field ke kosong
                valueSelect.innerHTML = '<option value="" selected disabled>Pilih Nilai</option>';
            }
            }
        });

        function updateQuestionIndex() {
            document.querySelectorAll('.question-item').forEach((item, index) => {
                item.setAttribute('data-index', index);
                item.querySelector('.type-select').setAttribute('name', `questions[${index}][type]`);
                item.querySelector('.question-content').setAttribute('name', `questions[${index}][question]`);
                
                // Update required name
                item.querySelectorAll('input[name^="questions"][name$="[required]"]').forEach(input => {
                    input.setAttribute('name', `questions[${index}][required]`);
                });
                
                // Update section name
                item.querySelector('select[name^="questions"][name$="[section]"]').setAttribute('name', `questions[${index}][section]`);
                
                // Update options
                item.querySelectorAll('.options-list input').forEach((optionInput, optionIndex) => {
                    optionInput.setAttribute('name', `questions[${index}][options][]`);
                });

                // Update question-requirment name
                item.querySelector('select[name^="questions"][name$="[question-requirment]"]').setAttribute('name', `questions[${index}][question-requirment]`);
            });
        }

        document.getElementById('add-question').addEventListener('click', function () {
            updateFormData();

            // Ambil daftar pertanyaan yang valid untuk dijadikan opsi "Question Requirement"
            const questionsList = formData['questions'].map(q => q.question).filter(q => q && q.trim() !== '');

            // Tambahkan pertanyaan baru
            const questionsContainer = document.getElementById('questions-container');
            const newQuestion = document.createElement('div');
            newQuestion.innerHTML = createQuestionTemplate(questionIndex, '', questionsList);
            questionsContainer.appendChild(newQuestion);


            // Initialize editor and update the new question's index
            initializeEditor(newQuestion.querySelector('.editor'));

            // Update semua indeks untuk pertanyaan yang ada
            updateQuestionIndex();

            // Perbarui dropdown "Question Requirement" untuk semua pertanyaan
            updateQuestionRequirements();

            updateRemoveButtons();
            
            questionIndex++;

        });

        // Fungsi untuk memperbarui dropdown "Question Requirement"
        function updateQuestionRequirements() {
            // Ambil daftar pertanyaan yang valid
            // const questionsList = Array.from(document.querySelectorAll('.question-content'))
            //                             .map(input => input.value.trim())
            //                             .filter(q => q !== '');

            const questionsList = formData['questions']
                                    .filter(q => ['radio', 'dropdown', 'checkbox'].includes(q.type)) // Hanya pertanyaan dengan tipe tertentu
                                    .map(q => q.question.trim())
                                    .filter(q => q !== '');

            document.querySelectorAll('.question-item').forEach((questionItem, index) => {
                const selectElement = questionItem.querySelector('select[name^="questions"][name$="[question-requirment]"]');
                const selectedValue = selectElement.value; // Simpan nilai yang sudah dipilih

                // Tetapkan opsi default saat tidak ada pertanyaan
                let optionsHTML = `<option value="" selected disabled>Pilih Syarat</option>`;
                optionsHTML += `<option value="None">None</option>`;

                // Filter pertanyaan untuk opsi, eksklusif diri sendiri
                const availableQuestions = questionsList.filter((q, idx) => idx !== index);

                // Bangun opsi baru berdasarkan pertanyaan yang tersedia
                availableQuestions.forEach(q => {
                    optionsHTML += `<option value="${q}">${q}</option>`;
                });

                selectElement.innerHTML = optionsHTML;

                // Set kembali nilai yang sudah dipilih jika masih tersedia
                if (selectedValue && availableQuestions.includes(selectedValue)) {
                    selectElement.value = selectedValue;
                } else {
                    selectElement.value = ''; // Reset ke opsi default jika nilai tidak tersedia
                }
            });
        }

        // Fungsi untuk memperbarui nilai dari semua `question-requirment-value`
        function updateRequirementValues() {
            document.querySelectorAll('.question-item').forEach(questionItem => {
                const requirementSelect = questionItem.querySelector('select[name^="questions"][name$="[question-requirment]"]');
                const valueField = questionItem.querySelector('select[name$="[question-requirment-value]"]');
                const selectedRequirement = requirementSelect ? requirementSelect.value : null;

                // Cek apakah requirementSelect dan valueField ada
                if (!requirementSelect || !valueField) {
                    console.warn("Requirement select atau value field tidak ditemukan untuk pertanyaan ini.");
                    return;
                }

                // Cek apakah pertanyaan syarat dipilih dan ada di list
                if (selectedRequirement && selectedRequirement !== "None") {
                    // Temukan pertanyaan yang dipilih sebagai syarat
                    const selectedQuestionItem = Array.from(document.querySelectorAll('.question-item'))
                        .find(item => item.querySelector('.question-content').value === selectedRequirement);

                    // Jika pertanyaan acuan masih ada
                    if (selectedQuestionItem) {
                        const options = selectedQuestionItem.querySelectorAll('.options-list input');
                        const selectedOptions = Array.from(options)
                            .filter(input => input.value && input.value.trim() !== '')
                            .map(input => input.value);

                        // Gabungkan semua nilai opsi menjadi satu string, atau set ke 'none' jika tidak ada opsi
                        valueField.innerHTML = selectedOptions.length > 0
                            ? selectedOptions.map(opt => `<option value="${opt}">${opt}</option>`).join('')
                            : '<option value="none">none</option>';
                        valueField.value = selectedOptions.length > 0 ? selectedOptions[0] : 'none';
                    } else {
                        // Jika pertanyaan acuan dihapus, atur valueField ke 'None'
                        valueField.innerHTML = '<option value="None" selected disabled>Pilih Nilai</option>';
                        valueField.value = 'None';
                    }
                } else {
                    // Kosongkan jika tidak ada pertanyaan syarat yang dipilih
                    valueField.innerHTML = '<option value="None" selected disabled>Pilih Nilai</option>';
                    valueField.value = 'None';
                }
            });
        }


        
        
        document.getElementById('questions-container').addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-question')) {
                const questionItem = e.target.closest('.question-item');
                questionItem.remove(); // Hapus elemen pertanyaan dari DOM
                updateFormData(); // Perbarui formData setelah pertanyaan dihapus
                updateQuestionIndex(); // Perbarui semua indeks
                updateQuestionRequirements(); // Perbarui opsi "Question Requirement"
                updateRequirementValues(); // Memanggil fungsi baru untuk memperbarui nilai
                updateRemoveButtons();
            }
            
                    document.getElementById('questions-container').addEventListener('change', function (e) {
                        if (e.target && e.target.classList.contains('type-select')) {
                            const container = e.target.closest('.question-item');
                            toggleOptions(container, e.target.value);
                        }
                    });

            if (e.target && e.target.classList.contains('add-option')) {
                const container = e.target.closest('.question-item');
                const optionsList = container.querySelector('.options-list');
                const newOption = document.createElement('div');
                newOption.classList.add('input-group', 'mb-2');
                newOption.innerHTML = `
                    <input type="text" class="form-control" name="questions[${container.dataset.index}][options][]" placeholder="Option">
                    <button type="button" class="btn btn-danger remove-option">Remove</button>
                `;
                optionsList.appendChild(newOption);
            }

            if (e.target && e.target.classList.contains('remove-option')) {
                e.target.parentElement.remove();
            }
        });

        document.querySelector('form').addEventListener('submit', (e) => {
            updateFormData(); // Pastikan formData diperbarui sebelum submit

            // Validasi bahwa setiap pertanyaan memiliki 'question-requirment' yang valid
            let valid = true;
            document.querySelectorAll('.question-item').forEach((questionItem, index) => {
                const questionRequirment = questionItem.querySelector('select[name^="questions"][name$="[question-requirment]"]').value;
                if (!questionRequirment) {
                    valid = false;
                    alert(`Pilih "Question Requirement" untuk pertanyaan ke-${index + 1}.`);
                }
            });

            if (!valid) {
                e.preventDefault(); // Batalkan submit jika validasi gagal
                return;
            }

            document.querySelectorAll('.editor').forEach(editor => {
                const hiddenInput = editor.nextElementSibling;
                hiddenInput.value = editor.innerHTML;
            });

            // Remove empty options
            document.querySelectorAll('input[name^="questions"][name$="[options][]"]').forEach(input => {
                if (!input.value.trim()) {
                    input.parentElement.remove();
                }
            });
        });

        updateRemoveButtons();

        // Initialize existing editors
        document.querySelectorAll('.editor').forEach(editor => initializeEditor(editor));
        
    });

</script>
@endsection



{{-- script pada halaman edit --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        let questionIndex = {{ count(old('questions', $template->questions)) }};

        function initializeEditor(editor) {
            editor.addEventListener('input', () => {
                const hiddenInput = editor.nextElementSibling;
                hiddenInput.value = editor.innerHTML;
            });
            initializeToolbar(editor);
        }

        function initializeToolbar(editor) {
            const toolbar = editor.previousElementSibling;
            toolbar.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', () => {
                    document.execCommand(button.getAttribute('data-command'), false, null);
                });
            });
        }

        function toggleOptions(container, type) {
            const optionsContainer = container.querySelector('.options-container');
            optionsContainer.style.display = ['radio', 'dropdown', 'checkbox'].includes(type) ? 'block' : 'none';
        }

        function updateRemoveButtons() {
            const removeButtons = document.querySelectorAll('.remove-question');
            removeButtons.forEach(button => button.disabled = removeButtons.length === 1);
        }

        function createQuestionTemplate(index) {
            return `
                <div class="question-item mb-4" data-index="${index}">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col text-start">
                                <label class="form-label">Judul Pertanyaan</label>
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
                        <input type="hidden" name="questions[${index}][question]" class="question-content">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-control type-select" name="questions[${index}][type]" required>
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
                        <div class="options-list"></div>
                        <button type="button" class="btn btn-secondary add-option">Add Option</button>
                    </div>
                    <div class="mb-3">
                        <div class="row text-start">
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <label class="form-label">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="questions[${index}][required]" value="1">
                                    <label class="form-check-label">Ya </label>
                                </div>
                            </div>
                            <div class="col-sm-1 col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="questions[${index}][required]" value="0">
                                    <label class="form-check-label">Tidak </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="section" class="form-label">Section</label>
                        <select class="form-select form-select-lg mb-3 @error('section') is-invalid @enderror" aria-label="Large select example" id="section" name="questions[${index }][section]" required>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}</option> 
                            @endfor    
                        </select>
                        @error('section')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>`;
        }

        document.getElementById('add-question').addEventListener('click', function () {
            const container = document.getElementById('questions-container');
            container.insertAdjacentHTML('beforeend', createQuestionTemplate(questionIndex));
            initializeEditor(container.lastElementChild.querySelector('.editor'));
            questionIndex++;
            updateRemoveButtons();
        });

        document.getElementById('questions-container').addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-question')) {
                event.target.closest('.question-item').remove();
                updateRemoveButtons();
            }

            if (event.target.classList.contains('add-option')) {
                const optionsList = event.target.closest('.options-container').querySelector('.options-list');
                optionsList.insertAdjacentHTML('beforeend', `
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="questions[${event.target.closest('.question-item').dataset.index}][options][]" placeholder="Option">
                        <button type="button" class="btn btn-danger remove-option">Remove</button>
                    </div>`);
            }

            if (event.target.classList.contains('remove-option')) {
                event.target.closest('.input-group').remove();
            }
        });

        document.getElementById('questions-container').addEventListener('change', function (event) {
            if (event.target.classList.contains('type-select')) {
                const type = event.target.value;
                const container = event.target.closest('.question-item');
                toggleOptions(container, type);
            }
        });

        // Initialize existing editors
        document.querySelectorAll('.editor').forEach(initializeEditor);
    });
</script> --}}
