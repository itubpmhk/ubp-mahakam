@extends('layouts.admin')
@section('title', $item->exists ? 'Ubah Komitmen' : 'Tambah Komitmen')

@section('content')
  <form method="post" action="{{ $item->exists ? route('admin.commitments.update', $item) : route('admin.commitments.store') }}" class="panel narrow">
    @csrf
    @if ($item->exists) @method('PUT') @endif

    @include('admin.partials.field', ['name' => 'title', 'label' => 'Judul', 'value' => $item->title, 'required' => true, 'max' => 120])
    @include('admin.partials.field', ['name' => 'description', 'label' => 'Deskripsi', 'value' => $item->description, 'type' => 'textarea', 'rows' => 3, 'max' => 600])

    <div class="field">
      <label>Ikon</label>
      <div class="icon-pick">
        @foreach (\App\Models\Commitment::ICONS as $key => $label)
          <label title="{{ $label }}">
            <input type="radio" name="icon" value="{{ $key }}" @checked(old('icon', $item->icon) === $key)>
            <span>@include('site.partials.icon', ['name' => $key, 'size' => 22, 'color' => '#0077b6'])</span>
          </label>
        @endforeach
      </div>
    </div>

    <div class="grid-2">
      @include('admin.partials.field', ['name' => 'sort_order', 'label' => 'Urutan', 'value' => $item->sort_order, 'type' => 'number', 'help' => 'Angka kecil tampil lebih dulu.'])
      <div class="field">
        <label>Opsi</label>
        <label class="check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $item->is_featured))> Kartu sorotan (lebar, biru)</label>
        <label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active))> Tampilkan di situs</label>
      </div>
    </div>

    <div class="savebar">
      <a href="{{ route('admin.commitments.index') }}" class="btn btn-ghost">Batal</a>
      <button class="btn btn-p" type="submit">Simpan</button>
    </div>
  </form>
@endsection
