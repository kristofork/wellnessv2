<?php

class ActivityController extends BaseController {

    public function store($data)
    {
        $input            = Input::all();
        $time             = $input['acttime'];
        $acttimeConverted = secondsToString(hoursToSeconds($time));
        $currentDateTime  = convertTimeIso(date('Y-m-d H:i:s'));


        $rules = array(
          'actname'      => 'required',
          'actdate'      => 'required',
          'acttime'      => 'required',
          'actintensity' => 'required',
          'factpt'       => 'required'
        );
        $messages = array(
           'actname.required'      => 'Oops! You must enter a activity.',
           'actdate.required'      => 'Oops! You must select a date.',
           'acttime.required'      => 'Uh oh! You forgot to set the time!',
           'actintensity.required' => 'Oh no! You did not set a intensity.',
           'factpt.required'       => 'Something went wrong! Please contact your site administrator!',
        );


        $v = Validator::make($input, $rules, $messages);
        if ($v->fails() ) {
            $result = array('success'=> false, 'message'=> 'Activity Not Saved!');
            return Response::json($v->errors());
        }
        else
        {
            $user      = Auth::user();
            $id        = $user->id;
            $userteam  = $user->team_id;
            $userpic   = $user->pic;
            $userfirst = $user->first_name;
            $userlast  = $user->last_name;
            $rank_id   = $user->rank_id;
            $rank      = Level::find($rank_id);

            $activity                     = new Activity;
            $activity->user_id            = $id;
            $activity->activity_name      = $input['actname'];
            $activity->activity_date      = $input['actdate'];
            $activity->activity_time      = $input['acttime'];
            $activity->activity_intensity = $input['actintensity'];
            $activity->factPt             = $input['factpt'];
            $activity->team_id            = $userteam;
            $activity->type               = $input['type'];

            // If activity was submitted successfully
            if($activity->save())
            {   // Get the user's points and check if they are over their current required rank
                $points = User::find($id)->userTotalPts;
                if($points > $rank->required)
                {
                    // User meets requirements for the next rank
                    // increase their rank by 1
                    $user->rank_id = ++$rank_id;
                    $user->save();
                    $new_rank_id = User::find($id)->rank_id; // Get user's new rank
                    $new_rank = Level::find($new_rank_id);
                    // Add to the activity table
                    $activity = new Activity;
                    $activity->user_id = $id;
                    $activity->activity_name = 'Acheived the rank of '. $new_rank->name;
                    $activity->team_id = $userteam;
                    $activity->type = 'rank';
                    $activity->save();
                    
                }
                // Get the user's total time and check if they completed the time goal
                $time = $user->currentYearStats;
                // Get the current time reward
                $reward = Reward::current();
                // Base on the current Reward this will check if the user already has completed the goal to prevent multiple alerts and badge awards.
                if($reward[0]->id == 1)
                {$hasGoal = $time->half;}else{$hasGoal = $time->full;}
                
                if($time->time >= $reward[0]->milestone && $hasGoal != 1){
                    
                    // Update currentYearStats half/full bool column
                    if($reward[0]->id == 1)
                        {$time->half = 1; $time->save();}
                        else
                        {$time->full = 1; $time->save();}
                    
                    
                    $reward_id = $reward[0]->badge_id;
                    // Alert Admin of completed milestone
                    try{
                        $goal = new RewardActivity;
                        $goal->user_id = $id;
                        $goal->name = $reward[0]->name;
                        $goal->alert = 1;
                        $goal->save();
                    }catch(Exception $e){
                        echo "Error";
                    }
                    // Get badge data
                    $badge = Badge::find($reward_id);
                    
                    // Issue Badge to user
                    $badge_user = new BadgeUser;
                    $badge_user->badge_id = $badge->id; 
                    $badge_user->user_id = $user->id;
                    $badge_user->save();
                    // display alert badge earned.
                    $result = array('success'=> true, 'message'=> 'Congrats, you earned a badge!', 'badge'=> true, 'name'=>$badge->name, 'goal' => $badge->required, 'image'=> $badge->image, 'lvl'=> $badge->lvl, 'type'=>$badge->type);
                }else{
                $result = array('success'=> true, 'message'=> 'Activity Saved!');
                }
                return Response::json($result);
            }
        }
    }

    public function read($id)
    {
        $post = Post::find($id); // find the post that was clicked
        $user = Auth::user();   // find the current user
        $last_badge  = Badge::where('type', 'read')->orderBy('lvl', 'desc')->first(); // get the last badge lvl
        $activity = new Activity;   //create the activity 
        $activity->user_id = $user->id;
        $activity->team_id = $user->team_id;
        $activity->activity_name  = $post['title'];
        $activity->type     = 'read';
        $activity->save();
        
        // increment counter
        $postcount = $post->counter + 1; 
        $post->counter = $postcount;
        $post->save();

        // need to find the user and badge that is tracking the progress
        
        $badge = BadgeProgress::where('user_id','=',$user->id)
            ->where('type','=','read')
            ->first(); 
        
        
        if (! count($badge)) // if user progress is not found, create an entry for the user, get the first level requirement for the badge, set a starting lvl of 1, and add a count of 1 and save.
        {
            $badge_data = Badge::where('type', '=' ,'read')
                ->where('lvl', '=', 1)
                ->first();
            
            $badge = new BadgeProgress;
            $badge->badge_id = $badge_data->id;
            $badge->user_id = Auth::user()->id;
            $badge->counter = 1;
            $badge->lvl = 1;
            $badge->required = $badge_data->required;
            $badge->type = "read";
            $badge->progress_id = $id;
            $badge->save();
            $result = array('success'=> true, 'message'=> 'Activity Saved!');
        }
        else  
        {
                // if statement to see if user will meet the required count for the next level and does not exceed the last lvl possible. If so increment lvl ++ and message back with response.
            $required = $badge['required'];
            $count = $badge['counter'] + 1;
            if($required == $count && $last_badge->lvl >= ($badge->lvl + 1) ) 
                {
                    // set vars for current and new badge lvl
                    //** need a if to prevent going to a lvl that doesn't exsist.
                    $lvl = $badge->lvl;
                    $lvlup_new = $badge->lvl +1;
                
                    // get current and new badge data
                    $badge_data = Badge::where('type', '=' ,'read')->where('lvl', '=', $lvl )->first();
                    $badge_data_new = Badge::where('type', '=' ,'read')->where('lvl', '=', $lvlup_new)->first();
                    
                    // set new current lvl and required values
                    $badge->lvl =$lvlup_new;
                    $badge->required = $badge_data->required;
                
                    // Create activity for badge earned
                    $activity = new Activity;   //create the activity 
                    $activity->user_id = $user->id;
                    $activity->team_id = $user->team_id;
                    $activity->activity_name  = "Earned a level ". $badge_data->lvl ." ". $badge_data->name . " badge";
                    $activity->type     = 'badge';
                    $activity->save();
                
                    // record badge to user
                
                    $userbadge = new BadgeUser;
                    $userbadge->user_id = Auth::user()->id;
                    $userbadge->badge_id = $badge->badge_id;
                    $userbadge->save();
                    $result = array('success'=> true, 'message'=> 'Congrats, you earned a badge!', 'badge'=> true,'name'=>$badge_data->name, 'goal' => $badge_data->required, 'image'=> $badge_data->image, 'lvl'=> $badge_data->lvl, 'type'=>$badge_data->type,'desc'=>$badge_data->desc);
                }
            else{
                $result = array('success'=> true, 'message'=> 'Activity Saved!');
                }
            $badge->counter = $count;
            $badge->progress_id = $badge['progress_id'].",".$id;
            $badge->save();
              
        }
            return Response::json($result);
    }

    public function check($data)
    {
        $id = Auth::user()->id;
        $dayTotal = DB::table('activities')
                    ->select(DB::raw('SUM(TIME_TO_SEC( activity_time )) AS DayTotal'))
                    ->where('user_id', $id)
                    ->where('activity_date', $data)
                    ->get();

        $weekTotal = DB::select(DB::raw("SELECT SUM(TIME_TO_SEC( activity_time )) AS weekTotal FROM  `activities` WHERE user_id = '$id' AND YEARWEEK( activity_date ) = YEARWEEK('$data') GROUP BY YEARWEEK( activity_date )"));
        if( empty($weekTotal)){ $weekTotal = [["weekTotal"=> "0"]];}

        $result = array('daytotal'=> $dayTotal, 'weektotal'=> $weekTotal);
        return Response::json($result);
    }

    public static function pagination()
    {
        $user_id = Auth::user()->id;
        $input = Input::all();
        $from = $input['load'];
        $type = $input['filter'];
        $columns = array('users.first_name', 'users.last_name', 'users.username', 'activities.id', 'activities.activity_name', 'activities.likeCount','activities.type','activities.goal_num', 'users.pic', 'activities.created_at', 'activities.activity_time');
        
        if($type == 'Everyone')
        {
            
            $activities = Activity::with(array('user.badgeuser' => function($q){
                                    $q->join('badges','badges.id','=','badge_id')->orderBy('created_at','desc')->get();
                                    }),'user')
                ->with(array('likes' => function($q) use ($user_id){
                    $q->where('user_id',$user_id)->first();
                }))->orderBy('activities.created_at', 'desc')->skip($from)->take(10)->get();
        } 
        elseif($type == 'Team')
        {
            $team = Auth::user()->team_id;
            $activities = Activity::with(array('user.badgeuser' => function($q){
                                    $q->join('badges','badges.id','=','badge_id')->orderBy('created_at','desc')->get();
                                    }),'user')
                ->with(array('likes' => function($q) use ($user_id){
                    $q->where('user_id',$user_id)->first();
                }))->where('team_id',$team)->orderBy('activities.created_at', 'desc')->skip($from)->take(10)->get();
        }
        else
        {
            $activities = Activity::with(array('user.badgeuser' => function($q){
                                    $q->join('badges','badges.id','=','badge_id')->orderBy('created_at','desc')->get();
                                    }),'user')
                ->with(array('likes' => function($q) use ($user_id){
                    $q->where('user_id',$user_id)->first();
                }))->where('user_id',$user_id)->orderBy('activities.created_at', 'desc')->skip($from)->take(10)->get();
        }

        return Response::json(['activities' => $activities, 'userid'=> $user_id]);
    }

    public function newActivities($data)
    {
        $result =  Activity::where('created_at','>', $data)->get()->count();
        return Response::json($result);
    }

    public static function getActivityFilter($type)
    {
        $user_id = Auth::user()->id;
        
        if($type == 'Everyone'){
            $activities = Activity::with(array('user.badgeuser' => function($q){
                                    $q->join('badges','badges.id','=','badge_id')->orderBy('created_at','desc')->get();
                                    }),'user')
                ->with(array('likes' => function($q) use ($user_id){
                    $q->where('user_id',$user_id)->first();
                }))->orderBy('activities.created_at', 'desc')->take(10)->get();
            
        } elseif($type == "Team"){
            $team = Auth::user()->team_id;
            $activities = Activity::with(array('user.badgeuser' => function($q){
                                    $q->join('badges','badges.id','=','badge_id')->orderBy('created_at','desc')->get();
                                    }),'user')
                ->with(array('likes' => function($q) use ($user_id){
                    $q->where('user_id',$user_id)->first();
                }))->where('team_id',$team)->orderBy('activities.created_at', 'desc')->take(10)->get();

        }else{
            $user = Auth::user()->id;
            $activities = Activity::with(array('user.badgeuser' => function($q){
                                    $q->join('badges','badges.id','=','badge_id')->orderBy('created_at','desc')->get();
                                    }),'user')
                ->with(array('likes' => function($q) use ($user_id){
                    $q->where('user_id',$user_id)->first();
                }))->where('user_id',$user)->orderBy('activities.created_at', 'desc')->take(10)->get();
        }
        return Response::json(array('activities' =>$activities, 'user' => $user_id));

}
}