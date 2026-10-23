@extends('layouts.site')
@section('title', $post->title)
@section('description', $post->summary(155))
@section('meta')
  <meta property="og:type" content="article">
  <meta property="og:title" content="{{ $post->title }}">
  <meta property="og:description" content="{{ $post->summary(155) }}">
  @if ($post->coverUrl())<meta property="og:image" content="{{ url($post->coverUrl()) }}">@endif
@endsection

@section('content')
  <article class="article container">
    <a href="{{ route('news.index') }}" class="back">← Semua berita</a>

    @unless ($post->isPublished())
      <div class="draft-note">Pratinjau: berita ini belum terbit dan hanya terlihat oleh admin.</div>
    @endunless

    <div class="a-head reveal">
      <time class="fx" datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->translatedFormat('l, d F Y') }}</time>
      <h1 class="split">{{ $post->title }}</h1>
      @if ($post->excerpt)<p class="lead fx">{{ $post->excerpt }}</p>@endif
    </div>

    @if ($post->coverUrl())
      <figure class="cover"><img src="{{ $post->coverUrl() }}" alt="{{ $post->title }}"></figure>
    @endif

    @if ($post->body)
      {{-- body is cleaned by App\Support\HtmlSanitizer when saved --}}
      <div class="prose">{!! $post->body !!}</div>
    @endif

    @php
      $images = $post->media->where('type', 'image');
      $others = $post->media->whereIn('type', ['video', 'youtube']);
      $links = $post->media->where('type', 'link');
    @endphp

    @if ($images->isNotEmpty())
      <section class="gallery {{ $images->count() === 1 ? 'one' : '' }}">
        @foreach ($images as $m)
          <figure>
            <a href="{{ $m->fileUrl() }}" target="_blank" rel="noopener"><img src="{{ $m->fileUrl() }}" alt="{{ $m->caption }}" loading="lazy"></a>
            @if ($m->caption)<figcaption>{{ $m->caption }}</figcaption>@endif
          </figure>
        @endforeach
      </section>
    @endif

    @foreach ($others as $m)
      <figure class="media-block">
        @if ($m->type === 'video')
          <video src="{{ $m->fileUrl() }}" controls preload="metadata" playsinline></video>
        @elseif ($m->youtubeId())
          <div class="yt-embed">
            <iframe src="https://www.youtube.com/embed/{{ $m->youtubeId() }}?rel=0" title="{{ $m->caption ?: 'Video YouTube' }}" loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
          </div>
        @endif
        @if ($m->caption)<figcaption>{{ $m->caption }}</figcaption>@endif
      </figure>
    @endforeach

    @if ($links->isNotEmpty())
      <section class="rel-links">
        <h2>Tautan terkait</h2>
        @foreach ($links as $m)
          <a href="{{ $m->url }}" target="_blank" rel="noopener noreferrer" class="link-card">
            <span class="l-ico"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7-7l-1.7 1.7"/><path d="M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7 7l1.7-1.7"/></svg></span>
            <span><b>{{ $m->caption ?: $m->host() }}</b><small>{{ $m->host() }}</small></span>
            <span class="l-go">↗</span>
          </a>
        @endforeach
      </section>
    @endif
  </article>

  @if ($related->isNotEmpty())
    <section class="block container related">
      <div class="head reveal"><h2 class="split">Berita lainnya</h2></div>
      <div class="news-grid reveal">
        @foreach ($related as $r)
          @include('site.partials.news-card', ['post' => $r, 'class' => 'fx'])
        @endforeach
      </div>
    </section>
  @endif
@endsection
