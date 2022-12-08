<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

use Maatwebsite\Excel\Facades\Excel;

use App\Models\Agent;
use App\Models\Client;
use App\Models\Tracker;

use App\MyHelpers\CommonHelpers;

class HomeController extends Controller {

	function __construct(){
		view()->share('current_menu', 'home');
	}

	/*
	function transferExpiries(){
		$expiry_model = new TrackerExpiry();
		$user = Auth::user();
		$notification_intervals = config('notification.intervals');
		$notification_intervals_arr = array_values($notification_intervals);

		DB::beginTransaction();

		try{
			TrackerExpiry::truncate();

			Tracker::chunk(50, function($trackers) use ($expiry_model, $user, $notification_intervals){
				$inserts = [];

				foreach ($trackers as $tracker){
					$notif_type = '';
					if( $tracker->expiry_time > strtotime('+2 week') && $tracker->expiry_time <= strtotime('+1 month') ){
						// $notif_type = $notification_intervals['pre_1month'];
					}elseif( $tracker->expiry_time > strtotime('+1 week') && $tracker->expiry_time <= strtotime('+2 week') ){
						$notif_type = $notification_intervals['pre_1month'];
					}elseif( $tracker->expiry_time > strtotime('+1 day') && $tracker->expiry_time <= strtotime('+1 week') ){
						$notif_type = $notification_intervals['pre_2weeks'];
					}elseif( $tracker->expiry_time > strtotime(date('d-m-Y 00:00:01')) && $tracker->expiry_time <= strtotime('+1 day') ){
						$notif_type = $notification_intervals['pre_1week'];
					}elseif( $tracker->expiry_time > strtotime(date('d-m-Y 08:00:00')) && $tracker->expiry_time <= strtotime('d-m-Y 23:59:59') ){
						$notif_type = $notification_intervals['pre_1day'];
					}elseif( $tracker->expiry_time > strtotime('-8 days') && $tracker->expiry_time <= strtotime('-1 week') ){
						$notif_type = $notification_intervals['d_day'];
					}elseif( $tracker->expiry_time < strtotime('-8 days') ){
						$notif_type = $notification_intervals['post_1week'];
					}

					$row = [
						'user_id' => $user->id, 
						'tracker_id' => $tracker->id, 
						'activation_time' => $tracker->activation_time, 
						'expiry_time' => $tracker->expiry_time, 
					];

					$row['notification_type'] = $notif_type ? $notif_type:null;
					
					$inserts[] = $row;
				}

				echo '<pre>';
				print_r($inserts);
				echo '</pre>';

				DB::table( $expiry_model->getTable() )->insert($inserts);
			});
			
			DB::commit();
		}catch(\Exception $e){
			DB::rollback();
			dd( $e->getMessage() );
		}

		dd('Expiries transfered');
	}
	*/

	function index(Request $request){
		return view('admin.home');
	}

	function processUpload(Request $request){
		$allowed_mimetypes = [
			'application/vnd.ms-excel', 
			'application/vnd.ms-excel.addin.macroenabled.12', 
			'application/vnd.ms-excel.sheet.binary.macroenabled.12', 
			'application/vnd.ms-excel.sheet.macroenabled.12', 
			'application/vnd.ms-excel.template.macroenabled.12', 
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 
			'application/vnd.openxmlformats-officedocument.spreadsheetml.template', 
		];

		$allowed_mimes = [
			'xls', 'xlm', 'xla', 'xlc', 'xlt', 'xlw', 'xlam', 'xlsb', 'xlsm', 'xltm', 'xlsx', 'xltx'
		];

		$validated_data = $request->validate([
			'file_attachment' => ['required', 'mimetypes:' . implode(',', $allowed_mimetypes), 'mimes:' . implode(',', $allowed_mimes)],
		]);

		$file = $request->file('file_attachment');
		
		$path = public_path('uploads/data/');
		$file_name = date('YmdHis') . '-' . implode('_', explode(' ', $file->getClientOriginalName()));
		$full_path = $path . $file_name;
		$file->move($path, $file_name);
		

		$error = '';
		DB::beginTransaction();

		try{
			$user = Auth::user();
			$file_data = Excel::toArray([], $full_path);
			// dd(count($file_data[0]));

			$row_count = 0;
			foreach ($file_data[0] as $row_no => $row) {
				if( $row[0] && $row[1] ){
					$row_count++;

					if( $row_count != 1 ){
						$tracker_id_no = strip_tags($row[4]);
						$tracker_iccid = strip_tags($row[6]);
						$client_name = strip_tags($row[1]);

						$existing_trackers = Tracker::where('id_no', $tracker_id_no)
							->where('iccid', $tracker_iccid)
							->count();
						if( !$existing_trackers ){
							$client_unique_data = [
								'phone_no' => strip_tags($row[2]), 
							];
							$client_data = [
								'name' => $client_name, 
							];
							$client = Client::firstOrCreate($client_unique_data, $client_data);

							

							
							$agent_unique_data = [
								'ref_no' => strip_tags($row[12]), 
							];
							$agent_data = [
								'name' => strip_tags($row[11]), 
							];
							$agent = Agent::updateOrCreate($agent_unique_data, $agent_data);

							$tracker_data = [
								'client_id' => $client->id, 
								'agent_id' => $agent->id, 
								'id_no' => $tracker_id_no, 
								'iccid' => $tracker_iccid, 
								'type' => strip_tags($row[7]), 
								'sim_card_no' => strip_tags($row[5]), 
								'mv_reg_no' => strip_tags(implode('', explode(' ', $row[3]))), 
								'amount' => strip_tags($row[13]), 
								'init_activation_time' => CommonHelpers::excelTimeToUnixTime($row[9]), 
								'creation_time' => CommonHelpers::excelTimeToUnixTime($row[8]), 
								'expiry_time' => CommonHelpers::excelTimeToUnixTime($row[10]), 
							];
							$tracker = Tracker::create($tracker_data);
							
							// $tracker_expiry_data = [
							// 	'user_id' => $user->id, 
							// 	'tracker_id' => $tracker->id, 
							// 	'activation_time' => CommonHelpers::excelTimeToUnixTime($row[9]), 
							// 	'expiry_time' => CommonHelpers::excelTimeToUnixTime($row[10]), 
							// ];
							// $tracker_expiry = TrackerExpiry::create($tracker_expiry_data);
						}else{
							$error = 'A tracker with ID No. "<strong>' . $tracker_id_no . '</strong>" and/or ICCID "<strong>' . $tracker_iccid . '</strong>", belonging to "<strong>' . $client_name . '</strong>" on row number ' . ($row_count - 1) . ' already exists.';
							break;
						}
					}
				}
			}
			
			if( !$error ){
				DB::commit();

				$msg = 'Upload processed successfully.';
				return redirect()->route('home')->with('msg', $msg);
			}
		}catch (\Exception $e){
			DB::rollback();
			
			$error = $e->getMessage();
		}
		
		return redirect()->back()->withErrors($error);
	}
	
}

