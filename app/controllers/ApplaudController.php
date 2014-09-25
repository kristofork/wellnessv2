<?php

class ApplaudController extends BaseController {

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


}