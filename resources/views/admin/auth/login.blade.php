<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Masuk · Admin UBP Mahakam</title>
<link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
<link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
@vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="login-page">
  <form class="login-card" method="post" action="{{ route('login.attempt') }}">
    @csrf
    <img src="{{ asset('images/logo-pln-ip.png') }}" alt="PLN Indonesia Power" class="login-logo">
    <h1>Panel Admin</h1>
    <p class="muted">UBP Mahakam · masuk untuk mengelola konten situs.</p>

    @if ($errors->any())
      <div class="alert err">{{ $errors->first() }}</div>
    @endif

    <div class="field">
      <label for="email">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
    </div>
    <div class="field">
      <label for="password">Password</label>
      <input id="password" type="password" name="password" required autocomplete="current-password">
    </div>
    <label class="check"><input type="checkbox" name="remember" value="1"> Ingat saya</label>
    <button class="btn btn-p btn-block" type="submit">Masuk</button>
    <a href="{{ route('home') }}" class="back-link">← Kembali ke situs</a>
  </form>
</body>
</html>
