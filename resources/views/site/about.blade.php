@extends('layouts.site')
@section('title', 'Tentang Kami')
@section('description', $site['about_page_intro'])

@php
  $T = \App\Support\Text::class;
  $mission = $T::lines($site['about_mission']);
  $timeline = $T::pairs($site['about_timeline']);
  $units = $T::pairs($site['about_units']);
  $history = $T::paragraphs($site['about_history']);
@endphp

@section('content')
  {{-- intro --}}
  <section class="page-head container reveal">
    <span class="eyebrow fx">Tentang Kami</span>
    <h1 class="split">{{ $site['about_page_title'] }}</h1>
    @if ($site['about_page_intro'])<p class="fx">{{ $site['about_page_intro'] }}</p>@endif
  </section>

  {{-- profile + numbers --}}
  <section class="container ab-sec">
    <div class="about">
      <div class="card lead-card reveal">
        <span class="ab-label fx">Profil</span>
        @if ($site['about_p1'])<p class="fx">{{ $site['about_p1'] }}</p>@endif
        @if ($site['about_p2'])<p class="fx">{{ $site['about_p2'] }}</p>@endif
      </div>
      <div class="stats reveal">
        @foreach (['s-blue', 's-yellow', 's-white', 's-soft'] as $i => $cls)
          <div class="stat {{ $cls }} fx"><span class="k">{{ $site['stat'.($i + 1).'_label'] }}</span><span class="v">{{ $site['stat'.($i + 1).'_value'] }}</span></div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- vision & mission --}}
  @if ($site['about_vision'] || $mission)
    <section class="container ab-sec">
      <div class="head reveal">
        <span class="eyebrow fx">Arah Kami</span>
        <h2 class="split">Visi &amp; Misi</h2>
      </div>
      <div class="vm reveal">
        @if ($site['about_vision'])
          <div class="vm-card vm-vision fx">
            <span class="ab-label">Visi</span>
            <p>{{ $site['about_vision'] }}</p>
          </div>
        @endif
        @if ($mission)
          <div class="vm-card fx">
            <span class="ab-label">Misi</span>
            <ol class="vm-list">
              @foreach ($mission as $m)<li>{{ $m }}</li>@endforeach
            </ol>
          </div>
        @endif
      </div>
    </section>
  @endif

  {{-- history --}}
  @if ($history || $timeline)
    <section class="container ab-sec">
      <div class="head reveal">
        <span class="eyebrow fx">Perjalanan</span>
        <h2 class="split">Sejarah singkat</h2>
      </div>
      <div class="hist">
        @if ($history)
          <div class="hist-text reveal">
            @foreach ($history as $para)<p class="fx">{!! nl2br(e($para)) !!}</p>@endforeach
          </div>
        @endif
        @if ($timeline)
          <ol class="timeline reveal">
            @foreach ($timeline as [$year, $text])
              <li class="fx"><span class="tl-year">{{ $year }}</span><span class="tl-text">{{ $text }}</span></li>
            @endforeach
          </ol>
        @endif
      </div>
    </section>
  @endif

  {{-- units / work area --}}
  @if ($units)
    <section class="container ab-sec">
      <div class="head reveal">
        <span class="eyebrow fx">Wilayah Kerja</span>
        <h2 class="split">Unit yang kami kelola</h2>
      </div>
      <div class="units reveal">
        @foreach ($units as $i => [$name, $desc])
          <div class="unit-card fx">
            <span class="unit-no">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
            <h3>{{ $name }}</h3>
            @if ($desc)<p>{{ $desc }}</p>@endif
          </div>
        @endforeach
      </div>
    </section>
  @endif

  {{-- AKHLAK --}}
  <section class="container ab-sec">
    <div class="head reveal">
      <span class="eyebrow fx">Nilai Kami</span>
      <h2 class="split">{{ $site['akhlak_heading'] }}</h2>
      @if ($site['akhlak_subtitle'])<p class="fx">{{ $site['akhlak_subtitle'] }}</p>@endif
    </div>
    <div class="akhlak reveal">
      @foreach ([['A', 'Amanah', 'Memegang teguh kepercayaan.'], ['K', 'Kompeten', 'Terus belajar dan mengembangkan kapabilitas.'], ['H', 'Harmonis', 'Saling peduli dan menghargai perbedaan.'], ['L', 'Loyal', 'Berdedikasi bagi bangsa dan negara.'], ['A', 'Adaptif', 'Terus berinovasi menghadapi perubahan.'], ['K', 'Kolaboratif', 'Membangun kerja sama yang sinergis.']] as [$l, $t, $d])
        <div class="ak fx"><div class="l">{{ $l }}</div><h4>{{ $t }}</h4><p>{{ $d }}</p></div>
      @endforeach
    </div>
  </section>

  <div class="container ab-back reveal">
    <a href="{{ route('home') }}" class="btn btn-s fx">← Kembali ke beranda</a>
  </div>
@endsection
