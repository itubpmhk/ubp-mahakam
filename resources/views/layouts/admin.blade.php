<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Admin') · UBP Mahakam</title>
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
<link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
@vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="adm">
@php
  $menu = [
    ['admin.dashboard', 'admin.dashboard', 'Dashboard', '<path d="M3 13h8V3H3zM13 21h8V11h-8zM3 21h8v-6H3zM13 3v6h8V3z"/>'],
    ['admin.settings.edit', 'admin.settings.*', 'Konten Landing', '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 14h8"/>'],
    ['admin.commitments.index', 'admin.commitments.*', 'Komitmen', '<path d="M12 2 4 6v6c0 5 3.5 8.5 8 10 4.5-1.5 8-5 8-10V6z"/>'],
    ['admin.posts.index', 'admin.posts.*', 'Berita', '<path d="M4 4h13v16H6a2 2 0 0 1-2-2zM17 8h3v10a2 2 0 0 1-2 2"/><path d="M8 8h5M8 12h5M8 16h3"/>'],
    ['admin.apps.index', 'admin.apps.*', 'Portal Aplikasi', '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>'],
    ['admin.account.edit', 'admin.account.*', 'Akun & Admin', '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/>'],
  ];
@endphp
<aside class="side" id="side">
  <a href="{{ route('admin.dashboard') }}" class="side-brand">
    <img src="{{ asset('images/logo-pln-ip.png') }}" alt="PLN Indonesia Power">
    <span>UBP Mahakam<small>Panel Admin</small></span>
  </a>
  <nav>
    @foreach ($menu as [$route, $pattern, $label, $icon])
      <a href="{{ route($route) }}" @class(['on' => request()->routeIs($pattern)])>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $icon !!}</svg>{{ $label }}
      </a>
    @endforeach
  </nav>
  <a href="{{ route('home') }}" target="_blank" class="side-site">Lihat situs ↗</a>
</aside>

<div class="main">
  <header class="top">
    <button class="menu-btn" type="button" data-toggle-side aria-label="Menu">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
    <h1>@yield('title', 'Admin')</h1>
    <div class="top-right">
      <span class="who">{{ auth()->user()->name }}</span>
      <form method="post" action="{{ route('admin.logout') }}">@csrf<button class="btn btn-ghost btn-sm" type="submit">Keluar</button></form>
    </div>
  </header>

  <div class="content">
    @include('admin.partials.flash')
    @yield('content')
  </div>
</div>
</body>
</html>
