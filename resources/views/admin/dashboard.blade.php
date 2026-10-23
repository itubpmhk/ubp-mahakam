@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
  <div class="hello">
    <h2>Halo, {{ auth()->user()->name }} 👋</h2>
    <p class="muted">Kelola isi website UBP Mahakam dari sini.</p>
  </div>

  <div class="kpis">
    <a href="{{ route('admin.posts.index', ['status' => 'published']) }}" class="kpi"><span>Berita terbit</span><b>{{ $stats['published'] }}</b></a>
    <a href="{{ route('admin.posts.index', ['status' => 'draft']) }}" class="kpi"><span>Draft berita</span><b>{{ $stats['drafts'] }}</b></a>
    <a href="{{ route('admin.apps.index') }}" class="kpi"><span>Aplikasi aktif</span><b>{{ $stats['apps'] }}</b></a>
    <a href="{{ route('admin.commitments.index') }}" class="kpi"><span>Komitmen tampil</span><b>{{ $stats['commitments'] }}</b></a>
  </div>

  <div class="grid-2">
    <section class="panel">
      <div class="panel-head">
        <h3>Berita terakhir diubah</h3>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-p btn-sm">+ Tulis berita</a>
      </div>
      @forelse ($latestPosts as $p)
        <a href="{{ route('admin.posts.edit', $p) }}" class="row-link">
          <span class="tag {{ $p->isPublished() ? 'tag-ok' : 'tag-muted' }}">{{ $p->isPublished() ? 'Terbit' : ($p->status === 'published' ? 'Terjadwal' : 'Draft') }}</span>
          <span class="grow">{{ $p->title }}</span>
          <small class="muted">{{ $p->updated_at->diffForHumans() }}</small>
        </a>
      @empty
        <p class="muted">Belum ada berita.</p>
      @endforelse
    </section>

    <section class="panel">
      <div class="panel-head"><h3>Pintasan</h3></div>
      <div class="shortcuts">
        <a href="{{ route('admin.settings.edit') }}">Ubah teks landing page</a>
        <a href="{{ route('admin.settings.edit') }}#kontak">Ubah kontak & media sosial</a>
        <a href="{{ route('admin.apps.create') }}">Tambah aplikasi portal</a>
        <a href="{{ route('admin.account.edit') }}">Ganti password</a>
        <a href="{{ route('home') }}" target="_blank">Lihat situs ↗</a>
      </div>
    </section>
  </div>
@endsection
