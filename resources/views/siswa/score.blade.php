@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center rounded-top py-4">
                    <h4 class="fw-semibold mb-0">Hasil Penilaian</h4>
                </div>
                <div class="card-body text-center py-5">
                    <h5 class="fw-bold mb-4">Skor Anda:</h5>
                    <h1 class="display-1 fw-bold text-success">{{ $skor }}%</h1>
                    
                    <p class="fs-5 mt-4 text-muted">
                        Anda menjawab <span class="text-success fw-bold">{{ $jawabanBenar }}</span> dari 
                        <span class="text-primary fw-bold">{{ $totalSoal }}</span> soal dengan benar.
                    </p>

                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg mt-4 px-5">
                        <i class="bi bi-house-fill me-2"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
