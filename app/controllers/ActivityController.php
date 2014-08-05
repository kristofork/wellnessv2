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
        $id = Auth::user()->id;
        $userteam = Auth::user()->team_id;
        $userpic = Auth::user()->pic;
        $userfirst = Auth::user()->first_name;
        $userlast = Auth::user()->last_name;
        $badge_id = Auth::user()->badge_id;
        $badge = Badge::find($badge_id);

        $activity = new Activity;
        $activity->user_id = $id;
        $activity->activity_name = $input['actname'];
        $activity->activity_date = $input['actdate'];
        $activity->activity_time = $input['acttime'];
        $activity->activity_intensity = $input['actintensity'];
        $activity->factPt = $input['factpt'];
        $activity->team_id = $userteam;
        $activity->type = $input['type'];

        if($activity->save())
        {
            $points = User::find($id)->userTotalPts;
            if($points > $badge->required)
            {
            
                $user->badge_id = ++$badge_id;
                $user->save();
                $new_badge_id = User::find($id)->badge_id;
                $new_badge = Badge::find($new_badge_id);
                $activity = new Activity;
                $activity->user_id = $id;
                $activity->activity_name = 'Acheived the rank of '. $new_badge->name;
                $activity->team_id = $userteam;
                $activity->type = 'rank';
                $activity->save();
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

}