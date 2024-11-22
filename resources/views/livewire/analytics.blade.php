@extends('dashboard.Layout.main')

@section('main')
    <div class="container mt-4">
        <h1>{{ $FetchForm->nama }}</h1>

        <div class="card">
            <div class="card-header">
                @php
                    $count= $fetchJawabans->count();
                @endphp
               {{$count}} Jawaban
            </div>
            <div class="sub-nav">
                <ul class="d-flex justify-content-center align-items-center gap-5 mt-4"
                    style="list-style: none; text-decoration:none">
                    <li class="nav-item active" data-content="ringkasan">Ringkasan</li>
                    <li class="nav-item" data-content="pertanyaan">Diagram</li>
                    <li class="nav-item" data-content="individual">Individual</li>
                </ul>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="body p-5">
                <div id="ringkasan" class="content active">

    <!-- Konten untuk Ringkasan -->
    <h2>Ringkasan</h2>
    <br>
    @foreach ($questions as $question)
    <div class="card mb-4">
        <div class="card-header">
            <h5>{{ $question->q_questions }}</h5>
        </div>
        <div class="card-body">
            @php
                $groupedAnswers = $fetchAnswer->groupBy('question_id');
                $answers = $groupedAnswers->get($question->q_id) ?? collect();
                $answerCount = $answers->count();
            @endphp   
            <p><strong>{{ $answerCount }} Jawaban</strong></p>
            @if ($answers->isEmpty())
                <p class="text-muted">Belum ada jawaban untuk pertanyaan ini.</p>
            @else
            <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;">
                @foreach ($answers as $answer)
                <div class="form-control p-2" style="background-color: #F8F9FA; flex: 1 1 calc(33.33% - 10px);">
                    {{ $answer->answer }}
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    @endforeach


    <a href="{{ route('export.answers') }}" class="btn btn-success">Export to Excel</a>


                </div>
                <div id="pertanyaan" class="content" style="display: none;">
                    <!-- Konten untuk Pertanyaan -->
                    <h2>Diagram</h2>
                    <div>
                        <canvas id="myChart"></canvas>
                      </div>
        

                      
                      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                      
                      <script>
                         const labels = @json($FetchUser->pluck('name'));
                         var answerCounts = @json($FetchUser->pluck('answer_count'));
                        const ctx = document.getElementById('myChart');
                    
                        new Chart(ctx, {
                          type: 'doughnut',
                          data: {
                            labels: labels,
                            datasets: [{
                              label: 'Total Jawaban',
                              data: answerCounts,
                              borderWidth: 1
                            }]
                          },
                          options: {
                            scales: {
                              y: {
                                beginAtZero: true
                              }
                            }
                          }
                        });
                      </script>
                </div>
                <div id="individual" class="content" style="display: none;">
                    <!-- Konten untuk Individual -->
                    <h2>Individual</h2>
                    <p>Maintenance Halaman/p>
                </div>
            </div>
        </div>

    </div>
@endsection
