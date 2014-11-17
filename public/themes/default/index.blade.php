@extends('../layouts.master')

@section('title')
  {{ site_title() }}
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
    <section class="home">
		@foreach ($posts as $post)
           <div id="container-post" class="col-md-8 tab-content">
            @include(theme_view('inc.post'))
            </div>
        @endforeach
        {{ $posts->links() }}
	</section>
</div>

@stop
