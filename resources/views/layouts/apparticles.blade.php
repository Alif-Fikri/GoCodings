<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Link Bootstrap untuk gaya umum -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link PrismJS untuk Syntax Highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    @yield('styles') <!-- Untuk CSS khusus artikel -->
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
                    <li class="nav-item"><a class="nav-link" href="#">Soal</a></li>
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
    <div class="container">
        @yield('content')
    </div>

    <!-- Script PrismJS untuk Syntax Highlighting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/plugins/autoloader/prism-autoloader.min.js"></script>

    <!-- Script untuk Animasi dan Interaktivitas -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Menambahkan kelas .visible untuk efek fade-in pada elemen dengan kelas .fade-in
            var fadeInElements = document.querySelectorAll('.fade-in');
            fadeInElements.forEach(function(element) {
                element.classList.add('visible');
            });
        });
    </script>
</body>
</html>
