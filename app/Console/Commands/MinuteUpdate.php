<?php

namespace App\Console\Commands;

use DB;
use App\Models\Tracker;
use App\Models\TrackerExpiry;

use App\MyHelpers\CommonHelpers;

use Illuminate\Console\Command;
use Carbon\Carbon;


class MinuteUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notifications to users to notify their suvscriptions are expired';

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
		echo 'TIme: ' . date('d-m-Y H:i:s') . ' => Sending notifications.';



			$sys_paybill = env('SYS_PAYBILL');
			$sys_phone_numbers = env('SYS_PHONE_NUMBERS');

			
			$sms_tpl = 'Hello #client_name,' . "\r\n";
			$sms_tpl .= 'Your vehicle #car_plate annual tracking renewal fee of KSH #renewal_rate is due on #expiry_date.' . "\r\n";
			$sms_tpl .= 'Paybill: ' . $sys_paybill . "\r\n";
			$sms_tpl .= 'Acc No: #car_plate' . "\r\n";
			$sms_tpl .= 'Make payments to continue enjoying your tracking experience.' . "\r\n";
			$sms_tpl .= 'Call us on ' . $sys_phone_numbers;
			
			$find = ['#client_name', '#renewal_rate', '#car_plate', '#expiry_date'];
			$intervals = config('notification.intervals');

			$dt = Carbon::now();
			$dateformated = $dt->toDateString();
			$trackers_expiries = Tracker::with('client')->
          
           where('expiry_time', '>',$dateformated)
           ->get();
			

			
			if( $trackers_expiries ){
				
				foreach($trackers_expiries as $key => $expiry){
					$client = $expiry->client;
					$plate_no = str_replace(' ', '', $expiry->mv_reg_no);

						$replace = [
							explode(' ', ucfirst(strtolower($client->name)))[0], 
							$expiry->amount, 
							$plate_no, 
							date('j-M-y', (strtotime($expiry->expiry_time))) 
						];
						


						$sms_body = str_replace($find, $replace, $sms_tpl);

						$sent = CommonHelpers::sendSms($client->phone_no, $sms_body);
						// if( $sent ){

						// }
						
				}
			}
		// }
		
	}









    // public function handle()
    // {

      

	// 	// if( (Integer) date('H') >= 6 && (Integer) date('H') <= 22 ){
	// 		$sys_name = env('SYS_NAME');
	// 		$sys_paybill = env('SYS_PAYBILL');
	// 		$sys_phone_numbers = env('SYS_PHONE_NUMBERS');

			
	// 		$sms_tpl = 'Hello #client_name,' . "\r\n";
	// 		$sms_tpl .= 'Your vehicle #car_plate annual tracking renewal fee of KSH #renewal_rate is due on #expiry_date.' . "\r\n";
	// 		$sms_tpl .= 'Paybill: ' . $sys_paybill . "\r\n";
	// 		$sms_tpl .= 'Acc No: #car_plate' . "\r\n";
	// 		$sms_tpl .= 'Make payments to continue enjoying your tracking experience.' . "\r\n";
	// 		$sms_tpl .= 'Call us on ' . $sys_phone_numbers;
			
	// 		$find = ['#client_name', '#renewal_rate', '#car_plate', '#expiry_date'];
	// 		$intervals = config('notification.intervals');
	// 		$intervals_arr = array_values($intervals);
	// 		$expiry_tbl = (new TrackerExpiry())->getTable();
	// 		$tracker_tbl = (new Tracker())->getTable();
    //         $tracker_tblData =   Tracker::all();


	// 		// Retrieve expiry records 
	// 		$trackers_expiries  = Tracker::join('clients', 'clients.id', '=', 'trackers.client_id')
            
    //         ->get();

            
			


	// 		if( $trackers_expiries ){
	// 			$all_plates_no = '';
	// 			$amount = 0;
				
	// 			foreach($trackers_expiries as  $expiry){

	// 				$this->info($expiry);

					
	// 				$plate_no = str_replace(' ', '', $expiry->mv_reg_no);

				

	// 					$replace = [
	// 						explode(' ', ucfirst(strtolower($expiry->name)))[0], 
	// 						$expiry->amount, 
	// 						$plate_no, 
	// 						date('j-M-y', ($expiry->expiry_time)) 
	// 					];

	// 					$sms_body = str_replace($find, $replace, $sms_tpl);
						
	// 					$sent = CommonHelpers::sendSms($expiry->phone_no, $sms_body);
    //                     $trackerExpire = TrackerExpiry::where('tracker_id',$expiry->id)->first();



	// 					if( $sent ){
							
							
	// 						$notif_index = 0;
	// 						if( in_array($trackerExpire->notification_type, $intervals_arr) ){
	// 							$notif_index = array_search($trackerExpire->notification_type, $intervals_arr);

	// 							if( isset($intervals_arr[$notif_index + 1]) ){
	// 								$notif_index++;
	// 							}
	// 						}

	// 						$trackerExpire->notification_type = $intervals_arr[ $notif_index ];
	// 						$trackerExpire->save();
	// 					}
						
	// 			}
	// 		}
		
    // }
}
