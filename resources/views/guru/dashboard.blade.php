@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary">Dashboard Guru</h1>
        <a href="{{ route('guru.createSoal') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Buat Soal Baru
        </a>
    </div>

    @if ($soals->isEmpty())
        <div class="alert alert-warning text-center" role="alert">
            <i class="bi bi-exclamation-circle"></i> Tidak ada soal yang tersedia.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Soal</th>
                        <th>Jawaban</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($soals as $soal)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $soal->soal }}</td>
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($soal->jawabans as $jawaban)
                                        <li>
                                            <i class="bi bi-dot"></i> {{ $jawaban->jawaban }}
                                            @if ($jawaban->is_correct)
                                                <span class="badge bg-success ms-2">Benar</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('guru.editSoal', $soal->id) }}" class="btn btn-warning btn-sm me-2">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('guru.deleteSoal', $soal->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus soal ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
