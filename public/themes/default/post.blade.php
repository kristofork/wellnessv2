@extends(theme_view('layout'))

@section('title')
  {{ $post->title }}
@stop

@section('content')
  <section>
    <h2 class="title">{{ $post->title }}</h2>

    {{ $post->parsed_content }}

  <button class="btn btn-success read" id="{{ $post->id}}">Mark as Read</button>

    @include(theme_view('inc.tags'))
  </section>
@stop

