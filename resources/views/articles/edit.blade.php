@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Artikel</h1>

    <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" id="articleForm">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Judul Artikel</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $article->title) }}" required>
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="content">Konten Artikel</label>
            <!-- Tombol untuk Sisipkan Kode dan Gambar -->
            <div class="mb-2">
                <button type="button" class="btn btn-primary btn-sm" onclick="insertCode()">Sisipkan Kode</button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="insertImage()">Sisipkan Gambar URL</button>
            </div>
            <!-- Textarea untuk konten artikel -->
            <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content', $article->content) }}</textarea>
            @error('content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>



        <!-- Form untuk menulis kode -->
        <div class="form-group">
            <label for="code_1">Script Kode 1 (opsional)</label>
            <textarea name="code_1" id="code_1" class="form-control" rows="10">{{ old('code_1', $article->code_1) }}</textarea>
            @error('code_1')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="code_2">Script Kode 2 (opsional)</label>
            <textarea name="code_2" id="code_2" class="form-control" rows="10">{{ old('code_2', $article->code_2) }}</textarea>
            @error('code_2')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="code_3">Script Kode 3 (opsional)</label>
            <textarea name="code_3" id="code_3" class="form-control" rows="10">{{ old('code_3', $article->code_3) }}</textarea>
            @error('code_3')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="code_4">Script Kode 4 (opsional)</label>
            <textarea name="code_4" id="code_4" class="form-control" rows="10">{{ old('code_4', $article->code_4) }}</textarea>
            @error('code_4')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="code_5">Script Kode 5 (opsional)</label>
            <textarea name="code_5" id="code_5" class="form-control" rows="10">{{ old('code_5', $article->code_5) }}</textarea>
            @error('code_5')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">Gambar (opsional)</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
            @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        @if($article->image)
            <div class="form-group">
                <img src="{{ asset('images/' . $article->image) }}" alt="{{ $article->title }}" width="100">
            </div>
        @endif

        <button type="submit" class="btn btn-warning mt-3">Perbarui Artikel</button>
    </form>
</div>

@endsection

@section('styles')
    <!-- Menambahkan styling untuk CodeMirror -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/theme/dracula.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <!-- Menambahkan script untuk CodeMirror -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/python/python.min.js"></script>

    <script>
        // Inisialisasi CodeMirror pada textarea dengan ID 'code_1', 'code_2', dll.
        var codeMirror1 = CodeMirror.fromTextArea(document.getElementById("code_1"), {
            mode: "php", // Anda bisa mengganti mode ini dengan 'javascript', 'python', dll.
            theme: "dracula",
            lineNumbers: true,
            lineWrapping: true
        });

        var codeMirror2 = CodeMirror.fromTextArea(document.getElementById("code_2"), {
            mode: "javascript",
            theme: "dracula",
            lineNumbers: true,
            lineWrapping: true
        });

        var codeMirror3 = CodeMirror.fromTextArea(document.getElementById("code_3"), {
            mode: "python",
            theme: "dracula",
            lineNumbers: true,
            lineWrapping: true
        });

        var codeMirror4 = CodeMirror.fromTextArea(document.getElementById("code_4"), {
            mode: "java",
            theme: "dracula",
            lineNumbers: true,
            lineWrapping: true
        });

        var codeMirror5 = CodeMirror.fromTextArea(document.getElementById("code_5"), {
            mode: "ruby",
            theme: "dracula",
            lineNumbers: true,
            lineWrapping: true
        });

        // Sebelum formulir disubmit, pastikan nilai textarea di-update dengan isi dari CodeMirror
        document.getElementById("articleForm").onsubmit = function() {
            // Update nilai textarea dengan nilai dari CodeMirror
            document.getElementById("code_1").value = codeMirror1.getValue();
            document.getElementById("code_2").value = codeMirror2.getValue();
            document.getElementById("code_3").value = codeMirror3.getValue();
            document.getElementById("code_4").value = codeMirror4.getValue();
            document.getElementById("code_5").value = codeMirror5.getValue();
        };
    </script>

@push('scripts')
<script>
    // Fungsi untuk menyisipkan template kode ke dalam textarea
    function insertCode() {
        const textarea = document.getElementById("content");
        if (!textarea) return;

        const codeTemplate = `<pre><code>// Tulis kode Anda di sini</code></pre>`;
        insertAtCursor(textarea, codeTemplate);
    }

    // Fungsi untuk menyisipkan gambar URL ke dalam textarea
    function insertImage() {
        const url = prompt("Masukkan URL gambar:");
        if (url) {
            const textarea = document.getElementById("content");
            if (!textarea) return;

            const imageTemplate = `<img src="${url}" alt="Deskripsi gambar">`;
            insertAtCursor(textarea, imageTemplate);
        }
    }

    // Fungsi untuk menyisipkan teks di posisi kursor dalam textarea
    function insertAtCursor(textarea, text) {
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const before = textarea.value.substring(0, start);
        const after = textarea.value.substring(end, textarea.value.length);

        textarea.value = before + text + after;

        // Mengembalikan fokus ke textarea
        textarea.focus();
        textarea.selectionStart = textarea.selectionEnd = start + text.length;
    }
</script>
@endpush


@endsection
