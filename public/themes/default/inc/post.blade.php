<div class="post">
  <h1><a href="{{ wardrobe_url('post/'.$post->slug) }}">{{ $post->title }}</a></h1>
  <div class="date">{{ date("M/d/Y", strtotime($post->publish_date)) }}</div>
  @if( $post->image != "")
  <div class="image">{{HTML::image($post->image);}}</div>
  @endif

  <div class="content bubble">
		{{  
			preg_replace('/\s+?(\S+)?$/', HTML::link(wardrobe_url('/post/'.$post->slug)," ...","..."), substr($post->parsed_content, 0, 201));
		}}
  </div>
      <hr id="posthr" />
</div>
