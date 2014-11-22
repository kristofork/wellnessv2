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
    
<div class="row" id="post-meta">
<span class="glyphicons pen"></span> 
<span>William K.</span>
<span class="glyphicons check"></span> 
<span>38</span>
<span class="glyphicons tag"></span> 
<span>Food</span>
</div>
  <div class="content bubble">
		{{  
			preg_replace('/\s+?(\S+)?$/', HTML::link(wardrobe_url('/post/'.$post->slug),"...Read more","..."), substr($post->parsed_content, 0, 201));
		}}
  </div>
</div>
