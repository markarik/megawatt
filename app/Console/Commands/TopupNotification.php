<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Tracker;
use Carbon\Carbon;
use App\MyHelpers\CommonHelpers;


class TopupNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:send-top-up-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(){
        $dt = Carbon::now()->subMonth();
        $dateformated = $dt->toDateString();
        $sms_tpl = 'Hello #client_name,' . "\r\n";
        $sms_tpl .= 'Gsm line: #sim_card,' . "\r\n";

        $sms_tpl .= 'Kindly top up the number above with both '. "\r\n";
        $sms_tpl .= '- 50 bob airtime '. "\r\n";
        $sms_tpl .= '- 50 no expiry data bundles. '. "\r\n";
        $sms_tpl .= 'To continue enjoying the tracking services'. "\r\n";

        $find = ['#client_name', '#sim_card'];
     		$client_trackers = Tracker::with('client')
            ->where('type','=',"GX805S")
            ->where('init_activation_time','=', CommonHelpers::excelTimeToUnixTime($dateformated))
            ->get();  


			foreach($client_trackers as $key => $expiry){

                $client = $expiry->client;

                    $replace = [
                        explode(' ', ucfirst(strtolower($client->name)))[0], 
                        $expiry->sim_card_no, 
                        
                    ];
                    $sms_body = str_replace($find, $replace, $sms_tpl);
                    $sent = CommonHelpers::sendSms($client->phone_no, $sms_body);
                    

               
				
			}

	}
}
