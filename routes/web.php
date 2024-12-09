<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ArticleController;
use App\Models\Article;
use App\Http\Controllers\FormDataController;
use App\Http\Controllers\SoalController;
use App\Http\Middleware\RoleMiddleware;




// HOME================================================================================================
Route::get('/', function () {
    return view('home');
});


// AboutUS==============================================================================================================
Route::get('/tentang-kami', function () {
    return view('tentang-kami');
})->name('tentang-kami');



// login================================================================================================
// Menampilkan form login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');

// Proses login
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Proses logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register//==============================================================================================
// Form Register
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Proses Register
Route::post('register', [RegisterController::class, 'register']);





//Articles================================================================================================
Route::prefix('articles')->group(function () {
    // Menampilkan daftar artikel
    Route::get('/', [ArticleController::class, 'index'])->name('articles.index');

    // Menampilkan form untuk menambah artikel baru
    Route::get('create', [ArticleController::class, 'create'])->name('articles.create');

    // Menyimpan artikel baru
    Route::post('/', [ArticleController::class, 'store'])->name('articles.store');

    // Menampilkan form untuk mengedit artikel
    Route::get('{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');

    // Memperbarui artikel
    Route::put('{article}', [ArticleController::class, 'update'])->name('articles.update');

    // Menghapus artikel
    Route::delete('{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    Route::get('articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

});

// article==============================================================================================================
Route::get('/daftararticles', function() {
    $articles = Article::latest()->paginate(10); // Menampilkan artikel terbaru dengan pagination
    return view('daftararticles', compact('articles'));
})->name('articles.index');

Route::get('/daftararticles/{id}', function($id) {
    $article = Article::findOrFail($id); // Menampilkan artikel berdasarkan ID
    return view('articles.show', compact('article'));
})->name('articles.show');



// formdatadiri======================================================================================================================
Route::get('/form-data-diri', function () {
    return view('Question.formdatadiri');
});

Route::post('/save-user', [FormDataController::class, 'saveUserData'])->name('saveUserData');

// Rute untuk Guru
Route::middleware([RoleMiddleware::class.':guru'])->group(function () {
    Route::get('/dashboard', [SoalController::class, 'index'])->name('guru.dashboard');

    // CRUD untuk soal
    Route::get('/soal/create', [SoalController::class, 'create'])->name('guru.createSoal');
    Route::post('/soal/store', [SoalController::class, 'store'])->name('guru.storeSoal');
    Route::get('/soal/{id}/edit', [SoalController::class, 'edit'])->name('guru.editSoal');
    Route::put('/soal/{id}', [SoalController::class, 'update'])->name('guru.updateSoal');
    Route::delete('/soal/{id}', [SoalController::class, 'destroy'])->name('guru.deleteSoal');

    // Menampilkan detail soal
    Route::get('/soal/{id}', [SoalController::class, 'show'])->name('guru.showSoal');
});

// Rute untuk Siswa
Route::middleware(['auth'])->group(function () {
    Route::get('/soals', [SoalController::class, 'indexPublic'])->name('soals.indexPublic'); // Menampilkan soal secara umum
    Route::get('/soal/{id}', [SoalController::class, 'showPublic'])->name('soals.showPublic'); // Detail soal untuk siswa
    Route::post('/siswa/jawaban/{id}', [SoalController::class, 'submitJawaban'])->name('siswa.submitJawaban'); // Jawaban siswa
});
