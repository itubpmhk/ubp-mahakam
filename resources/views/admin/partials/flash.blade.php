@if (session('success'))
  <div class="alert ok" data-autohide>{{ session('success') }}</div>
@endif
@if ($errors->any())
  <div class="alert err">
    <b>Periksa kembali isian berikut:</b>
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
