<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Tracker;
use App\Models\TrackerExpiry;

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
    protected $description = 'Command to notify top up';

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

       
     		$client_trackers = Tracker::with('client')
            ->where('init_activation_time','=', CommonHelpers::excelTimeToUnixTime($dateformated))
            ->get();  



			foreach($client_trackers as $key => $expiry){

                $client = $expiry->client;

                // if ($client->type == "GX805S" ) {
                //     $sms_tpl = 'Hello #client_name,' . "\r\n";
                //     $sms_tpl .= 'Gsm line: #sim_card,' . "\r\n";
            
                //     $sms_tpl .= 'Kindly top up the number above with both '. "\r\n";
                //     $sms_tpl .= '- 50 bob airtime '. "\r\n";
                //     $sms_tpl .= '- 50 no expiry data bundles. '. "\r\n";
                //     $sms_tpl .= 'To continue enjoying the tracking services'. "\r\n";
            
                //     $find = ['#client_name', '#sim_card'];



                //     $replace = [
                //         explode(' ', ucfirst(strtolower($client->name)))[0], 
                //         $expiry->sim_card_no, 
                        
                //     ];
                //     $sms_body = str_replace($find, $replace, $sms_tpl);
                //     $sent = CommonHelpers::sendSms($client->phone_no, $sms_body);
                //     if ($sent) {
                //         $this->postNewDates($expiry);
                //     }
                    
                // } else {
                    $sys_phone_numbers = env('SYS_PHONE_NUMBERS');
            
                    $sms_tpl = 'Dear #client_name,' . "\r\n";

                    $sms_tpl .= 'Top up #car_plate no, #tracker line with airtime and non-expiry data bundles to enjoy your tracking experience. '. "\r\n";

                    $sms_tpl .= 'MTL call center ' . $sys_phone_numbers;



                    
                    $find = ['#client_name', '#car_plate','#tracker'];



                    $plate_no = str_replace(' ', '', $expiry->mv_reg_no);

                    $replace = [
                        explode(' ', ucfirst(strtolower($client->name)))[0], 
                        $plate_no, 
                        $expiry->id_no
                        
                    ];
                    $sms_body = str_replace($find, $replace, $sms_tpl);
                    $sent = CommonHelpers::sendSms($client->phone_no, $sms_body);


                    if ($sent) {
                        $this->postNewDates($expiry);
                    }
            
                // }
                


               
				
			}

	}


    public function postNewDates($expiry){
        $dt = Carbon::now();
        $dateformated = $dt->toDateString();


        $tracker = Tracker::find($expiry->id);
					
						DB::beginTransaction();

							$tracker->sim_card_no = $expiry->sim_card_no;
							$tracker->amount = $expiry->amount;
							$tracker->creation_time = $expiry->creation_time;
							$tracker->init_activation_time = strtotime($dateformated);
                            $tracker->expiry_time = $expiry->expiry_time;
							$tracker->notification_sent = $expiry->notification_sent;

							

							$tracker->save();
$trackExpr = TrackerExpiry::where('tracker_id','=',$tracker->id)->first();

							
                            $trackExpr->user_id = $trackExpr->user_id;
							$trackExpr->tracker_id = $trackExpr->tracker_id;
							$trackExpr->activation_time = strtotime($dateformated);
                            $trackExpr->expiry_time = $trackExpr->expiry_time;
							
							$trackExpr->save();


							

							DB::commit();
						
					

    }
}
