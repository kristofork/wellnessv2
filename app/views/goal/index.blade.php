@extends('layouts.lite')

@section('content')
<link href='http://fonts.googleapis.com/css?family=Chelsea+Market|Nothing+You+Could+Do' rel='stylesheet' type='text/css'>
<div>
	<div class="scroll-block goals-block">
	<h2>Goals</h2>
	{{ HTML::image('/assets/img/site/beaker-2.png')}}
	<h4>This feature is still being tested and may be removed.</h4>
	<p>“What you get by achieving your goals is not as important as what you become by achieving your goals.” - Henry David Thoreau </p>
	</div>
	<div class="scroll-block how-block">
	<h2>How do goals work?</h2>
	{{ HTML::image('/assets/img/site/gear2.png')}}
	<p></p>
	</div>
	<div class="scroll-block what-block">
	<h2>What goals are available?</h2>
	{{ HTML::image('/assets/img/site/badge.png')}}
	<p>Currently the only one is, weight-loss. You will be able to choose 3 tiers of this goal.</p>
	<p> More to come!</p>
	</div>
	<div class="scroll-block achieve-block">
	<h2>I Achieved my goal... Now what?</h2>
	{{ HTML::image('/assets/img/site/trophy.png')}}
	<p>Congratulations! Fame awaits! You are front page news! </p>
	<p>Maybe even some extra hours added to your total as a bonus?</p>
	<span>;)</span>
	</div>
</div>

<script type="text/javascript">
	$(".container-fluid").removeClass();
</script>
{{ HTML::script('assets/js/jquery.fittext.js') }}
<script type="text/javascript">
	jQuery(".goals-block h2").fitText(1.2, { minFontSize: '20px', maxFontSize: '100px' })
	jQuery(".scroll-block h2").fitText(1.2, { minFontSize: '15px', maxFontSize: '60px' })
</script>
@stop