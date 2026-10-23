@extends('layouts.site')
@section('title', 'Portal Aplikasi')

@section('content')
  <section class="page-head container reveal">
    <span class="eyebrow fx">Portal Aplikasi</span>
    <h1 class="split">{{ $site['portal_heading'] }}</h1>
    @if ($site['portal_subtitle'])<p class="fx">{{ $site['portal_subtitle'] }}</p>@endif
  </section>

  <section class="container page-body" id="portal-app">
    <div class="portal-bar">
      <label class="search">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        <input type="search" id="portal-q" placeholder="Cari aplikasi atau layanan…" aria-label="Cari aplikasi">
      </label>
      <div class="filters" role="tablist" aria-label="Kategori">
        <button type="button" class="filter on" data-cat="">Semua</button>
        @foreach ($categories as $cat)
          <button type="button" class="filter" data-cat="{{ $cat }}">{{ $cat }}</button>
        @endforeach
      </div>
    </div>

    @if ($apps->isEmpty())
      <div class="empty">Belum ada aplikasi.</div>
    @else
      <div class="apps-grid" id="portal-grid">
        @foreach ($apps as $i => $item)
          @include('site.partials.app-card', ['item' => $item, 'no' => $i + 1])
        @endforeach
      </div>
      <div class="empty" id="portal-empty" hidden>Tidak ada aplikasi yang cocok.</div>
    @endif
  </section>
@endsection
