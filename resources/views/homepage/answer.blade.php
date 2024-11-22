@extends('template.index')

@section('content')

<div class="section-title text-center mb-5 mt-5">
    <p class="fs-1 fw-bold">Data <span> {{ $form->nama }}</span></p>
</div>

<div id="questions-container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-end">
            <a href="/detail/template/{{ $form->template->slug }}" class="btn btn-success mt-2 mb-2">Kembali</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="/detail/answer" method="POST">
                @csrf  
                @foreach ($questions as $question)
                    <div class="form-group">
                        <label> {!! $question->question !!}</label>
                        @if ($question->type == 'text')
                            <input type="text" name="answers[{{ $question->id }}]" class="form-control" {{ $question->required ? 'required' : '' }}>
                        @elseif ($question->type == 'radio')
                            @foreach ($question->options ?? [] as $option)
                                <div class="form-check">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" class="form-check-input" {{ $question->required ? 'required' : '' }}>
                                    <label class="form-check-label">{{ $option }}</label>
                                </div>
                            @endforeach
                        @elseif ($question->type == 'dropdown')
                            <select name="answers[{{ $question->id }}]" class="form-control" {{ $question->required ? 'required' : '' }}>
                                @foreach ($question->options ?? [] as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        @elseif ($question->type == 'checkbox')
                        
                            @foreach ($question->options ?? [] as $option)
                                <div class="form-check">
                                    <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option }}" class="form-check-input">
                                    <label class="form-check-label">{{ $option }}</label>
                                </div>
                            @endforeach
                        @elseif ($question->type == 'textarea')
                            <textarea name="answers[{{ $question->id }}]" class="form-control" {{ $question->required ? 'required' : '' }}></textarea>
                        @endif
                    </div>
                @endforeach
                <input type="hidden" value="{{ $form->id }}" name="form_id">
                <input type="hidden" value="{{ $form->template_id }}" name="template_id">
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>
</div>

@endsection
