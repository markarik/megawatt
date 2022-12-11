<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
	return view('welcome');
});
*/

Route::get('/login', 'Auth\AuthController@login')->name('auth.login');
Route::post('/login', 'Auth\AuthController@postLogin')->name('auth.login.submit');
Route::get('/sms/{phone}/{msg}', 'Auth\AuthController@sms')->name('auth.sms');


Route::get('/crons/topup', 'CronController@topUp');
Route::get('/crons/expiries', 'CronController@expiries');
Route::get('/crons/client_broadcasts', 'CronController@clientBroadcast');
Route::get('/crons/agent_broadcasts', 'CronController@agentBroadcast');


Route::group(['middleware' => 'auth'], function(){
	Route::get('/logout', 'Auth\AuthController@logout')->name('auth.logout');
	
	Route::get('/', 'HomeController@index')->name('home');
	Route::post('/upload', 'HomeController@processUpload')->name('upload-process');

	// Route::get('/transfer-expiries', 'HomeController@transferExpiries');


	Route::group(['prefix' => 'trackers'], function(){
		Route::get('/', 'TrackerController@index')->name('trackers');
		Route::get('/active', 'TrackerController@active')->name('trackers.active');
		Route::get('/expired', 'TrackerController@expired')->name('trackers.expired');
		Route::get('/inactive', 'TrackerController@inactive')->name('trackers.inactive');

		Route::get('/view/{id}', 'TrackerController@view')->name('tracker.view');
		Route::get('/edit/{id}', 'TrackerController@edit')->name('tracker.edit');
		Route::post('/update/{id}', 'TrackerController@update')->name('tracker.update');
		Route::post('/delete/{id}', 'TrackerController@delete')->name('tracker.delete');
	});

	Route::group(['prefix' => 'clients'], function(){
		Route::get('/', 'ClientController@index')->name('clients');
		Route::get('/view/{id}', 'ClientController@view')->name('client.view');
		Route::get('/edit/{id}', 'ClientController@edit')->name('client.edit');
		Route::post('/update/{id}', 'ClientController@update')->name('client.update');
		Route::post('/delete/{id}', 'ClientController@delete')->name('client.delete');
		Route::get('/message', 'ClientController@message')->name('clients.message');
		Route::post('/message', 'ClientController@sendMessage')->name('clients.message.save');
	});

	Route::group(['prefix' => 'agents'], function(){
		Route::get('/', 'AgentController@index')->name('agents');
		Route::get('/view/{id}', 'AgentController@view')->name('agent.view');
		Route::get('/edit/{id}', 'AgentController@edit')->name('agent.edit');
		Route::post('/update/{id}', 'AgentController@update')->name('agent.update');
		Route::post('/delete/{id}', 'AgentController@delete')->name('agent.delete');
		Route::get('/message', 'AgentController@message')->name('agent.message');
		Route::post('/message', 'AgentController@sendMessage')->name('agents.message.save');
	});

	Route::group(['prefix' => 'messages'], function(){
		Route::get('/', 'MessageController@index')->name('messages');
		Route::get('/view/{id}', 'MessageController@view')->name('message.view');
		Route::get('/new', 'MessageController@new')->name('message.new');
		Route::get('/edit/{id}', 'MessageController@edit')->name('message.edit');
		Route::post('/save/{id?}', 'MessageController@save')->name('message.save');
		Route::post('/delete/{id}', 'MessageController@delete')->name('message.delete');
	});

	Route::group(['prefix' => 'users'], function(){
		Route::get('/', 'UserController@index')->name('users');
		Route::get('/view/{id}', 'UserController@view')->name('user.view');
		Route::get('/edit/{id}', 'UserController@edit')->name('user.edit');
		Route::post('/update/{id}', 'UserController@update')->name('user.update');
		Route::post('/delete/{id}', 'UserController@delete')->name('user.delete');
	});
});

