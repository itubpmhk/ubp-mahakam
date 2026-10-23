{{-- Usage: @include('site.partials.icon', ['name' => 'bolt', 'color' => '#0077b6', 'size' => 24]) --}}
@php($c = $color ?? 'currentColor')
@php($sz = $size ?? 24)
@switch($name)
    @case('shield')
        <svg width="{{ $sz }}" height="{{ $sz }}" viewBox="0 0 24 24" fill="none" stroke="{{ $c }}" stroke-width="2"><path d="M12 2 4 6v6c0 5 3.5 8.5 8 10 4.5-1.5 8-5 8-10V6z"/><path d="m9 12 2 2 4-4"/></svg>
        @break
    @case('leaf')
        <svg width="{{ $sz }}" height="{{ $sz }}" viewBox="0 0 24 24" fill="none" stroke="{{ $c }}" stroke-width="2"><path d="M5 21c0-9 6-15 15-16-1 9-7 15-15 16z"/><path d="M5 21 14 12"/></svg>
        @break
    @case('people')
        <svg width="{{ $sz }}" height="{{ $sz }}" viewBox="0 0 24 24" fill="none" stroke="{{ $c }}" stroke-width="2"><circle cx="9" cy="8" r="3"/><path d="M3 20c0-3.5 2.7-6 6-6s6 2.5 6 6"/><circle cx="17" cy="9" r="2.5"/><path d="M15.5 14.2c3 .4 5.5 2.6 5.5 5.8"/></svg>
        @break
    @case('chart')
        <svg width="{{ $sz }}" height="{{ $sz }}" viewBox="0 0 24 24" fill="none" stroke="{{ $c }}" stroke-width="2"><rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 20h8M12 16v4M7 12l3-3 2 2 4-4"/></svg>
        @break
    @case('gear')
        <svg width="{{ $sz }}" height="{{ $sz }}" viewBox="0 0 24 24" fill="none" stroke="{{ $c }}" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/></svg>
        @break
    @case('star')
        <svg width="{{ $sz }}" height="{{ $sz }}" viewBox="0 0 24 24" fill="none" stroke="{{ $c }}" stroke-width="2"><path d="m12 3 2.7 5.6 6.1.9-4.4 4.3 1 6.1L12 17l-5.4 2.9 1-6.1-4.4-4.3 6.1-.9z"/></svg>
        @break
    @case('globe')
        <svg width="{{ $sz }}" height="{{ $sz }}" viewBox="0 0 24 24" fill="none" stroke="{{ $c }}" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/></svg>
        @break
    @default
        <svg width="{{ $sz }}" height="{{ $sz }}" viewBox="0 0 24 24" fill="none" stroke="{{ $c }}" stroke-width="2"><path d="M13 2 4 14h7l-1 8 9-12h-7z"/></svg>
@endswitch
