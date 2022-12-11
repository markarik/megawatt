<?php

namespace App\Crons;

use DB;
use App\MyHelpers\CommonHelpers;

use App\Models\Agent;
use App\Models\BroadcastMessage;
use App\Models\Broadcast;
use App\Models\AgentBroadcastNotification;

class SendAgentBroadcastMessages {

	public function __invoke(){
		$unsent_broadcasts = AgentBroadcastNotification::where('status', 0)->limit(10)->get();
		
		if( $unsent_broadcasts ){
			$find = ['#name', '#phone'];

			foreach($unsent_broadcasts as $unsent_broadcast){
				$message = $unsent_broadcast->broadcast->message;
				$agent = $unsent_broadcast->agent;

				$replace = [$agent->name, $agent->ref_no];
				$sms_body = str_replace($find, $replace, $message->message);
				CommonHelpers::sendSms($agent->ref_no, $sms_body);
				
				$unsent_broadcast->status = 1;
				$unsent_broadcast->save();
			}
		}
	}

}
