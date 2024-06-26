<?php



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/',array('as' => 'home', 'uses'=>'HomeController@index'))->before('guest');
Route::get('error', array('as' => 'error', 'uses'=>'HomeController@error'));


// Send the POST action to the Login controller. Function Login()

Route::post('login', array('as'=> 'login', 'uses'=> 'LoginController@login' ));

Route::get('logout', array('before' => 'auth', 'uses' => 'LoginController@logout'));

//Route::get('user', array('as' => 'profile', 'uses' => 'UserController@showMyProfile' ))->before('auth');
//Route::resource('user', 'UserController');
Route::resource('team', 'TeamController');
Route::get('editprofile', array('as' => 'editprofile', 'uses' => 'UserController@editMyProfile' ))->before('auth');
Route::post('upload_profilePic', array('as' => 'upload_profilePic', 'uses'=> 'UserController@upload_profilePic'));

Route::post('previewpic', array('before' => 'csrf', 'uses'=> 'UserController@preview_Picture_post'));
Route::post('upload', 'UserController@postUpload');

Route::get('user/{id}', array('as' => 'showProfile', 'uses' => 'UserController@showProfile'))->before('auth|user');

Route::get('dashboard',array('as' => 'dashboard', 'uses' => 'DashboardController@index'))->before('auth');
Route::get('log', array('as' => 'log', 'uses' => 'LogController@index'))->before('auth');

Route::get('goals',array('as' => 'goals','uses' => 'GoalController@index'))->before('auth');
Route::post('goal/weight_registration', array('as' => 'weight_registration', 'uses' => 'GoalController@weight_registration')); // Weight Goal Signup

Route::post('updatePassword', array('as' => 'user.updatePassword', 'uses'=>'UserController@updatePassword'));

Route::get('user-activity/{id}', array('as' => 'user_activity_chart', 'uses' => 'UserController@hourChart'));
Route::get('user-weight/{id}',array('as' => 'user_weight_chart', 'uses' => 'UserController@weightchart')); 

Route::get('badges', array('as' => 'badge.index', 'uses' => 'BadgeController@index'));

Route::get('goal/start_date', array('as' => 'goalstartdate', 'uses' => 'GoalController@startDate'));


// Admin Routes
Route::group(array('before' => array('auth|admin')), function()
{

	Route::get('admin',array('as'=> 'admin', 'uses' => 'AdminController@index'));
	Route::get('/admin/create',array('as' => 'admin_user.create', 'uses' => 'AdminController@createUser'));
	Route::get('/admin/{id}/edit',array('as'=> 'admin_user.edit', 'uses' => 'AdminController@editUser'));
	Route::put('/admin/update/{id}',array('as'=> 'admin_user.update', 'uses' => 'AdminController@updateUser'));
	Route::get('/admin/password/{id}',array('as'=> 'admin_user.password_reset', 'uses' => 'AdminController@resetPassword'));
	Route::delete('/admin/delete/{id}',array('as'=> 'admin_user.destroy', 'uses' => 'AdminController@destroyUser'));
	Route::post('/admin', array('as' => 'admin_user.store', 'uses' => 'AdminController@storeUser'));
	Route::get('/admin/team/create',array('as' => 'admin_team.create', 'uses' => 'AdminController@createTeam'));
	Route::post('/admin/team', array('as' => 'admin_team.store', 'uses' => 'AdminController@storeTeam'));
	Route::get('/admin/team/{id}/edit', array('as'=> 'admin_team.edit', 'uses' => 'AdminController@editTeam'));
	Route::put('/admin/team/update/{id}',array('as'=> 'admin_team.update', 'uses' => 'AdminController@updateTeam'));
	Route::delete('/admin/team/delete/{id}', array('as' => 'admin_team.destroy', 'uses' => 'AdminController@destroyTeam'));
	Route::get('admin/reward-filter/{type}', array('as'=> 'admin_reward.update', 'uses'=> 'AdminController@getRewardFilter'));
	Route::get('admin/ajax/{type}', array('as'=> 'item.type', 'uses'=> 'AdminController@getAdminType'))->where('type', 'user|team|reward');
    Route::get('admin/reports', array('as' => 'admin_reports', 'uses'=> 'AdminController@report_index'));
    Route::get('people', array('before' => 'auth', 'as'=> 'people', 'uses' => 'AdminController@nameCache'));
});





if (Request::ajax()){
Route::post('applaud/{id}', array('as' => 'applaud', 'uses' => 'ApplaudController@create'));
Route::get('user-info/{id}', array('as' => 'user_profile', 'uses' => 'UserController@show'));
Route::get('user-activity/{id}', array('as' => 'user_activity_chart', 'uses' => 'UserController@hourChart')); 
Route::post('activities_pag/', array('as' => 'activities_pag', 'uses' => 'ActivityController@pagination'));
Route::get('team-donut', array('as' => 'team_donut_chart', 'uses' => 'DashboardController@donutChart'));
Route::get('hovercard/{id}', array('as' => 'hovercard', 'uses' => 'UserController@hovercard'));
Route::post('user/applaud/{id}', array('as' => 'user_applaud', 'uses' => 'ApplaudController@create'));
Route::post('activity/{data}', array('as' => 'activity', 'uses' => 'ActivityController@store'));
Route::post('activityread/{id}', array('as' => 'read', 'uses' => 'ActivityController@read'));
Route::get('activitycheck/{data}',array('as'=> 'timecheck', 'uses' => 'ActivityController@check'));
Route::get('weightcheck/{data}', array('as'=> 'weightcheck', 'uses' => 'GoalController@weight_check'));
Route::post('goalstore/{data}',array('uses' => 'GoalController@store'));
Route::get('newactivities/{data}', array('as'=> 'newactivity', 'uses' => 'ActivityController@newActivities'));
Route::post('goal/update_progress', array('as'=> 'update_progress','uses'=>'GoalController@update_progress'));
Route::get('goal/start_date', array('as' => 'goalstartdate', 'uses' => 'GoalController@startDate'));
//Route::get('goal/check',array('as'=>'goalcheck', 'uses'=>'GoalController@check')); delete
Route::get('activity-filter/{type}', array('as'=>'activity.filter', 'uses'=> 'ActivityController@getActivityFilter'));
Route::get('activity-minifeed', array('as'=> 'minifeed', 'uses' => 'HomeController@getMiniFeed'));
Route::get('topusers',array('as'=> 'topusers', 'uses' => 'HomeController@getTopUsers'));
}