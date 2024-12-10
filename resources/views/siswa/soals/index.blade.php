@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Soal untuk Sekolah: {{ Auth::user()->asal_sekolah }}</h1>
    @if($soals->isEmpty())
        <div class="alert alert-warning text-center">
            Belum ada soal yang tersedia untuk sekolah Anda.
        </div>
    @else
        <div class="row">
            @foreach($soals as $soal)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg border-0" style="background-color: #f8f9fa;">
                        <div class="card-header text-white" style="background-color: #70b3ff;">
                            <h5 class="card-title text-truncate text-center m-0">{{ $soal->soal }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small">Guru: {{ $soal->guru->name ?? 'Tidak diketahui' }}</p>
                            <a href="{{ route('soals.showPublic', $soal->id) }}" class="btn btn-primary btn-block">
                                Lihat Soal
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
