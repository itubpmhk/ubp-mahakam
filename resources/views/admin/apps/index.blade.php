@extends('layouts.admin')
@section('title', 'Portal Aplikasi')

@section('content')
  <div class="toolbar">
    <form method="get" class="filters-inline">
      <input type="search" name="q" value="{{ $q }}" placeholder="Cari nama / kategori…">
      <button class="btn btn-ghost" type="submit">Cari</button>
    </form>
    <div class="row-gap">
      <a href="{{ route('portal') }}" target="_blank" class="btn btn-ghost">Lihat portal ↗</a>
      <a href="{{ route('admin.apps.create') }}" class="btn btn-p">+ Tambah aplikasi</a>
    </div>
  </div>

  <div class="panel no-pad">
    <table class="tbl">
      <thead><tr><th style="width:70px">Urutan</th><th style="width:110px"></th><th>Aplikasi</th><th>Kategori</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($apps as $a)
          <tr>
            <td>{{ $a->sort_order }}</td>
            <td>@if ($a->thumbnailUrl())<img src="{{ $a->thumbnailUrl() }}" alt="" class="thumb wide">@else<div class="thumb wide ph"></div>@endif</td>
            <td>
              <a href="{{ route('admin.apps.edit', $a) }}" class="t-title">{{ $a->name }}</a>
              <small class="muted ellipsis">{{ $a->url }}</small>
            </td>
            <td><span class="tag tag-blue">{{ $a->category }}</span></td>
            <td>{!! $a->is_active ? '<span class="tag tag-ok">Tampil</span>' : '<span class="tag tag-muted">Disembunyikan</span>' !!}</td>
            <td class="actions">
              <a href="{{ route('admin.apps.edit', $a) }}" class="btn btn-ghost btn-sm">Ubah</a>
              <form method="post" action="{{ route('admin.apps.destroy', $a) }}" data-confirm="Hapus aplikasi “{{ $a->name }}”?">
                @csrf @method('DELETE')<button class="btn btn-danger btn-sm" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="muted center">Belum ada aplikasi.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
