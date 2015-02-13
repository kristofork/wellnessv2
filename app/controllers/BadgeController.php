<?php

class BadgeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /badge
	 *
	 * @return Response
	 */
	public function index()
	{
       $user = Auth::user();
       $badges = Badge::with( array('badgeuser' => function($q) use($user)
                                    {
                                        $q->where('user_id',$user->id);
                                    }),'badgeuser.user')->get();
        $user = User::with('badgeuser','badgeuser.badge')->find($user->id);
        return View::make('badge.index')
            ->with('title', 'Badges')
            ->with('isAdmin',$user->isAdmin())
            ->with('user',$user->toArray())
            ->with('badges', $badges);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /badge/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /badge
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /badge/{id}
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
	 * GET /badge/{id}/edit
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
	 * PUT /badge/{id}
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
	 * DELETE /badge/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}