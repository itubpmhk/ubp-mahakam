@extends('layouts.site')
@section('title', 'Berita')

@section('content')
  <section class="page-head container reveal">
    <span class="eyebrow fx">Berita</span>
    <h1 class="split">{{ $site['news_heading'] }}</h1>
    <form class="search fx" method="get" action="{{ route('news.index') }}" role="search">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      <input type="search" name="q" value="{{ $q }}" placeholder="Cari berita…" aria-label="Cari berita">
      @if ($q !== '')<a href="{{ route('news.index') }}" class="clear">Reset</a>@endif
    </form>
  </section>

  <section class="container page-body">
    @if ($posts->isEmpty())
      <div class="empty">
        @if ($q !== '')
          Tidak ada berita yang cocok dengan “{{ $q }}”.
        @else
          Belum ada berita.
        @endif
      </div>
    @else
      <div class="news-grid reveal">
        @foreach ($posts as $post)
          @include('site.partials.news-card', ['post' => $post, 'class' => 'fx'])
        @endforeach
      </div>
      {{ $posts->links('vendor.pagination.site') }}
    @endif
  </section>
@endsection
