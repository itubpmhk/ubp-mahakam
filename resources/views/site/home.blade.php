@extends('layouts.site')
@section('world', 'on')

@section('content')
  {{-- HERO --}}
  <section class="hero container reveal">
    <span class="badge fx"><b>{{ $site['hero_badge_region'] }}</b><span class="b-unit">{{ $site['hero_badge_unit'] }}</span>@if ($site['hero_status'])<span class="dot"></span>{{ $site['hero_status'] }}@endif</span>
    <h1 class="split">{{ \App\Support\Text::highlight($site['hero_title']) }}</h1>
    <p class="sub fx">{{ $site['hero_subtitle'] }}</p>
    <div class="cta fx">
      <a href="#tentang" class="btn btn-p">Kenali Kami</a>
      <a href="{{ route('portal') }}" class="btn btn-s">Portal Aplikasi →</a>
    </div>

    @if ($videoId)
      <div class="video fx" id="video" data-id="{{ $videoId }}">
        {{-- maxres doesn't exist for every video: YouTube then sends a small grey placeholder (120px wide) instead of an error --}}
        <img src="https://i.ytimg.com/vi/{{ $videoId }}/maxresdefault.jpg" alt="{{ $site['video_title'] }}"
             onload="if(this.naturalWidth<=120&&!this.dataset.fb){this.dataset.fb=1;this.src='https://i.ytimg.com/vi/{{ $videoId }}/hqdefault.jpg'}"
             onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src='https://i.ytimg.com/vi/{{ $videoId }}/hqdefault.jpg'}">
        <button class="play" type="button" aria-label="Putar video"><svg width="30" height="30" viewBox="0 0 24 24" fill="#0f1b26"><path d="M8 5v14l11-7z"/></svg></button>
        <div class="v-meta"><span>{{ $site['video_label'] }}</span><b>{{ $site['video_title'] }}</b></div>
        <a class="yt-out" href="https://www.youtube.com/watch?v={{ $videoId }}" target="_blank" rel="noopener">Buka di YouTube ↗</a>
      </div>
    @endif
  </section>

  {{-- STRIP --}}
  <div class="strip container reveal">
    <p class="fx">{{ $site['strip_text'] }}</p>
    <div class="chips fx">
      @foreach (\App\Support\Text::list($site['strip_chips']) as $chip)
        <span class="chip">{{ $chip }}</span>
      @endforeach
    </div>
  </div>

  {{-- ABOUT --}}
  <section class="block container" id="tentang">
    <div class="head reveal">
      <span class="eyebrow fx">Tentang Kami</span>
      <h2 class="split">{{ $site['about_heading'] }}</h2>
    </div>
    <div class="about">
      <div class="card lead-card reveal">
        @if ($site['about_p1'])<p class="fx">{{ $site['about_p1'] }}</p>@endif
        @if ($site['about_p2'])<p class="fx">{{ $site['about_p2'] }}</p>@endif
        <div class="fx"><a href="{{ route('about') }}" class="btn btn-s">Lihat selengkapnya →</a></div>
      </div>
      <div class="stats reveal">
        @foreach (['s-blue', 's-yellow', 's-white', 's-soft'] as $i => $cls)
          <div class="stat {{ $cls }} fx"><span class="k">{{ $site['stat'.($i + 1).'_label'] }}</span><span class="v">{{ $site['stat'.($i + 1).'_value'] }}</span></div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- NEWS --}}
  @if ($latestPosts->isNotEmpty())
    <section class="block container" id="berita">
      <div class="head reveal">
        <span class="eyebrow fx">Berita</span>
        <h2 class="split">{{ $site['news_heading'] }}</h2>
      </div>
      <div class="news-grid reveal">
        @foreach ($latestPosts as $post)
          @include('site.partials.news-card', ['post' => $post, 'class' => 'fx'])
        @endforeach
      </div>
      <div class="more reveal"><a href="{{ route('news.index') }}" class="btn btn-s fx">Lihat semua berita →</a></div>
    </section>
  @endif

  {{-- PORTAL TEASER --}}
  @if ($apps->isNotEmpty())
    <section class="block container" id="portal">
      <div class="head reveal">
        <span class="eyebrow fx">Portal Aplikasi</span>
        <h2 class="split">{{ $site['portal_heading'] }}</h2>
        @if ($site['portal_subtitle'])<p class="fx">{{ $site['portal_subtitle'] }}</p>@endif
      </div>
      <div class="apps-grid reveal">
        @foreach ($apps as $i => $item)
          @include('site.partials.app-card', ['item' => $item, 'no' => $i + 1, 'class' => 'fx'])
        @endforeach
      </div>
      <div class="more reveal"><a href="{{ route('portal') }}" class="btn btn-s fx">Buka portal aplikasi →</a></div>
    </section>
  @endif

  {{-- COMMITMENTS --}}
  @if ($commitments->isNotEmpty())
    <section class="block container" id="komitmen">
      <div class="head reveal">
        <span class="eyebrow fx">Komitmen</span>
        <h2 class="split">{{ $site['commit_heading'] }}</h2>
      </div>
      <div class="values">
        @foreach ($commitments as $c)
          <div class="v-card reveal m-{{ $c->icon }} {{ $c->is_featured ? 'feature' : '' }}">
            <div class="ico fx">@include('site.partials.icon', ['name' => $c->icon, 'color' => $c->is_featured ? '#ffd500' : '#0077b6'])</div>
            <h3 class="fx">{{ $c->title }}</h3>
            @if ($c->description)<p class="fx">{{ $c->description }}</p>@endif
          </div>
        @endforeach
      </div>
    </section>
  @endif

  {{-- AKHLAK --}}
  <section class="block container" id="nilai" style="padding-top:0">
    <div class="head reveal">
      <span class="eyebrow fx">Nilai Kami</span>
      <h2 class="split">{{ $site['akhlak_heading'] }}</h2>
      @if ($site['akhlak_subtitle'])<p class="fx">{{ $site['akhlak_subtitle'] }}</p>@endif
    </div>
    <div class="akhlak reveal">
      @foreach ([['A', 'Amanah', 'Memegang teguh kepercayaan.'], ['K', 'Kompeten', 'Terus belajar dan mengembangkan kapabilitas.'], ['H', 'Harmonis', 'Saling peduli dan menghargai perbedaan.'], ['L', 'Loyal', 'Berdedikasi bagi bangsa dan negara.'], ['A', 'Adaptif', 'Terus berinovasi menghadapi perubahan.'], ['K', 'Kolaboratif', 'Membangun kerja sama yang sinergis.']] as [$l, $t, $d])
        <div class="ak fx"><div class="l">{{ $l }}</div><h4>{{ $t }}</h4><p>{{ $d }}</p></div>
      @endforeach
    </div>
  </section>

  {{-- CLOSING --}}
  <section class="container" id="hubungi" style="padding-bottom:40px">
    <div class="closing reveal">
      <h2 class="split">{{ $site['cta_heading'] }}</h2>
      <p class="fx">{{ $site['cta_text'] }}</p>
      <div class="cta fx">
        @if ($site['contact_email'])<a href="mailto:{{ $site['contact_email'] }}" class="btn btn-y">Kirim Email</a>@endif
        <a href="#top" class="btn btn-s">Kembali ke atas</a>
      </div>
    </div>
  </section>
@endsection
