@extends('dashboard.Layout.main')

@section('main')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Formulir</h1>
</div>
<a href="/dashboard/menutemplate" class="btn btn-success mt-2 mb-2">Kembali</a>

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
        @if(old('questions'))
            @foreach(old('questions') as $index => $question)
                <div class="question-item mb-5" data-index="{{ $index }}">
                    <div class="col text-end">
                        <button type="button" class="btn btn-danger remove-question">Remove Question</button>
                    </div>


                    <div class="container overflow-hidden text-center">
                        <div class="row g-4 border-bottom border-2 border-primary">
                            <div class="col">                             
                                <div class="mb-3">
                                    <label class="form-label">Judul Pertanyaan</label>
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
                                    <select class="form-control type-select" name="questions[{{ $index }}][type]">
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
                                    <div class="row row-cols-auto">
                                        <div class="col">
                                            <div class="form-check">
                                                <label class="form-label">Required</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="questions[{{ $index }}][required]" value="1" {{ old('questions.'.$index.'.required') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label">Ya </label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="questions[{{ $index }}][required]" value="0" {{ old('questions.'.$index.'.required') == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label">Tidak </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3 mt-4">
                                    <label for="question-requirment" class="form-label">Question Requirement</label>
                                    <select class="form-select form-select-lg mb-3 @error('question-requirment') is-invalid @enderror" aria-label="Large select example" id="question-requirment" name="questions[{{ $index }}][question-requirment]">
                                        <option value="none" disabled>Pilih Syarat</option>
                                        @if(is_array(old('questions')))
                                            @foreach(old('questions') as $key => $q)
                                                @if($key != $index && isset($q['question']) && 
                                                    (isset($q['type']) && ($q['type'] == 'radio' || $q['type'] == 'dropdown' || $q['type'] == 'checkbox')))
                                                    <!-- Ensure $q has 'question' and 'type' is one of the desired types -->
                                                    <option value="{{ $q['question'] }}" {{ old('questions.'.$index.'.question-requirment') == $q['question'] ? 'selected' : '' }}>
                                                        {{ $q['question'] }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('question-requirment')
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
                                    <select class="form-select form-select-lg mb-3 @error('section') is-invalid @enderror" aria-label="Large select example" id="section" name="questions[{{ $index }}][section]">
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" {{ old('questions.'.$index.'.section') == $i ? 'selected' : '' }}>{{ $i }}</option> 
                                        @endfor    
                                    </select>
                                    @error('section')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <button type="button" class="btn btn-secondary mt-2 mb-5" id="add-question">Add Question</button>
    <button type="submit" class="btn btn-primary mt-2 mb-5">Create</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const oldQuestions = @json(old('questions', null)); // Cek data old() dari Laravel
        const questionsFromDb = @json($template->questions); // Data asli dari database
        let questionIndex = @json(old('questions') ? count(old('questions')) : 0);
        let formData = {};
        updateRequirementValues();

        // Jika ada data dari old(), gunakan itu. Jika tidak, gunakan data dari database.
        formData['questions'] = (oldQuestions || questionsFromDb).map((questionData, index) => {
            return {
                question: questionData.question,
                type: questionData.type,
                required: questionData.required,
                section: questionData.section,
                options: questionData.options || [],
                questionRequirement: questionData.question_requirment,
                questionRequirementValue: questionData.question_requirment_value,
                questionRequirementText: questionData.question_requirment_text
            };
        });

        // Perbarui form hanya saat pertama kali halaman dimuat
        if (!oldQuestions) {
            updateFormFromData(formData['questions']);

            // Step 2: Bangun peta indeks dan isi dropdown "question-requirment"
            const questionIndexMap = initializeQuestionRequirements();

            // Step 3: Atur nilai awal berdasarkan data backend
            setInitialRequirements(formData, questionIndexMap);
            console.log("From Database");
            console.log(formData);
            updateFormData();
        }


        if(oldQuestions){
            console.log("form Data");
            console.log(formData);
            console.log("oldQuestions");
            console.log(oldQuestions);
        }


        // formData['questions'] = questionsFromDb.map((questionData, index) => {
        //     return {
        //         question: questionData.question,
        //         type: questionData.type,
        //         required: questionData.required,
        //         options: questionData.options || [],
        //         questionRequirement: questionData.questionRequirement || 'None',
        //         questionRequirementValue: questionData.questionRequirementValue || ''
        //         };
        // });


        // // Memperbarui form dengan data dari formData
        // updateFormFromData(formData['questions']);

        

        console.log(formData);

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
                                       <div class="options-list"></div>
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

        // function updateRequirementValues() {
        //     document.querySelectorAll('.question-item').forEach(questionItem => {
        //         const requirementSelect = questionItem.querySelector('select[name^="questions"][name$="[question-requirment]"]');
        //         const valueField = questionItem.querySelector('select[name$="[question-requirment-value]"]');
        //         const selectedRequirement = requirementSelect ? requirementSelect.value : null;

        //         if (!requirementSelect || !valueField) return;

        //         if (selectedRequirement && selectedRequirement !== "None") {
        //             const selectedQuestionItem = Array.from(document.querySelectorAll('.question-item'))
        //                 .find(item => item.querySelector('.question-content').value === selectedRequirement);

        //             if (selectedQuestionItem) {
        //                 const options = selectedQuestionItem.querySelectorAll('.options-list input');
        //                 const selectedOptions = Array.from(options)
        //                     .filter(input => input.value && input.value.trim() !== '')
        //                     .map(input => input.value);

        //                 valueField.innerHTML = selectedOptions.length > 0
        //                     ? selectedOptions.map(opt => `<option value="${opt}">${opt}</option>`).join('')
        //                     : '<option value="none">none</option>';
        //                 valueField.value = selectedOptions.length > 0 ? selectedOptions[0] : 'none';
        //             }
        //         } else {
        //             valueField.innerHTML = '<option value="None" selected disabled>Pilih Nilai</option>';
        //             valueField.value = 'None';
        //         }
        //     });
        // }

        function updateFormFromData(questions) {
            const questionsList = formData['questions']
                .filter(q => q && q.question)
                .map((q, i) => ({ id: i, question: q.question })); // Map to usable list

            const questionsContainer = document.getElementById('questions-container');

            questions.forEach((questionData, index) => {
                // Create question template with fallback for missing question
                const questionTemplate = createQuestionTemplate(index, questionData.question || '', questionsList);

                // Insert the template into the container
                questionsContainer.insertAdjacentHTML('beforeend', questionTemplate);

                const questionItem = questionsContainer.querySelector(`.question-item[data-index="${index}"]`);

                // Set editor content and input value
                const editor = questionItem.querySelector('.editor');
                const questionContent = questionItem.querySelector('.question-content');
                if (editor && questionContent) {
                    editor.textContent = questionData.question || '';
                    questionContent.value = questionData.question || '';
                }

                // Set other values (type, options, etc.)
                questionItem.querySelector('.type-select').value = questionData.type || 'text';
                
                const requiredValue = questionData.required === true ? "1": "0";
                const requiredRadio = questionItem.querySelector(
                    `input[name="questions[${index}][required]"][value="${requiredValue}"]`
                );
                if (requiredRadio) requiredRadio.checked = true;


                // Set options
                const optionsList = questionItem.querySelector('.options-list');
                if (questionData.options && Array.isArray(questionData.options)) {
                    questionData.options.forEach(option => {
                        const optionElement = document.createElement('div');
                        optionElement.classList.add('input-group', 'mb-2');
                        optionElement.innerHTML = `
                            <input type="text" class="form-control" value="${option}" name="questions[${index}][options][]">
                            <button type="button" class="btn btn-danger remove-option">Remove</button>
                        `;
                        optionsList.appendChild(optionElement);
                    });
                }

                const optionsContainer = questionItem.querySelector('.options-container');
                    if (['radio', 'checkbox', 'dropdown'].includes(questionData.type)) {
                        optionsContainer.style.display = 'block';
                    } else {
                        optionsContainer.style.display = 'none';
                    }
                
                // Set nilai question-requirment dan question-requirment-value
            const requirementSelect = questionItem.querySelector('select[name^="questions"][name$="[question-requirment]"]');
            const valueSelect = questionItem.querySelector('select[name$="[question-requirment-value]"]');
            const requirementText = questionData.questionRequirementText || null;

            if (requirementText) {
                const matchedQuestion = questionsList.find(q => q.question === requirementText);

                if (matchedQuestion) {
                    requirementSelect.value = matchedQuestion.question;

                    // Ambil opsi terkait dari pertanyaan syarat
                    const selectedQuestionItem = Array.from(questionsContainer.querySelectorAll('.question-item'))
                        .find(item => item.querySelector('.question-content').value === matchedQuestion.question);

                    if (selectedQuestionItem) {
                        const options = selectedQuestionItem.querySelectorAll('.options-list input');
                        const selectedOptions = Array.from(options)
                            .filter(input => input.value.trim() !== '')
                            .map(input => input.value);

                        valueSelect.innerHTML = selectedOptions.map(opt => `<option value="${opt}">${opt}</option>`).join('');
                        valueSelect.value = questionData.questionRequirementValue || selectedOptions[0] || 'None';
                    }
                } else {
                    console.warn(`Pertanyaan syarat "${requirementText}" tidak ditemukan.`);
                    requirementSelect.value = "None";
                    valueSelect.innerHTML = '<option value="None" selected>Pilih Nilai</option>';
                }
            } else {
                requirementSelect.value = "None";
                valueSelect.innerHTML = '<option value="None" selected>Pilih Nilai</option>';
            }

                    
                const sectionField = questionItem.querySelector('select[name^="questions"][name$="[section]"]');
                    if (sectionField) {
                        sectionField.value = questionData.section || 'None';
                    }
            });

            updateRemoveButtons();
            updateQuestionRequirements();
            updateRequirementValues();
        }

        function initializeQuestionRequirements() {
            const questionIndexMap = {};
            const questionsList = document.querySelectorAll('.question-item');

            // Bangun peta indeks
            questionsList.forEach((item, index) => {
                const questionText = item.querySelector('.question-content').value.trim();
                if (questionText) {
                    questionIndexMap[questionText] = index;
                }
            });

            // Isi dropdown "question-requirment" untuk setiap pertanyaan
            questionsList.forEach((item, index) => {
                const requirementSelect = item.querySelector('select[name^="questions"][name$="[question-requirment]"]');
                let optionsHTML = '<option value="None" selected disabled>Pilih Syarat</option>';

                Object.keys(questionIndexMap).forEach((questionText, idx) => {
                    if (idx !== index) { // Hindari memilih diri sendiri
                        optionsHTML += `<option value="${questionText}">${questionText}</option>`;
                    }
                });

                requirementSelect.innerHTML = optionsHTML;
            });

            return questionIndexMap;
        }

        function setInitialRequirements(formData, questionIndexMap) {
            const questionsList = document.querySelectorAll('.question-item');

            questionsList.forEach((item, index) => {
                const requirementSelect = item.querySelector('select[name^="questions"][name$="[question-requirment]"]');
                const valueSelect = item.querySelector('select[name^="questions"][name$="[question-requirment-value]"]');
                const requirementText = formData.questions[index]?.questionRequirementText;

                // Atur nilai awal "question-requirment"
                if (requirementText && questionIndexMap[requirementText] !== undefined) {
                    requirementSelect.value = requirementText;

                    // Isi opsi "question-requirment-value" berdasarkan pertanyaan terkait
                    const relatedIndex = questionIndexMap[requirementText];
                    const relatedQuestion = document.querySelector(`.question-item[data-index="${relatedIndex}"]`);
                    const options = relatedQuestion.querySelectorAll('.options-list input');

                    valueSelect.innerHTML = '<option value="None" selected disabled>Pilih Nilai</option>';
                    options.forEach(option => {
                        if (option.value.trim()) {
                            const optionElement = document.createElement('option');
                            optionElement.value = option.value;
                            optionElement.textContent = option.value;
                            valueSelect.appendChild(optionElement);
                        }
                    });

                    // Atur nilai awal "question-requirment-value" jika ada
                    valueSelect.value = formData.questions[index]?.questionRequirementValue || 'None';
                } else {
                    requirementSelect.value = 'None';
                }
            });
        }



        
    });
    

</script>



@endsection

