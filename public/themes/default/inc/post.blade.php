<div class="post">
  @if( $post->image != "")
      <div class="image" style="position:relative">{{HTML::image($post->image);}}
            <div class="date">
                <em id="day">{{ date("d", strtotime($post->publish_date)) }}</em>
                <em id="month">{{ date("M", strtotime($post->publish_date)) }}</em>
                <em id="year">&nbsp; {{ date("Y", strtotime($post->publish_date)) }}</em>
            </div>
      </div>

  @endif
  <h2><a href="{{ wardrobe_url('post/'.$post->slug) }}">{{ $post->title }}</a></h2>
    
<div class="col-md-12" id="post-meta">
<span>
    <span class="glyphicons glyphicons-pen"></span> 
    <span class="post-data">William K.</span>
</span>
<span>
    <span class="glyphicons glyphicons-check"></span> 
    <span class="post-data">{{$post->counter}}</span>
    </span>
<span>
    <span class="glyphicons glyphicons-tag"></span> 
    <span class="post-data">Food</span>
    </span>
</div>
  <div class="content bubble">
		{{  
			preg_replace('/\s+?(\S+)?$/', HTML::link(wardrobe_url('/post/'.$post->slug),"...Read more","..."), substr($post->parsed_content, 0, 201));
		}}
  </div>
</div>
