
  @foreach ($post->tags as $item)
    @if ($item->tag != "")
      <span><a href="{{ wardrobe_url('/tag/'.$item->tag) }}">{{ $item->tag }}</a></span>
    @endif
  @endforeach

