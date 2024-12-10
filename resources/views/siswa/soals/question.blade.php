@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header text-center py-3 bg-light">
                    <h4 class="fw-bold mb-0">Soal</h4>
                </div>
                <div class="card-body">
                    <!-- Timer dan soal -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <!-- Soal -->
                        <p class="fs-6 fw-semibold text-dark text-justify mb-0 flex-grow-1">
                            {{ $soal->soal }}
                        </p>
                        <!-- Timer -->
                        <span 
                            id="timer" 
                            class="badge bg-danger text-white fs-6 fw-bold ms-2 px-2 py-1"
                            style="white-space: nowrap; border-radius: 5px;"
                        >
                            00:10
                        </span>
                    </div>

                    <!-- Form untuk jawaban -->
                    <form id="answer-form" action="{{ route('siswa.submitAnswer', $soal->id) }}" method="POST">
                        @csrf
                        <div class="list-group mb-3">
                            @foreach($soal->jawabans as $jawaban)
                                <label class="list-group-item d-flex align-items-center py-2 gap-2">
                                    <input 
                                        type="radio" 
                                        name="jawaban_id" 
                                        value="{{ $jawaban->id }}" 
                                        required 
                                        class="form-check-input flex-shrink-0"
                                        style="width: 1rem; height: 1rem;"
                                    >
                                    <span class="flex-grow-1 text-dark fw-medium">
                                        {{ $jawaban->jawaban }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        
                        <!-- Hidden untuk soal selanjutnya -->
                        <input type="hidden" name="next_soal_id" value="{{ $nextSoal->id ?? '' }}">

                        <!-- Tombol navigasi -->
                        <div class="d-flex justify-content-between">
                            @if($nextSoal)
                                <button type="submit" class="btn btn-primary px-4">
                                    Next
                                </button>
                            @else
                                <button type="submit" class="btn btn-success px-4">
                                    Finish
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Timer Script -->
<script>
    let timer = 10; 
    const timerElement = document.getElementById('timer');
    const formElement = document.getElementById('answer-form');
    const nextSoalId = document.querySelector('input[name="next_soal_id"]').value;

    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60).toString().padStart(2, '0');
        const secs = (seconds % 60).toString().padStart(2, '0');
        return `${minutes}:${secs}`;
    }

    const countdown = setInterval(() => {
        timer--;
        timerElement.textContent = formatTime(timer);

        if (timer <= 0) {
            clearInterval(countdown);

            if (nextSoalId) {
                formElement.submit();
            } else {
                alert('Waktu habis! Anda telah menyelesaikan semua soal.');
                formElement.submit();
            }
        }
    }, 1000);
</script>
@endsection
