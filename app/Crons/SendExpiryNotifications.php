<?php

namespace App\Crons;

use DB;
use App\Models\Tracker;
use App\Models\TrackerExpiry;
use App\MyHelpers\CommonHelpers;

class SendExpiryNotifications {

	public function __invoke(){
		echo 'TIme: ' . date('d-m-Y H:i:s') . ' => Sending notifications.';

		if( (Integer) date('H') >= 6 && (Integer) date('H') <= 22 ){
			$sys_name = env('SYS_NAME');
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
			$intervals_arr = array_values($intervals);
			$expiry_tbl = (new TrackerExpiry())->getTable();
			$tracker_tbl = (new Tracker())->getTable();

			// Retrieve expiry records 
			$trackers_expiries = TrackerExpiry::join($tracker_tbl, $tracker_tbl . '.id', '=', 'tracker_id')
				->select( $expiry_tbl.'.*' )

				
				->where(function($query) use ($intervals, $expiry_tbl){
					$query->where(function($query) use ($intervals, $expiry_tbl) {
						$query->whereBetween($expiry_tbl.'.expiry_time', [strtotime('+2 week'), strtotime('+1 month')])
							->whereNull('notification_type');
					})
					->orWhere(function($query) use ($intervals, $expiry_tbl) {
						$query->whereBetween($expiry_tbl.'.expiry_time', [strtotime('+1 week'), strtotime('+2 week')])
							->where('notification_type', $intervals['pre_1month']);
					})
					->orWhere(function($query) use ($intervals, $expiry_tbl) {
						$query->whereBetween($expiry_tbl.'.expiry_time', [strtotime('+1 day'), strtotime('+1 week')])
							->where('notification_type', $intervals['pre_2weeks']);
					})
					->orWhere(function($query) use ($intervals, $expiry_tbl) {
						$query->whereBetween($expiry_tbl.'.expiry_time', [strtotime(date('d-m-Y 00:00:01')), strtotime('+1 day')])
							->where('notification_type', $intervals['pre_1week']);
					})
					->orWhere(function($query) use ($intervals, $expiry_tbl) {
						$query->whereBetween($expiry_tbl.'.expiry_time', [strtotime(date('d-m-Y 08:00:00')), strtotime(date('d-m-Y 23:59:59'))])
							->where('notification_type', $intervals['pre_1day']);
					})
					->orWhere(function($query) use ($intervals, $expiry_tbl) {
						$query->whereBetween($expiry_tbl.'.expiry_time', [strtotime('-8 days'), strtotime('-1 week')])
							->where('notification_type', $intervals['d_day']);
					});
				})
				

				// ->whereIn($tracker_tbl.'.id', [1, 2])
				
				->whereIn($expiry_tbl.'.id', function($query) use ($expiry_tbl) {
					$query->select( DB::raw('MAX(' . $expiry_tbl . '.id)') )
						->from($expiry_tbl)
						->groupBy($expiry_tbl . '.tracker_id');
				})
				->orderBy('client_id', 'ASC')
				->orderBy($expiry_tbl.'.expiry_time', 'ASC')
				->limit(10)
				->get();
			
			
			if( $trackers_expiries ){
				$all_plates_no = '';
				$amount = 0;
				
				foreach($trackers_expiries as $key => $expiry){
					$tracker = $expiry->tracker;
					$client = $tracker->client;
					$plate_no = str_replace(' ', '', $tracker->mv_reg_no);

					/*
					// DO NOT DELETE 
					// To be used when need to combine client's all expiries into one message 
					$next_expiry = isset($trackers_expiries[$key + 1])? $trackers_expiries[$key + 1]:FALSE;
					$next_tracker = $next_expiry ? $next_expiry->tracker : FALSE;
					
					if( $next_tracker && $client->id == $next_tracker->client->id && $expiry->expiry_time == $next_expiry->expiry_time ){
						if( $all_plates_no ){
							$all_plates_no .= ', ';
						}
						$all_plates_no .= $plate_no;
					}else{
						if( $all_plates_no ){
							$all_plates_no .= ' and ';
						}
						$all_plates_no .= $plate_no;
					}
					*/

					// if( !$next_tracker || $client->id != $next_tracker->client->id || $expiry->expiry_time != $next_expiry->expiry_time ){
						$replace = [
							explode(' ', ucfirst(strtolower($client->name)))[0], 
							$tracker->amount, 
							$plate_no, 
							date('j-M-y', ($expiry->expiry_time)) 
						];

						$sms_body = str_replace($find, $replace, $sms_tpl);
						// dd( $sms_body );
						// $all_plates_no = '';

						$sent = CommonHelpers::sendSms($client->phone_no, $sms_body);
						if( $sent ){
							// $tracker->notification_sent = 1;
							// $tracker->save();
							
							$notif_index = 0;
							if( in_array($expiry->notification_type, $intervals_arr) ){
								$notif_index = array_search($expiry->notification_type, $intervals_arr);

								if( isset($intervals_arr[$notif_index + 1]) ){
									$notif_index++;
								}
							}

							$expiry->notification_type = $intervals_arr[ $notif_index ];
							$expiry->save();
						}
						
					// }
				}
			}
		}
		
	}

}
