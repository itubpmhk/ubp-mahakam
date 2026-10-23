@extends('layouts.admin')
@section('title', $item->exists ? 'Ubah Aplikasi' : 'Tambah Aplikasi')

@section('content')
  <form method="post" enctype="multipart/form-data"
        action="{{ $item->exists ? route('admin.apps.update', $item) : route('admin.apps.store') }}" class="grid-form">
    @csrf
    @if ($item->exists) @method('PUT') @endif

    <section class="panel">
      @include('admin.partials.field', ['name' => 'name', 'label' => 'Nama aplikasi', 'value' => $item->name, 'required' => true, 'max' => 120])
      <div class="field">
        <label for="f_category">Kategori <i>*</i></label>
        <input id="f_category" type="text" name="category" value="{{ old('category', $item->category) }}" list="cat-list" required maxlength="60">
        <datalist id="cat-list">@foreach ($categories as $c)<option value="{{ $c }}">@endforeach</datalist>
        <small>Pilih yang sudah ada atau ketik kategori baru. Kategori jadi tombol filter di halaman portal.</small>
      </div>
      @include('admin.partials.field', ['name' => 'description', 'label' => 'Deskripsi singkat', 'value' => $item->description, 'type' => 'textarea', 'rows' => 3, 'max' => 500])
      @include('admin.partials.field', ['name' => 'url', 'label' => 'Alamat aplikasi (URL)', 'value' => $item->url, 'required' => true, 'placeholder' => 'https://…', 'help' => 'Alamat lengkap, atau diawali / untuk alamat di server yang sama.'])
      <div class="grid-2">
        @include('admin.partials.field', ['name' => 'sort_order', 'label' => 'Urutan', 'value' => $item->sort_order, 'type' => 'number', 'help' => 'Menentukan nomor 01, 02, … di portal.'])
        <div class="field">
          <label>Opsi</label>
          <label class="check"><input type="checkbox" name="open_new_tab" value="1" @checked(old('open_new_tab', $item->open_new_tab))> Buka di tab baru</label>
          <label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active))> Tampilkan di portal</label>
        </div>
      </div>
    </section>

    <section class="panel">
      <div class="panel-head"><h3>Thumbnail</h3></div>
      <div class="cover-prev wide" data-preview="thumb">
        @if ($item->thumbnailUrl())<img src="{{ $item->thumbnailUrl() }}" alt="">@else<span class="muted">Belum ada gambar</span>@endif
      </div>
      <input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp" data-preview-input="thumb">
      <small class="muted">Screenshot halaman aplikasi. JPG/PNG/WEBP maks. 4 MB, ideal 1280×560 piksel.</small>
      @if ($item->thumbnailUrl())
        <label class="check danger"><input type="checkbox" name="remove_thumbnail" value="1"> Hapus thumbnail</label>
      @endif

      <div class="savebar">
        <a href="{{ route('admin.apps.index') }}" class="btn btn-ghost">Batal</a>
        <button class="btn btn-p" type="submit">Simpan</button>
      </div>
    </section>
  </form>
@endsection
