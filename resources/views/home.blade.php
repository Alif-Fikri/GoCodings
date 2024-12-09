<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOcoding - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">GOcoding</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/daftararticles') }}">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/form-data-diri') }}">Soal</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/tentang-kami') }}">Tentang Kami</a></li>

                    <!-- Check if user is logged in -->
                    @if (Auth::check())
                        <!-- Show logout if logged in -->
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-logout nav-link" style="color: inherit;">Logout</button>
                            </form>
                        </li>
                    @else
                        <!-- Show login if not logged in -->
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>


    <div class="container mt-5">
        <h1 class="text-center">Selamat Datang di GOcoding!</h1>
        <p class="text-center">Website seru untuk belajar coding dengan mudah dan menyenangkan.</p>
        <div class="d-flex justify-content-center">
            <a href="#" class="btn btn-primary mx-2">Mulai Belajar</a>
            <a href="{{ url('/tentang-kami') }}" class="btn btn-outline-primary mx-2">Tentang GOcoding</a>
        </div>
    </div>



    <section class="Gambar-coding text-center">
        <div class="overlay">
            <h2 class="text-white">Belajar Coding Itu Menyenangkan!</h2>
        </div>
        <img src="{{ asset('images/Open source-cuate.png') }}" alt="Gambar Coding" class="img-fluid w-100">
    </section>

    <section class="Penjelasan-potensi-code-di-indonesia">
        <div class="container text-center py-5">
            <h2 class="mb-4">Potensi Coding di Indonesia</h2>
            <p class="mb-4">
                Indonesia memiliki potensi besar dalam dunia teknologi dan pengembangan software.
                Dengan semakin meningkatnya akses internet, banyak anak muda yang mulai tertarik belajar coding untuk menciptakan solusi digital inovatif.
                Melalui GOcoding, kami ingin mendukung generasi muda Indonesia dalam belajar coding sejak dini.
            </p>
            <p>
                Mari bersama-sama membangun masa depan teknologi Indonesia yang cerah dengan menjadi bagian dari revolusi digital ini!
            </p>
        </div>
    </section>




</body>
</html>
