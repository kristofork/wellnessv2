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
            
           
<div class="col-md-12" id="post-meta">
<span>
    <span class="glyphicons glyphicons-pen"></span> 
    <span class="post-data">Wellness Team</span>
</span>
<span>
    <span class="glyphicons glyphicons-check"></span> 
    <span class="post-data">{{$post->counter}}</span>
    </span>
<span>
    <span class="glyphicons glyphicons-tag"></span> 
    <span class="post-data">@include(theme_view('inc.tags'))</span>
    </span>
</div>
            <div class="content bubble">
                {{ $post->parsed_content }}
            </div>
            @if( $showButton )
            <button class="btn btn-success read" id="{{ $post->id}}">Mark as Read</button>
            @endif
        </div>


        
</div>
@stop

