@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Soal</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $soal->soal }}</h5>
            <p class="text-muted">Guru: {{ $soal->guru->name ?? 'Tidak diketahui' }}</p>

            <form action="{{ route('siswa.submitJawaban', $soal->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="jawaban">Jawaban Anda</label>
                    <textarea id="jawaban" name="jawaban" class="form-control" rows="4" required placeholder="Tulis jawaban Anda di sini"></textarea>
                </div>
                <button type="submit" class="btn btn-success btn-block mt-3">Kirim Jawaban</button>
            </form>
        </div>
    </div>
</div>
@endsection
