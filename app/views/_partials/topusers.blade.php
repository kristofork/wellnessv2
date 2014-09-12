@foreach($topusers as $user)

<!-- <li class="col-md-4">
	<div class="centerContainer">
		<div class="profilePicContainer row">
		    <span rel="hovercard" data-url="{{$user->users_id}}">
		        <div class="hovercard hidden-sm hidden-xs"></div>
		            {{HTML::image($user->pic, $user->first_name, array('id'=> 'profilePic'));}}
		    </span>
		</div>
        <div class="row" id="stats_profile_name">
            <h5>{{$user->first_name}}</h5>
        </div>
	</div>
</li> -->
<div class="fluid-container">
          <li class="col-xs-4 col-md-4">
            <div class="row">
                <div id="stats_profile">

                    <div class="row" id="stats_profile_image">
                        <div id="img-container">
                            <img class="img-circle" id="stats_profileImg" src='{{$user->pic}}'>
                        </div>
                    </div>  
                    <div class="row" id="stats_profile_name">
                        <div class="text-center">{{$user->first_name}}<span id="top-user-trophy">
                        <img src="/assets/img/site/trophy@2x.png">
                    </span></div>
                    </div>
                </div>
            </div>
           </li>
</div>
@endforeach