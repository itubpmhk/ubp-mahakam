@extends('layouts.admin')
@section('title', $post->exists ? 'Ubah Berita' : 'Tulis Berita')

@section('content')
  <form method="post" enctype="multipart/form-data"
        action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}" class="post-form">
    @csrf
    @if ($post->exists) @method('PUT') @endif

    <div class="post-main">
      <section class="panel">
        @include('admin.partials.field', ['name' => 'title', 'label' => 'Judul berita', 'value' => $post->title, 'required' => true, 'max' => 200, 'class' => 'big'])
        @if ($post->exists)
          <p class="muted small">Alamat: <a href="{{ route('news.show', $post) }}" target="_blank">{{ route('news.show', $post) }}</a></p>
        @endif
        @include('admin.partials.field', ['name' => 'excerpt', 'label' => 'Ringkasan', 'value' => $post->excerpt, 'type' => 'textarea', 'rows' => 2, 'max' => 400, 'help' => 'Tampil di kartu berita. Kosongkan untuk mengambil awal isi berita.'])

        <div class="field">
          <label for="body">Isi berita</label>
          <input id="body" type="hidden" name="body" value="{{ old('body', $post->body) }}">
          <trix-editor input="body" class="trix" data-upload-url="{{ route('admin.posts.upload') }}"></trix-editor>
          <small>Sisipkan gambar di tengah teks: klik ikon klip 📎, atau seret / tempel gambar ke posisi yang diinginkan (JPG/PNG/WEBP/GIF, maks. 5 MB). Klik gambar untuk menambah keterangan. Video & link tambahkan di bagian “Media”.</small>
        </div>
      </section>

      <section class="panel">
        <div class="panel-head"><h3>Media (gambar, video, YouTube, link)</h3></div>

        @if ($post->exists && $post->media->isNotEmpty())
          <div class="media-list">
            @foreach ($post->media as $m)
              <div class="media-row">
                <div class="m-prev">
                  @if ($m->type === 'image')
                    <img src="{{ $m->fileUrl() }}" alt="">
                  @elseif ($m->type === 'video')
                    <video src="{{ $m->fileUrl() }}" preload="metadata" muted></video>
                  @elseif ($m->type === 'youtube')
                    <img src="{{ \App\Support\Youtube::thumbnail($m->youtubeId()) }}" alt="">
                  @else
                    <span class="m-link">🔗</span>
                  @endif
                </div>
                <div class="m-info">
                  <span class="tag tag-muted">{{ \App\Models\PostMedia::TYPES[$m->type] ?? $m->type }}</span>
                  @if ($m->url)<small class="muted ellipsis">{{ $m->url }}</small>@endif
                  <input type="text" name="media[{{ $m->id }}][caption]" value="{{ old("media.{$m->id}.caption", $m->caption) }}" placeholder="Keterangan / judul (opsional)">
                </div>
                <div class="m-side">
                  <label class="mini">Urutan<input type="number" name="media[{{ $m->id }}][sort_order]" value="{{ $m->sort_order }}" min="0"></label>
                  <label class="check danger"><input type="checkbox" name="media[{{ $m->id }}][delete]" value="1"> Hapus</label>
                </div>
              </div>
            @endforeach
          </div>
        @endif

        <div id="new-media" class="new-media" data-next="0"></div>
        <button type="button" class="btn btn-ghost" data-add-media>+ Tambah media</button>
        <p class="muted small">Gambar: JPG/PNG/WEBP/GIF. Video: MP4/WEBM/MOV maks. 100 MB. Untuk video besar lebih baik unggah ke YouTube lalu tempel link-nya.</p>

        <template id="media-template">
          <div class="media-row new">
            <select name="new_media[__i__][type]" data-media-type>
              @foreach (\App\Models\PostMedia::TYPES as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
              @endforeach
            </select>
            <div class="m-info">
              <input type="file" name="new_media[__i__][file]" accept="image/*" data-media-file>
              <input type="url" name="new_media[__i__][url]" placeholder="https://…" data-media-url hidden>
              <input type="text" name="new_media[__i__][caption]" placeholder="Keterangan / judul (opsional)">
            </div>
            <button type="button" class="btn btn-ghost btn-sm" data-remove-row>✕</button>
          </div>
        </template>
      </section>
    </div>

    <aside class="post-side">
      <section class="panel">
        <div class="panel-head"><h3>Publikasi</h3></div>
        <div class="field">
          <label for="status">Status</label>
          <select id="status" name="status">
            <option value="draft" @selected(old('status', $post->status) === 'draft')>Draft (belum tampil)</option>
            <option value="published" @selected(old('status', $post->status) === 'published')>Terbit</option>
          </select>
        </div>
        <div class="field">
          <label for="published_at">Tanggal terbit</label>
          <input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
          <small>Isi tanggal di masa depan untuk menjadwalkan.</small>
        </div>
        @if ($post->exists && $post->isPublished())
          <label class="check"><input type="checkbox" name="regenerate_slug" value="1"> Perbarui alamat (URL) sesuai judul baru</label>
        @endif
        <div class="savebar tight">
          @if ($post->exists)<a href="{{ route('news.show', $post) }}" target="_blank" class="btn btn-ghost">Pratinjau ↗</a>@endif
          <button class="btn btn-p" type="submit">Simpan</button>
        </div>
      </section>

      <section class="panel">
        <div class="panel-head"><h3>Gambar sampul</h3></div>
        <div class="cover-prev" data-preview="cover">
          @if ($post->coverUrl())<img src="{{ $post->coverUrl() }}" alt="">@else<span class="muted">Belum ada gambar</span>@endif
        </div>
        <input type="file" name="cover" accept="image/jpeg,image/png,image/webp" data-preview-input="cover">
        <small class="muted">JPG/PNG/WEBP, maks. 5 MB. Ideal 1600×900 piksel.</small>
        @if ($post->coverUrl())
          <label class="check danger"><input type="checkbox" name="remove_cover" value="1"> Hapus gambar sampul</label>
        @endif
      </section>

      @if ($post->exists)
        {{-- the delete form lives outside this form (forms cannot be nested) --}}
        <button class="btn btn-danger btn-block" type="submit" form="delete-post">Hapus berita</button>
      @endif
    </aside>
  </form>

  @if ($post->exists)
    <form id="delete-post" method="post" action="{{ route('admin.posts.destroy', $post) }}" data-confirm="Hapus berita ini beserta semua medianya?" hidden>
      @csrf @method('DELETE')
    </form>
  @endif
@endsection
