<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\MyHelpers\CommonHelpers;
use App\Models\TrackerExpiry;

class CheckExpiryAfterOneWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:past-one-week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to send notification of expiry past one week';

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
		$dt = Carbon::now()->subWeek();
		$dateformated = $dt->toDateString();


			$sys_paybill = env('SYS_PAYBILL');
			$sys_phone_numbers = env('SYS_PHONE_NUMBERS');

			
			$sms_tpl = 'Dear #client_name,' . "\r\n";
			$sms_tpl .= 'Your vehicle #car_plate, tracking  expired on  '.$dateformated . ' Renew your yearly subscription to:- '. "\r\n";
			$sms_tpl .= 'Paybill: ' . $sys_paybill . "\r\n";
			$sms_tpl .= 'Acc No: #car_plate' . "\r\n";
			$sms_tpl .= 'Amount: #renewal_rate' . "\r\n";
			$sms_tpl .= 'To continue enjoying your tracking experience '. "\r\n";
	
	
			$sms_tpl .= 'MTL call center ' . $sys_phone_numbers;
	
	
			
			$find = ['#client_name', '#renewal_rate', '#car_plate'];
	

		
			$trackers_expiries = TrackerExpiry::with('tracker.client')    
			-> where('expiry_time', '=', CommonHelpers::excelTimeToUnixTime($dateformated))    
			->get();  
			

			
			if( $trackers_expiries ){
				
				foreach($trackers_expiries as $key => $expiry){
					$client = $expiry->tracker->client;
					$plate_no = str_replace(' ', '', $expiry->mv_reg_no);

						$replace = [
							explode(' ', ucfirst(strtolower($client->name)))[0], 
							$expiry->amount, 
							$plate_no, 
							date('j-M-y', (strtotime($expiry->expiry_time))) 
						];
						


						$sms_body = str_replace($find, $replace, $sms_tpl);

					CommonHelpers::sendSms($client->phone_no, $sms_body);
						
						
				}
			}
		
	}
}
