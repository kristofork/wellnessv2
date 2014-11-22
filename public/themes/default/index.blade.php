@extends('../layouts.lite')

@section('title')
  {{ site_title() }}
@stop

@section('content')
<div class="row-centered">

		@foreach ($posts as $post)
           <div id="container-post" class="col-centered col-xs-11 col-sm-8 col-md-8 col-lg-6">
            @include(theme_view('inc.post'))
            </div>
        @endforeach
        {{ $posts->links() }}
</div>

@stop
