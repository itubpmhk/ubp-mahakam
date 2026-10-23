@php
    $socials = [
        'instagram' => ['Instagram', '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg>'],
        'facebook' => ['Facebook', '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M14 8h3V4h-3c-2.8 0-4 1.8-4 4.3V10H7v4h3v8h4v-8h3l1-4h-4V8.6c0-.4.3-.6.6-.6z"/></svg>'],
        'youtube' => ['YouTube', '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23 7.2a3 3 0 0 0-2.1-2.1C19 4.6 12 4.6 12 4.6s-7 0-8.9.5A3 3 0 0 0 1 7.2 31 31 0 0 0 .6 12a31 31 0 0 0 .4 4.8 3 3 0 0 0 2.1 2.1c1.9.5 8.9.5 8.9.5s7 0 8.9-.5a3 3 0 0 0 2.1-2.1 31 31 0 0 0 .4-4.8 31 31 0 0 0-.4-4.8zM9.8 15.1V8.9l5.4 3.1z"/></svg>'],
        'linkedin' => ['LinkedIn', '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9.5h4V21H3zM9.5 9.5h3.8v1.6h.1c.5-1 1.8-2 3.8-2 4 0 4.8 2.6 4.8 6V21h-4v-5.1c0-1.2 0-2.8-1.7-2.8s-2 1.3-2 2.7V21h-4z"/></svg>'],
        'x' => ['X', '<svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><path d="M17.8 3h3.3l-7.2 8.2L22.4 21h-6.6l-5.2-6.8L4.7 21H1.4l7.7-8.8L1 3h6.8l4.7 6.2zm-1.2 16h1.8L6.6 4.9H4.7z"/></svg>'],
    ];
    $withWorld = trim($__env->yieldContent('world')) === 'on';
    $home = route('home');
@endphp
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ ($pageTitle = trim($__env->yieldContent('title'))) ? $pageTitle.' · ' : '' }}UBP Mahakam · PLN Indonesia Power</title>
<meta name="description" content="@yield('description', 'UBP Mahakam, unit bisnis pembangkitan PLN Indonesia Power yang menjaga pasokan listrik Sistem Mahakam, Kalimantan Timur.')">
<meta name="theme-color" content="#0077b6">
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
<link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
@yield('meta')
@vite(['resources/css/site.css', 'resources/js/site.js'])
</head>
<body class="{{ $withWorld ? 'has-world' : 'no-world' }}">
@if ($withWorld)
    <canvas id="scene" aria-hidden="true"></canvas>
    <div class="veil" aria-hidden="true"></div>
@endif

<header>
  <div class="nav">
    <a href="{{ $home }}" class="brand">
      <img src="{{ asset('images/logo-pln-ip.png') }}" alt="PLN Indonesia Power" class="logo">
      <span class="unit">UBP Mahakam</span>
    </a>
    <nav class="links">
      <a href="{{ route('about') }}" @class(['on' => request()->routeIs('about')])>Tentang</a>
      <a href="{{ route('news.index') }}" @class(['on' => request()->routeIs('news.*')])>Berita</a>
      <a href="{{ route('portal') }}" @class(['on' => request()->routeIs('portal')])>Portal Aplikasi</a>
      <a href="{{ $home }}#komitmen">Komitmen</a>
    </nav>
    <a href="#kontak" class="btn btn-p">Hubungi Kami</a>
  </div>
</header>

<main id="top">
  @yield('content')
</main>

<footer id="kontak">
  <div class="container">
    <div class="foot-grid">
      <div class="f-about">
        <img src="{{ asset('images/logo-pln-ip.png') }}" alt="PLN Indonesia Power" class="f-logo">
        <p><b>UBP Mahakam</b><br>{{ $site['footer_about'] }}</p>
        <div class="socials">
          @foreach ($socials as $key => [$label, $svg])
            @if ($url = \App\Support\Text::safeUrl($site['social_'.$key] ?? ''))
              <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ $label }}">{!! $svg !!}</a>
            @endif
          @endforeach
        </div>
      </div>
      <div>
        <h5>Kontak</h5>
        <ul class="f-list">
          @if ($site['contact_address'])
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s7-6.2 7-12a7 7 0 1 0-14 0c0 5.8 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/></svg><span>{!! nl2br(e($site['contact_address'])) !!}</span></li>
          @endif
          @if ($site['contact_phone'])
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg><a href="tel:{{ preg_replace('/[^0-9+]/', '', $site['contact_phone']) }}">{{ $site['contact_phone'] }}</a></li>
          @endif
          @if ($site['contact_email'])
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 6 10 7 10-7"/></svg><a href="mailto:{{ $site['contact_email'] }}">{{ $site['contact_email'] }}</a></li>
          @endif
          @if ($site['contact_hours'])
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg><span>{{ $site['contact_hours'] }}</span></li>
          @endif
        </ul>
      </div>
      <div>
        <h5>Jelajahi</h5>
        <ul class="f-links">
          <li><a href="{{ route('about') }}">Tentang Kami</a></li>
          <li><a href="{{ route('news.index') }}">Berita</a></li>
          <li><a href="{{ route('portal') }}">Portal Aplikasi</a></li>
          <li><a href="{{ $home }}#komitmen">Komitmen</a></li>
        </ul>
      </div>
      <div>
        <h5>Tautan Terkait</h5>
        <ul class="f-links">
          <li><a href="https://www.plnindonesiapower.co.id" target="_blank" rel="noopener">PLN Indonesia Power</a></li>
          <li><a href="https://web.pln.co.id" target="_blank" rel="noopener">PT PLN (Persero)</a></li>
          @if ($url = \App\Support\Text::safeUrl($site['link_whistleblowing']))
            <li><a href="{{ $url }}" target="_blank" rel="noopener">Pengaduan &amp; Whistleblowing</a></li>
          @endif
          @if ($url = \App\Support\Text::safeUrl($site['link_career']))
            <li><a href="{{ $url }}" target="_blank" rel="noopener">Karier &amp; Magang</a></li>
          @endif
        </ul>
      </div>
    </div>
    <div class="foot-bottom">
      <span>© {{ date('Y') }} UBP Mahakam. Hak cipta dilindungi.</span>
    </div>
  </div>
</footer>
</body>
</html>
