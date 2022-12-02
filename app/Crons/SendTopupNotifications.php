<?php

namespace App\Crons;

use DB;
use App\Models\Tracker;
use App\MyHelpers\CommonHelpers;

class SendTopupNotifications {
	
	public function __invoke(){
		echo 'TIme: ' . date('d-m-Y H:i:s') . ' => Sending notifications.<br>';

		if( (Integer) date('H') >= 6 && (Integer) date('H') <= 22 ){
			$sys_name = env('SYS_NAME');
			$sys_paybill = env('SYS_PAYBILL');
			$sys_phone_numbers = env('SYS_PHONE_NUMBERS');

			$sms_suffix = 'Call us on ' . $sys_phone_numbers;
			
			
			// Retrieve expiry records 
			$tracker_tbl = (new Tracker())->getTable();

			$client_grouped_trackers = DB::table( $tracker_tbl )
				->select('client_id', DB::raw('GROUP_CONCAT(id) as trackers_ids'))
				->where(DB::raw("CAST(DATE_FORMAT(FROM_UNIXTIME(init_activation_time), '%e') AS SIGNED)"), '>=', date('d'))
				->where('topup_alert_year_month', '<', date('Ym'))
				->groupBy('client_id')
				->limit(5)
				->get();

			foreach($client_grouped_trackers as $client_trackers){
				$trackers_ids = explode(',', $client_trackers->trackers_ids);
				$trackers = Tracker::select( $tracker_tbl.'.*' )
					->where('client_id', '=', $client_trackers->client_id)
					->whereIn('id', $trackers_ids)
					->get();

				if( $trackers->count() ){
					$first_tracker = $trackers[0];
					$client = $first_tracker->client;
					$client_firstname = explode(' ', $client->name)[0];
					
					$sms_body = 'Hello ' . ucfirst(strtolower($client_firstname)) . ',' . "\r\n";
					if( $trackers->count() > 1 ){
						$sms_body .= 'Polite reminder to top up the following trackers with airtime to continue enjoying your tracking services.' . "\r\n";
						
						foreach($trackers as $tracker){
							$sms_body .= $tracker->mv_reg_no . ' - ' . $tracker->sim_card_no . "\r\n";
						}
					}else{
						$sms_body .= 'Polite reminder to top up ' . $first_tracker->mv_reg_no . ' tracker number ' . $first_tracker->sim_card_no . ' to continue enjoying your tracking services.' . "\r\n";
					}
					$sms_body .= $sms_suffix;

					try{
						$sent = CommonHelpers::sendSms($client->phone_no, $sms_body);
						if( $sent ){
							DB::table( $tracker_tbl )
								->whereIn('id', $trackers_ids)
								->update(['topup_alert_year_month' => date('Ym')]);

							echo 'Top-Up notifications sent successfully';
						}
					}catch(Exception $e){
						// echo $e->getMessage();
						echo 'Error occured';
					}
				}
			}

		}
	}


}

