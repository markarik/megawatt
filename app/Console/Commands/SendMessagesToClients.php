<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MyHelpers\CommonHelpers;


use App\Models\ClientBroadcastNotification;

class SendMessagesToClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:send-clients-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command To send messages to our clients';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $unsent_broadcasts = ClientBroadcastNotification::with('client')->where('status', 0)->limit(10)->get();

        echo $unsent_broadcasts;

		if( $unsent_broadcasts ){
			$find = ['#name', '#phone'];

			foreach($unsent_broadcasts as $unsent_broadcast){
				$message = $unsent_broadcast->broadcast->message;
				$client = $unsent_broadcast->client;

				$replace = [$client->name, $client->phone_no];
				$sms_body = str_replace($find, $replace, $message->message);
				$sent = CommonHelpers::sendSms($client->phone_no, $sms_body);	

                $this->info($sent);
                
                if ($sent) {

                    echo $sent;
                
                    $unsent_broadcast->status = 1;
                    $unsent_broadcast->save();
                    }
			}
		}
    }
}
