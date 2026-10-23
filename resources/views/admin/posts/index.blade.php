@extends('layouts.admin')
@section('title', 'Berita')

@section('content')
  <div class="toolbar">
    <form method="get" class="filters-inline">
      <input type="search" name="q" value="{{ $q }}" placeholder="Cari judul…">
      <select name="status" onchange="this.form.submit()">
        <option value="">Semua status</option>
        <option value="published" @selected($status === 'published')>Terbit</option>
        <option value="draft" @selected($status === 'draft')>Draft</option>
      </select>
      <button class="btn btn-ghost" type="submit">Cari</button>
    </form>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-p">+ Tulis berita</a>
  </div>

  <div class="panel no-pad">
    <table class="tbl">
      <thead><tr><th style="width:84px"></th><th>Judul</th><th>Status</th><th>Tanggal terbit</th><th>Dilihat</th><th></th></tr></thead>
      <tbody>
        @forelse ($posts as $p)
          <tr>
            <td>
              @if ($p->coverUrl())<img src="{{ $p->coverUrl() }}" alt="" class="thumb">@else<div class="thumb ph"></div>@endif
            </td>
            <td>
              <a href="{{ route('admin.posts.edit', $p) }}" class="t-title">{{ $p->title }}</a>
              <small class="muted">{{ $p->media_count }} media · diubah {{ $p->updated_at->diffForHumans() }}</small>
            </td>
            <td>
              @if ($p->isPublished())<span class="tag tag-ok">Terbit</span>
              @elseif ($p->status === 'published')<span class="tag tag-blue">Terjadwal</span>
              @else<span class="tag tag-muted">Draft</span>@endif
            </td>
            <td>{{ $p->published_at?->translatedFormat('d M Y, H:i') ?? '—' }}</td>
            <td>{{ number_format($p->views) }}</td>
            <td class="actions">
              <a href="{{ route('news.show', $p) }}" target="_blank" class="btn btn-ghost btn-sm" title="Lihat">↗</a>
              <a href="{{ route('admin.posts.edit', $p) }}" class="btn btn-ghost btn-sm">Ubah</a>
              <form method="post" action="{{ route('admin.posts.destroy', $p) }}" data-confirm="Hapus berita “{{ $p->title }}” beserta semua medianya?">
                @csrf @method('DELETE')<button class="btn btn-danger btn-sm" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="muted center">Belum ada berita.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $posts->links('vendor.pagination.site') }}
@endsection
