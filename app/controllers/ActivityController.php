<?php

class ActivityController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($data)
    {
        $input = Input::all();
        $time = $input['acttime'];
        $acttimeConverted = secondsToString(hoursToSeconds($time));
        $currentDateTime = convertTimeIso(date('Y-m-d H:i:s'));


      $rules = array(
      'actname' => 'required',
      'actdate' => 'required',
      'acttime' => 'required',
      'actintensity' => 'required',
      'factpt' => 'required'
      );
      $messages = array(
       'actname.required' => 'Oops! You must select a activity.',
       'actdate.required' => 'Oops! You must select a date.',
       'acttime.required' => 'Uh oh! You forgot to set the time!',
       'actintensity.required' => 'Oh no! You did not set a intensity.',
       'factpt.required' => 'Something went wrong! Please contact your site administrator!',
        );


        $v = Validator::make(Input::all(), $rules);
        if ($v->fails() ) {
            $result = array('success'=> false, 'message'=> 'Activity Not Saved!');
            return Response::json($v->errors());
        }
        else{
        $user = Auth::user();
        $id = $user->id;
        $userteam = $user->team_id;
        $userpic = $user->pic;
        $userfirst = $user->first_name;
        $userlast = $user->last_name;

        $rank_id =$user->rank_id;
        $rank = Level::find($rank_id);

        $activity = new Activity;
        $activity->user_id = $id;
        $activity->activity_name = $input['actname'];
        $activity->activity_date = $input['actdate'];
        $activity->activity_time = $input['acttime'];
        $activity->activity_intensity = $input['actintensity'];
        $activity->factPt = $input['factpt'];
        $activity->team_id = $userteam;
        $activity->type = $input['type'];

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
            $time = User::find($id)->currentYearStats;
            // Get the current time reward
            $reward = Reward::current();
            if($time->time >= $reward[0]->milestone){
                try{
                    $goal = new RewardActivity;
                    $goal->user_id = $id;
                    $goal->name = $reward[0]->name;
                    $goal->alert = 1;
                    $goal->save();
                }catch(Exception $e){
                    echo "Error";
                }
            }

                $result = array('success'=> true, 'message'=> 'Activity Saved!','userpic' => $userpic, 'acttime' => $acttimeConverted, 'actname' => $input['actname'], 'firstname'=> $userfirst, 'lastname' => $userlast, 'currentTime' => $currentDateTime);

            return Response::json($result);
        }



        }

    }

public function read($id)
{
    $post = Post::find($id);


    $activity = new Activity;
    $activity->userName = Auth::user()->username;
    $activity->actName = $post['title'];
    $activity->type = 'read';
    $activity->save();

    $badge = BadgeProgress::find(1);

    if (is_null($badge))
    {
        $badge = new BadgeProgress;
        $badge->badge_id = 1;
        $badge->user_id = Auth::user()->id;
        $badge->count = 1;
        $badge->save();
    }
    else
    {
        $badge = BadgeProgress::where('user_id', '=', Auth::user()->id)
            ->where('badge_id', '=', 1)
            ->get();
        $count = $badge['count'] + 1;
        $badge->count = $count;
        $badge->save();
    }
            $result = array('success'=> true, 'message'=> 'Activity Saved!');

        return Response::json($result);
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

        /**
     * Check time limits
     *
     * @param  int  $id
     * @return Response
     */
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
        $input = Input::all();
        $from = $input['load'];
        $type = $input['filter'];
        $columns = array('users.first_name', 'users.last_name', 'users.username', 'activities.id', 'activities.activity_name', 'activities.likeCount','activities.type','activities.goal_num', 'users.pic', 'activities.created_at', 'activities.activity_time');
        if($type == 'Everyone')
        {
                $activities = Activity::orderBy('activities.created_at', 'desc')
                ->join('users','activities.user_id', '=','users.id')
                ->skip($from)
                ->take(10)
                ->get($columns);
        } elseif($type == 'Team')
        {
            $team = Auth::user()->team_id;
                $activities = Activity::orderBy('activities.created_at', 'desc')
                ->join('users','activities.user_id', '=','users.id')
                ->where('activities.team_id','=',$team)
                ->skip($from)
                ->take(10)
                ->get($columns);
        }else
        {
            $user = Auth::user()->id;
                $activities = Activity::orderBy('activities.created_at', 'desc')
                ->join('users','activities.user_id', '=','users.id')
                ->where('activities.user_id', '=', $user)
                ->skip($from)
                ->take(10)
                ->get($columns);
        }

        return Response::json($activities);
    }

    public function newActivities($data)
    {
        $result =  Activity::where('created_at','>', $data)->get()->count();
        return Response::json($result);
    }

    public static function getActivityFilter($type)
    {
        $columns = array(DB::raw('users.id as `users_id`'),'users.first_name', 'users.last_name', 'users.username', 'activities.id', 'activities.activity_name', 'activities.likeCount','activities.type','activities.goal_num', 'users.pic', 'activities.created_at', 'activities.activity_time');
        if($type == 'Everyone'){
        $activities = DB::table('activities')
                ->join('users', 'users.id', '=', 'activities.user_id')
                ->orderBy('activities.created_at', 'desc')
                ->take(10)
                ->get($columns);
        } elseif($type == "Team"){
            $team = Auth::user()->team_id;
        $activities = DB::table('activities')
                ->join('users', 'users.id', '=', 'activities.user_id')
                ->where('activities.team_id','=', $team)
                ->orderBy('activities.created_at', 'desc')
                ->take(10)
                ->get($columns);

        }else{
            $user = Auth::user()->id;
        $activities = DB::table('activities')
                ->join('users', 'users.id', '=', 'activities.user_id')
                ->where('activities.user_id','=', $user)
                ->orderBy('activities.created_at', 'desc')
                ->take(10)
                ->get($columns);
        }
        $view = View::make('_partials.activityfeed')->with('activities', $activities);
        echo $view;
        exit;
    }

    public static function getMiniFeed()
    {
        $columns = array(DB::raw('users.id as `users_id`'), 'users.first_name', 'users.last_name', 'users.username', 'activities.id', 'activities.activity_name', 'activities.likeCount','activities.type','activities.goal_num', 'users.pic', 'activities.created_at', 'activities.activity_time');
        $activities = DB::table('activities')
                ->join('users', 'users.id', '=', 'activities.user_id')
                ->orderBy('activities.created_at', 'desc')
                ->take(10)
                ->get($columns);
        $view = View::make('_partials.minifeed')->with('activities', $activities);
        echo $view;
        exit;
    }

}