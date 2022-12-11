<?php

namespace App\Crons;

use DB;
use App\MyHelpers\CommonHelpers;

use App\Models\Client;
use App\Models\BroadcastMessage;
use App\Models\Broadcast;
use App\Models\ClientBroadcastNotification;

class SendClientBroadcastMessages {

	public function __invoke(){
		$unsent_broadcasts = ClientBroadcastNotification::where('status', 0)->limit(10)->get();

		if( $unsent_broadcasts ){
			$find = ['#name', '#phone'];

			foreach($unsent_broadcasts as $unsent_broadcast){
				$message = $unsent_broadcast->broadcast->message;
				$client = $unsent_broadcast->client;

				$replace = [$client->name, $client->phone_no];
				$sms_body = str_replace($find, $replace, $message->message);
				CommonHelpers::sendSms($client->phone_no, $sms_body);
				
				$unsent_broadcast->status = 1;
				$unsent_broadcast->save();
			}
		}
	}

}
