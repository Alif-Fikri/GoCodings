@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary">
            <i class="bi bi-journal-bookmark-fill text-warning me-2"></i> Dashboard Guru
        </h1>
        <a href="{{ route('guru.createSoal') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Buat Soal Baru
        </a>
    </div>

    @if ($soals->isEmpty())
        <!-- Empty Alert -->
        <div class="alert alert-warning text-center shadow-sm" role="alert">
            <i class="bi bi-exclamation-circle"></i> Tidak ada soal yang tersedia.
        </div>
    @else
        <!-- Soal Table -->
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle">
                <thead class="table-primary text-white">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Soal</th>
                        <th>Jawaban</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($soals as $soal)
                        <tr>
                            <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $soal->soal }}</td>
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($soal->jawabans as $jawaban)
                                        <li class="d-flex align-items-center">
                                            <i class="bi bi-dot text-primary me-2"></i> {{ $jawaban->jawaban }}
                                            @if ($jawaban->is_correct)
                                                <span class="badge bg-success ms-2">Benar</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('guru.editSoal', $soal->id) }}" 
                                       class="btn btn-sm btn-outline-primary d-flex align-items-center shadow-sm">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('guru.deleteSoal', $soal->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger d-flex align-items-center shadow-sm"
                                                onclick="return confirm('Yakin ingin menghapus soal ini?')">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
