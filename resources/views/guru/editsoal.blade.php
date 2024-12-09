@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Soal</h1>
    <form action="{{ route('guru.updateSoal', $soal->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="soal">Soal</label>
            <textarea id="soal" name="soal" class="form-control" required>{{ $soal->soal }}</textarea>
        </div>
        <div id="jawaban-container" class="mt-3">
            <label>Jawaban</label>
            @foreach ($soal->jawabans as $index => $jawaban)
                <div class="jawaban-item mb-2">
                    <input type="hidden" name="jawaban[{{ $index }}][id]" value="{{ $jawaban->id }}">
                    <input type="text" name="jawaban[{{ $index }}][text]" class="form-control mb-1" value="{{ $jawaban->jawaban }}" required>
                    <label>
                        <input type="radio" name="jawaban[{{ $index }}][is_correct]" value="1" {{ $jawaban->is_correct ? 'checked' : '' }}> Benar
                    </label>
                    <label>
                        <input type="radio" name="jawaban[{{ $index }}][is_correct]" value="0" {{ !$jawaban->is_correct ? 'checked' : '' }}> Salah
                    </label>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-secondary" onclick="addJawaban()">Tambah Jawaban</button>
        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
    </form>
</div>

<script>
    let jawabanIndex = {{ $soal->jawabans->count() }};

    function addJawaban() {
        const container = document.getElementById('jawaban-container');
        const jawabanItem = document.createElement('div');
        jawabanItem.classList.add('jawaban-item', 'mb-2');
        jawabanItem.innerHTML = `
            <input type="text" name="jawaban[${jawabanIndex}][text]" class="form-control mb-1" placeholder="Jawaban" required>
            <label>
                <input type="radio" name="jawaban[${jawabanIndex}][is_correct]" value="1"> Benar
            </label>
            <label>
                <input type="radio" name="jawaban[${jawabanIndex}][is_correct]" value="0" checked> Salah
            </label>
        `;
        container.appendChild(jawabanItem);
        jawabanIndex++;
    }
</script>
@endsection
