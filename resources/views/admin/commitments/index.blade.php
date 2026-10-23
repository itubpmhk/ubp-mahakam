@extends('layouts.admin')
@section('title', 'Komitmen')

@section('content')
  <div class="toolbar">
    <p class="muted">Kartu di bagian “Komitmen” pada landing page. Kartu “sorotan” tampil lebar berwarna biru.</p>
    <a href="{{ route('admin.commitments.create') }}" class="btn btn-p">+ Tambah komitmen</a>
  </div>

  <div class="panel no-pad">
    <table class="tbl">
      <thead><tr><th style="width:70px">Urutan</th><th>Judul</th><th>Tampilan</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($items as $c)
          <tr>
            <td>{{ $c->sort_order }}</td>
            <td><div class="t-title">@include('site.partials.icon', ['name' => $c->icon, 'size' => 18, 'color' => '#0077b6']) {{ $c->title }}</div><small class="muted">{{ \Illuminate\Support\Str::limit($c->description, 90) }}</small></td>
            <td>{!! $c->is_featured ? '<span class="tag tag-blue">Sorotan</span>' : '<span class="tag tag-muted">Biasa</span>' !!}</td>
            <td>{!! $c->is_active ? '<span class="tag tag-ok">Tampil</span>' : '<span class="tag tag-muted">Disembunyikan</span>' !!}</td>
            <td class="actions">
              <a href="{{ route('admin.commitments.edit', $c) }}" class="btn btn-ghost btn-sm">Ubah</a>
              <form method="post" action="{{ route('admin.commitments.destroy', $c) }}" data-confirm="Hapus komitmen “{{ $c->title }}”?">
                @csrf @method('DELETE')<button class="btn btn-danger btn-sm" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="muted center">Belum ada komitmen.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
