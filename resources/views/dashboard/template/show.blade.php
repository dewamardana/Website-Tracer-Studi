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
    @foreach ($template->questions as $index => $question)
        <div class="question-item mb-5" data-index="{{ $index }}">
            <div class="mb-3">
                <div class="row">
                    <div class="col text-start">
                        <label class="form-label fs-2 fw-bold">Judul Pertanyaan</label>
                    </div>
                </div>
                <div class="editor form-control" contenteditable="false">{{ $question->question }}</div>
                <input type="hidden" name="questions[{{ $index }}][question]" class="question-content" value="{{ $question->question }}" >
            </div>
            <div class="mb-3">
                <label class="form-label fs-2 fw-bold">Type</label>
                <select class="form-control type-select" name="questions[{{ $index }}][type]" disabled>
                    <option value="text" {{ $question->type == 'text' ? 'selected' : '' }}>Text</option>
                    <option value="radio" {{ $question->type == 'radio' ? 'selected' : '' }}>Radio</option>
                    <option value="dropdown" {{ $question->type == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                    <option value="checkbox" {{ $question->type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                    <option value="date" {{ $question->type == 'date' ? 'selected' : '' }}>Date</option>
                    <option value="email" {{ $question->type == 'email' ? 'selected' : '' }}>Email</option>
                    <option value="number" {{ $question->type == 'number' ? 'selected' : '' }}>Number</option>
                    <option value="range" {{ $question->type == 'range' ? 'selected' : '' }}>Range</option>
                    <option value="time" {{ $question->type == 'time' ? 'selected' : '' }}>Time</option>
                </select>
            </div>
            <div class="mb-3 options-container" style="display: {{ in_array($question->type, ['radio', 'dropdown', 'checkbox']) ? 'block' : 'none' }};">
                <label class="form-label fs-4 fw-bold">Options</label>
                <div class="options-list">
                    @foreach ($question->options ?? [] as $option)
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="questions[{{ $index }}][options][]" value="{{ $option }}" placeholder="Option" disabled>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-3">
                <div class="row text-start d-flex align-items-center">
                    <div class="col-sm-2 col-md-2">
                        <div class="form-check">
                            <label class="form-label fs-4 fw-bold">Required</label>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[{{ $index }}][required]" value="1" {{ $question->required == '1' ? 'checked' : '' }} disabled>
                            <label class="form-check-label">Ya </label>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="questions[{{ $index }}][required]" value="0" {{ $question->required == '0' ? 'checked' : '' }} disabled>
                            <label class="form-check-label">Tidak </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                    <label for="section" class="form-label">Section</label>
                    <select class="form-select form-select-lg mb-3" name="questions[{{ $index }}][section]" disabled>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ $question->section == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor    
                </select>
            </div>
        </div>
    @endforeach
</div>

@endsection
