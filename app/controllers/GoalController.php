<?php

class GoalController extends BaseController
{
	public function index()
	{
        $user = Auth::user();
		return View::make('goal.index')
            ->with("title", "Goals")
            ->with("isAdmin",$user->isAdmin())
            ->with('teamname',Team::teamName());
	}
    
    public function store($data)
    {
        
        $user = Auth::user();
        
        $goal_data = GoalProgress::where('user_id', $user->id)->where('active',1)->first();

        
        
        $activity = new GoalActivity;
        $activity->weight = $_POST['weight'];
        $activity->goal_date = $_POST['date'];
        $activity->user_id = $user->id;
        $activity->goal_id = $goal_data->goal_id;
        $activity->progress_id = $goal_data->id;
        $activity->save();
        
        
        // Check if the user met the set goal
        $start_weight = $goal_data->start; // 170lbs
        $total_weight = $start_weight - $_POST['weight']; // 170 - 169 = 1
        $target = $goal_data->target;
        
            // if user met goal
            if($_POST['weight'] <= $target)
            {
                $goal_id = $goal_data->goal_id;

                // get current badge data
                $badge = Goal::find($goal_id)->badge;
                // assign badge to user
                $badge_user = new BadgeUser;
                $badge_user->badge_id = $badge->id; 
                $badge_user->user_id = $user->id;
                $badge_user->save();
                
                // disable goal to prevent any further tracking
                $goal_data->progress = $start_weight - $target;
                $goal_data->active = 0;
                $goal_data->save();
                
                // show alert that user has acheieved the goal and badge was earned.
                // redirect to badges
                $result = array('success'=> true, 'message'=> 'Congrats, you earned a badge!', 'badge'=> true, 'name'=>$badge->name, 'goal' => $badge->required, 'image'=> $badge->image, 'lvl'=> $badge->lvl);
                
                
                
            }
        else
        {
        // Update Progress in GoalProgress

        $goal_data->progress = $total_weight;
        $goal_data->save();
        
        $result = array('success'=> true, 'message'=> 'Goal Updated','weight_lost' => $total_weight);   
            
        }
        
        return Response::json($result);
        
    }

    // old goal update
	public function update_progress()
	{
		$type            = "goal";
		$user            = User::find(Auth::user()->id);
		$username        = Auth::user()->username;
		$goalweight      = Input::get('progress');
		$id              = $user->goalUser->id;
		$goal_id         = $user->goalUser->goal_id;
		$currentProgress = $user->goalUser->progress;
		$total           = $currentProgress + $goalweight;
		$goal            = Goal::find($goal_id);
		$goalname        = $goal->goal_name;
		$goalUser        = GoalUser::find($id);
		$goalUser->progress = $total;
		$goalUser->save();

        Activity::create(array(
			'userName' => $username,
			'actName'  => $goalname,
			'goal_num' => $goalweight,
			'type'     => $type
        ));

		$result = array('success'=> true, 'message'=> 'Goal Updated','progress' => $total);

		return Response::json($result);
	}

	public function check()
	{
		$id              = Auth::user()->id;
		$currentDateTime = convertTimeIso(date('Y-m-d H:i:s'));
		$goal            = DB::select(DB::raw("SELECT * FROM  `activities` WHERE user_id = '$id' AND WEEK( created_at ) = WEEK('$currentDateTime') AND type = 'goal'"));
		$result          = array('success'=> true, 'message'=> $goal);
		return Response::json($result);
	}
    
    public function startDate()
    {
        $user = Auth::user();
        

        $goal = User::with(array('goalprogress' => function($q) 
                                 {
                                     $q->where('active',1)->get();
                                 }))->where('id', $user->id)->first();
        if($goal)
        {
            $start = $goal->goalprogress->toArray()[0]['created_at'];
            $start = date_create($start);
            $start = date_format($start, "Y-m-d");
            $result = array("date" => $start);
        }
        else
        {
            $result=null;
        }
        return Response::json($result);
    }
    
    public function weight_check($date)
    {
        $user = Auth::user();
        
        $activity = GoalActivity::where('goal_date', $date)->where('user_id', $user->id)->get();
        
        return Response::json($activity);
        
    }
    
    public function weight_registration()
    {
        
        // find current season
        
        $season = currentyear(); // helper

        $input = Input::all();
        $user = Auth::user();
        $usergoal = User::with(array('goalprogress' => function($q) use($season) 
            {
                $q->whereBetween('created_at', array($season['start'],$season['end']));
            }
                                    ))->where('id', $user->id)->first();
        
        $hasgoal = $usergoal->goalprogress->toArray();
        
        if (! count($hasgoal))
        {
                    
            //validation
            $rules = array(
              'weight'      => 'required|regex:/\d{2,3}(\.\d{1})?/'
            );

            $messages = array(
               'weight.required'      => 'Oops! You must enter your current weight.',
               'weight.regex'         => 'Current weight not formatted correctly. 123 or 123.4'
            );


            $v = Validator::make($input, $rules,$messages);

            if ($v->fails() ) {

                return Redirect::route('showProfile', array('user' => $user->id ))->withErrors($v);
            }        
            else{

                if(! count($usergoal->goalprogress)){
                    $date = Date('Y-m-d');
                    // create the goal in goal_progress table

                    $goal_data = Goal::where('type','weight')->where('tier',$input['intensity'])->first();
                    //dd($goal_data->id);
                    $deadline = new DateTime('2015-05-31');

                    $goal = new GoalProgress;
                    $goal->user_id = $user->id;
                    $goal->goal_id = $goal_data->id;
                    $goal->progress = 0;
                    $goal->start = $input['weight'];
                    $goal->target = $input['weight'] - $goal_data->goal;
                    $goal->deadline = $deadline->format('Y-m-d H:i:s');
                    $goal->active = 1;
                    $goal->save();

                    $activity = new GoalActivity;
                    $activity->user_id = $user->id;
                    $activity->goal_id = $goal_data->id;
                    $activity->weight = $input['weight'];
                    $activity->goal_date = $date;
                    $activity->progress_id = $goal->id;
                    $activity->save();

                    Session::flash('message', 'Goal started. Good Luck!');

                }else{
                    Session::flash('message', 'Active goal in progress');
                }

            }
        
        }  // end if no goal is found in current season
        else
        {
            Session::flash('message', 'Only 1 goal per season allowed.');
        }
        
        return Redirect::route('showProfile', array('user' => $user->id ));
    }
}