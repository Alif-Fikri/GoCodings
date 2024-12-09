@extends('layouts.apparticles')

@section('title', 'Daftar Artikel')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="display-4 text-center mb-4">Daftar Artikel</h1>

                <!-- Daftar Artikel -->
                @foreach($articles as $article)
                    <div class="article-preview mb-4">
                        <h2>
                            <a href="{{ route('articles.show', $article->id) }}" class="text-decoration-none text-dark">
                                {{ $article->title }}
                            </a>
                        </h2>
                        <p class="text-muted">Dipublikasikan pada {{ $article->created_at->format('d M Y') }}</p>
                        <p>{{ Str::limit($article->content, 150) }} <a href="{{ route('articles.show', $article->id) }}">Baca selengkapnya</a></p>
                    </div>
                    <hr>
                @endforeach

                <!-- Jika tidak ada artikel -->
                @if($articles->isEmpty())
                    <p class="text-center">Tidak ada artikel untuk ditampilkan.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
