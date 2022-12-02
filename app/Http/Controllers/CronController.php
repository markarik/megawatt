<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Crons\SendExpiryNotifications;
use App\Crons\SendTopupNotifications;
use App\Crons\SendClientBroadcastMessages;
use App\Crons\SendAgentBroadcastMessages;

class CronController extends Controller
{

	function expiries(){
		(new SendExpiryNotifications)(); // Invoke expiry notification
		exit;
	}

	function topUp(){
		(new SendTopupNotifications)(); // Invoke topup notification 
		exit;
	}
	
	function clientBroadcast(){
		(new SendClientBroadcastMessages)(); // Invoke client broadcats
		exit;
	}

	function agentBroadcast(){
		(new SendAgentBroadcastMessages)(); // Invoke agent broadcats
		exit;
	}
	
}

