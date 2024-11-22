
@extends('dashboard.Layout.main')

@section('main')
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <div class="fs-1 fw-bold text-center">Formulir Detail</div>
    </div>
    <a href="{{ route('templateDetail', ['kategori' => $template->kategori->slug]) }}" class="btn btn-success mt-2 mb-2">Kembali</a>

    <div class="mb-4">
        <div class="fs-4">Judul Formulir</div>
        <div class="fs-2 fw-bold">{{ $template->nama }}</div>
    </div>

    <div class="mb-5">
        <div class="fs-4">Nama Kategori</div>
        <div class="fs-2 fw-bold">{{ $template->kategori->nama }}</div>
    </div>
    
    <div id="questions-container">
    </div>

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
            updateFormData();
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
    

        function createQuestionTemplate(index, question, questionsList) {
            return `
                <div class="question-item mt-5" data-index="${index}">
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

        document.querySelectorAll('.editor').forEach(editor => initializeEditor(editor));


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




