{{-- one portal application card; $item, $no (display number) --}}
<a href="{{ $item->url }}" class="a-card {{ $class ?? '' }}"
   @if ($item->open_new_tab) target="_blank" rel="noopener" @endif
   data-name="{{ \Illuminate\Support\Str::lower($item->name.' '.$item->description) }}"
   data-cat="{{ $item->category }}">
  <div class="a-thumb">
    @if ($item->thumbnailUrl())
      <img src="{{ $item->thumbnailUrl() }}" alt="" loading="lazy">
    @else
      <div class="a-ph">{{ \Illuminate\Support\Str::of($item->name)->substr(0, 2)->upper() }}</div>
    @endif
    <span class="a-no">{{ str_pad((string) $no, 2, '0', STR_PAD_LEFT) }}</span>
  </div>
  <div class="a-body">
    <span class="a-cat">{{ $item->category }}</span>
    <h3>{{ $item->name }}</h3>
    @if ($item->description)<p>{{ $item->description }}</p>@endif
  </div>
  <span class="a-go" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M7 17 17 7M8 7h9v9"/></svg></span>
</a>
