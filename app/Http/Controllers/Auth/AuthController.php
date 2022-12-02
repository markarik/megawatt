<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\MyHelpers\CommonHelpers;

class AuthController extends Controller {

	protected $auth;

	function __construct(Auth $auth){
		$this->auth = $auth;
	}
	
	function login(){
		return view('auth.login-form');
	}

	function postLogin(Request $request){
		$validated_data = $request->validate([
			'email' => ['required', 'email'],
			'password' => ['required'],
		]);

		$credentials = $request->only('email', 'password');
		if (Auth::attempt($credentials)) {
			return redirect()->route('home');
		}else{
			$error = ['Username or password is incorrect.'];
			return redirect()->route('auth.login')
				->withInput( $request->except('password') )
				->withErrors($error);
		}
	}

	function logout(){
		Auth::logout();
		return redirect()->route('auth.login');
	}

	function sms($phone, $msg){
		CommonHelpers::sendSms($phone, $msg);
		echo 'SMS sent';
	}
	
}
