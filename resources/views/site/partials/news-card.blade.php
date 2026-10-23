<a href="{{ route('news.show', $post) }}" class="n-card {{ $class ?? '' }}">
  <div class="n-thumb">
    @if ($post->coverUrl())
      <img src="{{ $post->coverUrl() }}" alt="" loading="lazy">
    @else
      <div class="n-ph">@include('site.partials.icon', ['name' => 'bolt', 'color' => '#0077b6', 'size' => 34])</div>
    @endif
  </div>
  <div class="n-body">
    <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->translatedFormat('d F Y') }}</time>
    <h3>{{ $post->title }}</h3>
    <p>{{ $post->summary(130) }}</p>
    <span class="n-more">Baca selengkapnya →</span>
  </div>
</a>
