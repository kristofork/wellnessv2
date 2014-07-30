<?php

class ApplaudController extends BaseController {

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
    public function create($id)
    {
        $user = Auth::user()->id;
        if (Request::ajax()) {
            ActivityLike::create(array(
                'act_id'=> $id,
                'user_id'=> Auth::user()->id)
            );
        // Increment Activities table if user likes
            $activityCount = Activity::find($id);
            $likeCurrent = $activityCount->likeCount + 1;
            $activityCount->likeCount = $likeCurrent;
            $activityCount->save();
        // Returns the user's picture src and new total count in array
            $newuserlike = Auth::user()->pic;
            $newcount = DB::table('activities')->where('id',$id)->pluck('likeCount');
            $applaudArray = array('pic' => $newuserlike, 'newCount' => $newcount);
            return Response::json($applaudArray);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        
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
    public function update()
    {
 
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

}