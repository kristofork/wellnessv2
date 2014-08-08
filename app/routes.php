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


Route::get('/',array('as' => 'home', 'uses'=>'HomeController@index'));


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

Route::get('user/{id}', array('as' => 'showProfile', 'uses' => 'UserController@showProfile'))->before('auth');

Route::get('dashboard',array('as' => 'dashboard', 'uses' => 'DashboardController@index'))->before('auth');

Route::get('goals',array('as' => 'goals','uses' => 'GoalController@index'))->before('auth');

Route::get('admin',array('as'=> 'admin', 'uses' => 'AdminController@index'));



if (Request::ajax()){
Route::post('applaud/{id}', array('as' => 'applaud', 'uses' => 'ApplaudController@create'));
Route::get('user-info/{id}', array('as' => 'user_profile', 'uses' => 'UserController@show'));
Route::get('user-activity', array('as' => 'user_activity_chart', 'uses' => 'UserController@hourChart'));
Route::get('activities_pag/{data}', array('as' => 'activities_pag', 'uses' => 'ActivityController@pagination'));
Route::get('team-donut', array('as' => 'team_donut_chart', 'uses' => 'DashboardController@donutChart'));
Route::get('hovercard/{id}', array('as' => 'hovercard', 'uses' => 'UserController@hovercard'));
Route::post('user/applaud/{id}', array('as' => 'user_applaud', 'uses' => 'ApplaudController@create'));
Route::post('activity/{data}', array('as' => 'activity', 'uses' => 'ActivityController@store'));
Route::post('activityread/{id}', array('as' => 'read', 'uses' => 'ActivityController@read'));
Route::get('activitycheck/{data}',array('as'=> 'timecheck', 'uses' => 'ActivityController@check'));
Route::post('goal/update_progress', array('as'=> 'update_progress','uses'=>'GoalController@update_progress'));
Route::get('goal/check',array('as'=>'goalcheck', 'uses'=>'GoalController@check'));
}