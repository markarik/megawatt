<?php

namespace App\MyHelpers;

use AfricasTalkingGateway;

class CommonHelpers {
	
	static function excelTimeToUnixTime($excel_time){
		// Check if $excel_time is a valid date 
		if( substr_count($excel_time, '-') == 2 || substr_count($excel_time, '/') == 2 ){
			$excel_time_secs = strtotime($excel_time);
			if( $excel_time_secs > 0 ){
				return $excel_time_secs;
			}
		}
		return ((integer) $excel_time - 25569) * 86400;
	}
	
	static function sendSms($mobile_no, $sms_text){
		echo env('DB_DATABASE');
		if( $mobile_no && $sms_text ){
			$username = env('AFRICAS_TALKING_USERNAME');
			$apikey = env('AFRICAS_TALKING_API_KEY');

			
			try {
				$from = 'MEGATECH'; // Specify your premium shortCode and keyword
				$gateway = new AfricasTalkingGateway($username, $apikey);
				$results = $gateway->sendMessage($mobile_no, $sms_text, $from);
				
				// For troubleshooting purposes				
				if( strtolower($results[0]->status) == 'success' ){
					return TRUE;
				}


			} catch ( AfricasTalkingGatewayException $e ) {
				// echo "Encountered an error while sending: ".$e->getMessage();
				dd("AfricasTalking Gateway Exception: ".$e->getMessage());
			} catch ( Exception $e ) {
				dd("Send SMS Exception: ".$e->getMessage());
			}
		}

		return FALSE;
	}

}

