<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

	function __construct(){
		view()->share('current_menu', 'users');
	}
	
	function index(){
		$users = User::orderBy('created_at', 'DESC')->paginate(20);

		$view_data = [
			'users' => $users, 
		];
		return view('admin.users.index', $view_data);
	}

}
