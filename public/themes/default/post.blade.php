@extends('../layouts.lite') 

@section('title') 
{{ $post->title }} 
@stop 

@section('content')


<div class="row-centered">

        <div id="container-post" class="col-centered col-md-6 post">
           
             @if( $post->image != "")
              <div class="image" style="position:relative">{{HTML::image($post->image);}}
                    <div class="date">
                        <em id="day">{{ date("d", strtotime($post->publish_date)) }}</em>
                        <em id="month">{{ date("M", strtotime($post->publish_date)) }}</em>
                        <em id="year">&nbsp; {{ date("Y", strtotime($post->publish_date)) }}</em>
                    </div>
              </div>
              @endif
              
            <h2 class="title">{{ $post->title }}</h2>
            <div class="row" id="post-meta">
            <span class="glyphicons pen"></span> 
            <span>William K.</span>
            <span class="glyphicons check"></span> 
            <span>38</span>
            <span class="glyphicons tag"></span> 
            @include(theme_view('inc.tags'))
            </div>            

            <div class="content bubble">
                {{ $post->parsed_content }}
            </div>
            <button class="btn btn-success read" id="{{ $post->id}}">Mark as Read</button>
        </div>


        
</div>
@stop

