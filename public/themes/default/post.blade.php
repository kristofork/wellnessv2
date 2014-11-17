@extends('../layouts.master') 

@section('title') 
{{ $post->title }} 
@stop 

@section('content')
<div class="main-row">
    <div class="col-md-8" id="dash-nav">
        <ul class="nav tabs">

            <li class="active">
                <a href="#activity" data-toggle="tab">
                    <span class="hidden-xs">All</span>
                    <span class="glyphicon glyphicon-stats"></span>
                </a>
            </li>
            <li class="">
                <a href="#log" data-toggle="tab">
                    <span class="hidden-xs">Food</span>
                    <span class="glyphicon glyphicon-time"></span>
                </a>
            </li>
            <li class="">
                <a href="#" data-toggle="" class="disabled">
                    <span class="hidden-xs">Fast Facts</span>
                    <span class="glyphicon glyphicon-lock"></span>
                </a>
            </li>
            <li class="last">
                <a href="#" data-toggle="" class="disabled">
                    <span class="hidden-xs">Fun</span>
                    <span class="glyphicon glyphicon-lock"></span>
                </a>
            </li>

        </ul>
        <!-- Nav tabs -->
    </div>
    <section>
        <div id="container-post" class="col-md-8 tab-content post">
            <h2 class="title">{{ $post->title }}</h2>
            <div class="date"><em>{{ date("M/d/Y", strtotime($post->publish_date)) }}</em></div>
            <div id="postimg">
            @if( $post->image != "")
            {{HTML::image($post->image);}}
            @endif
            </div>
            <div class="content bubble">
                {{ $post->parsed_content }}
            </div>
            <button class="btn btn-success read" id="{{ $post->id}}">Mark as Read</button>
        </div>


        @include(theme_view('inc.tags'))
    </section>
</div>
@stop

