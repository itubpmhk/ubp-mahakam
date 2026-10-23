@extends('layouts.admin')
@section('title', 'Konten Landing Page')

@php
  $f = fn ($name, $label, $opts = []) => array_merge(['name' => $name, 'label' => $label, 'value' => $s[$name] ?? ''], $opts);
@endphp

@section('content')
  <nav class="subnav">
    <a href="#hero">Hero</a><a href="#video">Video</a><a href="#tentang">Tentang & Angka</a><a href="#halaman-tentang">Halaman Tentang</a><a href="#judul">Judul Bagian</a><a href="#kontak">Kontak & Sosial</a>
  </nav>

  <form method="post" action="{{ route('admin.settings.update') }}" class="stack" enctype="multipart/form-data">
    @csrf @method('PUT')

    <section class="panel" id="hero">
      <div class="panel-head"><h3>Hero (bagian paling atas)</h3></div>
      <div class="grid-3">
        @include('admin.partials.field', $f('hero_badge_region', 'Label wilayah'))
        @include('admin.partials.field', $f('hero_badge_unit', 'Label unit'))
        @include('admin.partials.field', $f('hero_status', 'Status (titik hijau)', ['help' => 'Kosongkan untuk menyembunyikan.']))
      </div>
      @include('admin.partials.field', $f('hero_title', 'Judul besar', ['help' => 'Apit kata dengan tanda bintang untuk mewarnainya biru, contoh: Menjaga terang *Benua Etam*, setiap hari.']))
      @include('admin.partials.field', $f('hero_subtitle', 'Subjudul', ['type' => 'textarea', 'rows' => 2]))
      <div class="grid-2">
        @include('admin.partials.field', $f('strip_text', 'Teks strip di bawah video'))
        @include('admin.partials.field', $f('strip_chips', 'Daftar wilayah (chip)', ['help' => 'Pisahkan dengan koma.']))
      </div>
    </section>

    <section class="panel" id="video">
      <div class="panel-head"><h3>Video profil</h3></div>
      @include('admin.partials.field', $f('video_youtube', 'Link YouTube', ['type' => 'url', 'placeholder' => 'https://www.youtube.com/watch?v=…', 'help' => 'Kosongkan untuk menyembunyikan video.']))
      <div class="grid-2">
        @include('admin.partials.field', $f('video_label', 'Label kecil'))
        @include('admin.partials.field', $f('video_title', 'Judul video'))
      </div>
      <div class="field">
        <label>Gambar sampul video (opsional)</label>
        <div class="cover-prev" data-preview="vcover" style="max-width:420px">
          @if (!empty($s['video_cover']))
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($s['video_cover']) }}" alt="">
          @else
            <span class="muted">Memakai thumbnail dari YouTube</span>
          @endif
        </div>
        <input type="file" name="video_cover_file" accept="image/jpeg,image/png,image/webp" data-preview-input="vcover">
        <small>Disarankan screenshot HD dari video, ukuran 1920×1080 (JPG/PNG/WEBP, maks. 5 MB). Kosongkan untuk memakai thumbnail YouTube.</small>
        @if (!empty($s['video_cover']))
          <label class="check danger"><input type="checkbox" name="remove_video_cover" value="1"> Hapus gambar sampul (kembali ke thumbnail YouTube)</label>
        @endif
      </div>
    </section>

    <section class="panel" id="tentang">
      <div class="panel-head"><h3>Tentang kami & angka</h3></div>
      @include('admin.partials.field', $f('about_heading', 'Judul bagian'))
      @include('admin.partials.field', $f('about_p1', 'Paragraf 1', ['type' => 'textarea', 'rows' => 3]))
      @include('admin.partials.field', $f('about_p2', 'Paragraf 2', ['type' => 'textarea', 'rows' => 3]))
      <div class="stat-grid">
        @for ($i = 1; $i <= 4; $i++)
          <div class="stat-edit">
            <span class="muted">Kartu angka {{ $i }}</span>
            @include('admin.partials.field', $f("stat{$i}_value", 'Angka / nilai', ['placeholder' => 'mis. 185,6 MW']))
            @include('admin.partials.field', $f("stat{$i}_label", 'Keterangan'))
          </div>
        @endfor
      </div>
    </section>

    <section class="panel" id="halaman-tentang">
      <div class="panel-head"><h3>Halaman “Tentang Kami” (/tentang)</h3><a href="{{ route('about') }}" target="_blank" class="btn btn-ghost btn-sm">Lihat ↗</a></div>
      <p class="muted small">Paragraf profil dan 4 kartu angka diambil dari bagian “Tentang kami & angka” di atas.</p>
      <div class="grid-2">
        @include('admin.partials.field', $f('about_page_title', 'Judul halaman'))
        @include('admin.partials.field', $f('about_page_intro', 'Kalimat pembuka'))
      </div>
      @include('admin.partials.field', $f('about_vision', 'Visi', ['type' => 'textarea', 'rows' => 2]))
      @include('admin.partials.field', $f('about_mission', 'Misi', ['type' => 'textarea', 'rows' => 5, 'help' => 'Satu misi per baris.']))
      @include('admin.partials.field', $f('about_history', 'Sejarah singkat', ['type' => 'textarea', 'rows' => 6, 'help' => 'Pisahkan paragraf dengan satu baris kosong.']))
      <div class="grid-2">
        @include('admin.partials.field', $f('about_timeline', 'Linimasa (timeline)', ['type' => 'textarea', 'rows' => 6, 'help' => 'Satu peristiwa per baris, format: Tahun | Peristiwa. Contoh: 2008 | PLTG Sambera mulai beroperasi']))
        @include('admin.partials.field', $f('about_units', 'Unit / wilayah kerja', ['type' => 'textarea', 'rows' => 6, 'help' => 'Satu unit per baris, format: Nama unit | Keterangan singkat.']))
      </div>
      <p class="muted small">Kosongkan sebuah kolom untuk menyembunyikan bagian tersebut dari halaman.</p>
    </section>

    <section class="panel" id="judul">
      <div class="panel-head"><h3>Judul bagian lain</h3></div>
      <div class="grid-2">
        @include('admin.partials.field', $f('news_heading', 'Judul bagian Berita'))
        @include('admin.partials.field', $f('commit_heading', 'Judul bagian Komitmen'))
        @include('admin.partials.field', $f('portal_heading', 'Judul Portal Aplikasi'))
        @include('admin.partials.field', $f('portal_subtitle', 'Subjudul Portal Aplikasi'))
        @include('admin.partials.field', $f('akhlak_heading', 'Judul bagian AKHLAK'))
        @include('admin.partials.field', $f('akhlak_subtitle', 'Subjudul AKHLAK'))
        @include('admin.partials.field', $f('cta_heading', 'Judul kartu ajakan (biru)'))
        @include('admin.partials.field', $f('cta_text', 'Teks kartu ajakan'))
      </div>
    </section>

    <section class="panel" id="kontak">
      <div class="panel-head"><h3>Kontak, media sosial & footer</h3></div>
      @include('admin.partials.field', $f('footer_about', 'Deskripsi singkat di footer', ['type' => 'textarea', 'rows' => 2]))
      <div class="grid-2">
        @include('admin.partials.field', $f('contact_address', 'Alamat', ['type' => 'textarea', 'rows' => 3]))
        <div>
          @include('admin.partials.field', $f('contact_phone', 'Telepon'))
          @include('admin.partials.field', $f('contact_email', 'Email', ['type' => 'email']))
          @include('admin.partials.field', $f('contact_hours', 'Jam layanan'))
        </div>
      </div>
      <p class="muted small">Media sosial & tautan: isi alamat lengkap (https://…). Yang dikosongkan tidak akan ditampilkan.</p>
      <div class="grid-3">
        @include('admin.partials.field', $f('social_instagram', 'Instagram', ['type' => 'url']))
        @include('admin.partials.field', $f('social_facebook', 'Facebook', ['type' => 'url']))
        @include('admin.partials.field', $f('social_youtube', 'YouTube', ['type' => 'url']))
        @include('admin.partials.field', $f('social_linkedin', 'LinkedIn', ['type' => 'url']))
        @include('admin.partials.field', $f('social_x', 'X / Twitter', ['type' => 'url']))
      </div>
      <div class="grid-2">
        @include('admin.partials.field', $f('link_whistleblowing', 'Link Pengaduan & Whistleblowing', ['type' => 'url']))
        @include('admin.partials.field', $f('link_career', 'Link Karier & Magang', ['type' => 'url']))
      </div>
    </section>

    <div class="savebar">
      <a href="{{ route('home') }}" target="_blank" class="btn btn-ghost">Lihat situs ↗</a>
      <button class="btn btn-p" type="submit">Simpan perubahan</button>
    </div>
  </form>
@endsection
