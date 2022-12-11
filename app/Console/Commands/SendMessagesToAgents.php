<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\MyHelpers\CommonHelpers;

use App\Models\AgentBroadcastNotification;
class SendMessagesToAgents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:send-agents-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command To send messages to our agents';

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
        $unsent_broadcasts = AgentBroadcastNotification::where('status', 0)->limit(10)->get();
		
		if( $unsent_broadcasts ){
			$find = ['#name', '#phone'];

			foreach($unsent_broadcasts as $unsent_broadcast){
				$message = $unsent_broadcast->broadcast->message;
				$agent = $unsent_broadcast->agent;

				$replace = [$agent->name, $agent->ref_no];

				$sms_body = str_replace($find, $replace, $message->message);

				$sent = CommonHelpers::sendSms($agent->ref_no, $sms_body);
				if ($sent) {
                
				$unsent_broadcast->status = 1;
				$unsent_broadcast->save();
                }
			}
		}
    }
}
