
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
                    {{-- Bagian dalam form HTML --}}
                    <div class="mb-3">
                        <label for="syarat" class="form-label">Syarat Pertanyaan</label>
                        <select class="form-select form-select-lg mb-3" name="questions[{{ $index }}][condition_question]" id="syarat">
                            <option value="" disabled selected>Pilih Pertanyaan Syarat</option>
                            @foreach (old('questions', []) as $i => $question)
                                @if($i !== $index)
                                    <option value="{{ $i }}" {{ old('questions.'.$index.'.condition_question') == $i ? 'selected' : '' }}>
                                        {{ $question['question'] }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                </div>
            @endforeach
        @endif
    </div>
    <button type="button" class="btn btn-secondary" id="add-question">Add Question</button>
    <button type="submit" class="btn btn-primary">Create</button>
</form>

<script>
    var oldQuestions = @json(old('questions', []));
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
            const questionContent = oldQuestions[index] ? oldQuestions[index].question : '';
            const questionType = oldQuestions[index] ? oldQuestions[index].type : 'text'
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
                        <label for="syarat" class="form-label">Syarat Pertanyaan</label>
                        <select class="form-select form-select-lg mb-3" name="questions[${index}][condition_question]" id="syarat">
                            <option value="" disabled selected>Pilih Pertanyaan Syarat</option>
                            @foreach (old('questions', []) as $i => $question)
                                @if($i !== $index)
                                    <option value="{{ $i }}" {{ old('questions.'.$index.'.condition_question') == $i ? 'selected' : '' }}>
                                        {{ $question['question'] }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
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

