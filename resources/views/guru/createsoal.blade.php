@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary">Buat Soal Baru</h1>
        <a href="{{ route('guru.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <form action="{{ route('guru.storeSoal') }}" method="POST" class="p-4 shadow-sm rounded bg-light">
        @csrf
        <div class="mb-4">
            <label for="soal" class="form-label fw-bold">Soal</label>
            <textarea id="soal" name="soal" class="form-control" rows="4" placeholder="Masukkan soal..." required></textarea>
        </div>

        <div id="jawaban-container" class="mb-4">
            <label class="form-label fw-bold">Jawaban</label>
            <div class="jawaban-item input-group mb-3">
                <input type="text" name="jawaban[0][text]" class="form-control" placeholder="Masukkan jawaban..." required>
                <div class="input-group-text">
                    <label class="form-check-label">
                        <input type="radio" name="jawaban[0][is_correct]" value="1" class="form-check-input me-1"> Benar
                    </label>
                </div>
                <div class="input-group-text">
                    <label class="form-check-label">
                        <input type="radio" name="jawaban[0][is_correct]" value="0" class="form-check-input me-1" checked> Salah
                    </label>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary mb-3" onclick="addJawaban()">
            <i class="bi bi-plus-circle"></i> Tambah Jawaban
        </button>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
        </div>
    </form>
</div>

<script>
    let jawabanIndex = 1;

    function addJawaban() {
        const container = document.getElementById('jawaban-container');
        const jawabanItem = document.createElement('div');
        jawabanItem.classList.add('jawaban-item', 'input-group', 'mb-3');
        jawabanItem.innerHTML = `
            <input type="text" name="jawaban[${jawabanIndex}][text]" class="form-control" placeholder="Masukkan jawaban..." required>
            <div class="input-group-text">
                <label class="form-check-label">
                    <input type="radio" name="jawaban[${jawabanIndex}][is_correct]" value="1" class="form-check-input me-1"> Benar
                </label>
            </div>
            <div class="input-group-text">
                <label class="form-check-label">
                    <input type="radio" name="jawaban[${jawabanIndex}][is_correct]" value="0" class="form-check-input me-1" checked> Salah
                </label>
            </div>
        `;
        container.appendChild(jawabanItem);
        jawabanIndex++;
    }
</script>
@endsection
