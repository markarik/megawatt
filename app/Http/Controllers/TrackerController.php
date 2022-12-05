<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Models\Client;
use App\Models\Tracker;
use App\Models\TrackerExpiry;

class TrackerController extends Controller
{

	protected $tracker;
	
	function __construct(Tracker $tracker){
		$this->tracker = $tracker;
		
		view()->share('current_menu', 'tracker');
	}

	private function _filteredTrackersModel($request){
		$client_tbl = (new Client())->getTable();
		$expiry_tbl = (new TrackerExpiry())->getTable();
		$tracker_tbl = $this->tracker->getTable();
		
		$search = $request->input('mgwt_search');
		$yearmonth = $request->input('yearmonth');

		// Join with expiries table and filter with subquery 
		$model = $this->tracker->join($expiry_tbl, $tracker_tbl.'.id', '=', $expiry_tbl.'.tracker_id')
			->select($tracker_tbl.'.*', $expiry_tbl.'.*')
			->whereIn($expiry_tbl.'.id', function($query) use ($expiry_tbl){
				$query->select( DB::raw('MAX(' . $expiry_tbl . '.id)') )
					->from($expiry_tbl)
					->groupBy($expiry_tbl . '.tracker_id');
			});

		// Perform a search 
		if( $search ){
			$model = $model->join($client_tbl, $tracker_tbl.'.client_id', '=', $client_tbl.'.id')
				->where(function($query) use ($client_tbl, $tracker_tbl, $search){
					$query->where($client_tbl.'.name', 'LIKE', '%' . $search .'%')
						->orWhere($tracker_tbl.'.mv_reg_no', 'LIKE', '%' . $search .'%')
						->orWhere($tracker_tbl.'.id_no', 'LIKE', '%' . $search .'%')
						->orWhere($tracker_tbl.'.iccid', 'LIKE', '%' . $search .'%');
				});
		}
		if( $yearmonth ){
			$min_date = $yearmonth . '-01';
			$max_date = date('Y-m-d', strtotime($min_date . ' + 1 month'));

			$model = $model->whereBetween('init_activation_time', [strtotime($min_date), strtotime($max_date)]);
		}
		
		return $model;
	}
	
	function index(Request $request){
		$expiry_tbl = (new TrackerExpiry())->getTable();
		$tracker_tbl = $this->tracker->getTable();

		$model = $this->_filteredTrackersModel($request);

		$trackers = $model->orderBy($expiry_tbl.'.created_at', 'DESC')
			->orderBy($expiry_tbl.'.expiry_time', 'DESC')
			->paginate(20);

		$search = $request->input('mgwt_search');
		$yearmonth = $request->input('yearmonth');
		if( $search ){
			$trackers->appends(['mgwt_search' => $search]);
			$trackers->appends(['yearmonth' => $yearmonth]);
		}

		$view_data = [
			'trackers' => $trackers, 
			'search_context' => $search, 
			'yearmonth' => $yearmonth, 
			'all_trackers' => true, 
		];
		dd($view_data);
		return view('admin.trackers.index', $view_data);
	}

	function active(Request $request){
		$expiry_tbl = (new TrackerExpiry())->getTable();
		$tracker_tbl = $this->tracker->getTable();
		
		$model = $this->_filteredTrackersModel($request);
		$trackers = $model->where($expiry_tbl.'.expiry_time', '>', time())
			->orderBy($expiry_tbl.'.created_at', 'DESC')
			->orderBy($expiry_tbl.'.expiry_time', 'DESC')
			->paginate(20);
		
		$search = $request->input('mgwt_search');
		$yearmonth = $request->input('yearmonth');
		if( $search ){
			$trackers->appends(['mgwt_search' => $search]);
			$trackers->appends(['yearmonth' => $yearmonth]);
		}
		
		$view_data = [
			'trackers' => $trackers, 
			'search_context' => $search, 
			'yearmonth' => $yearmonth, 
			'active_trackers' => true, 
		];
		return view('admin.trackers.index', $view_data);
	}

	function expired(Request $request){
		$expiry_tbl = (new TrackerExpiry())->getTable();
		$tracker_tbl = $this->tracker->getTable();
		
		$model = $this->_filteredTrackersModel($request);
		$trackers = $model->where($expiry_tbl.'.expiry_time', '<', time())
			->orderBy($expiry_tbl.'.created_at', 'DESC')
			->orderBy($expiry_tbl.'.expiry_time', 'DESC')
			->paginate(20);
		
		$search = $request->input('mgwt_search');
		$yearmonth = $request->input('yearmonth');
		if( $search ){
			$trackers->appends(['mgwt_search' => $search]);
			$trackers->appends(['yearmonth' => $yearmonth]);
		}
		
		$view_data = [
			'trackers' => $trackers, 
			'search_context' => $search, 
			'yearmonth' => $yearmonth, 
			'expired_trackers' => true, 
		];
		return view('admin.trackers.index', $view_data);
	}

	function view(Request $request, $id){
		if( $request->ajax() ){
			$tracker_tbl = $this->tracker->getTable();
			$expiry_tbl = (new TrackerExpiry())->getTable();
			
			$tracker = $this->tracker->join($expiry_tbl, $tracker_tbl.'.id', '=', $expiry_tbl.'.tracker_id')
				->select($tracker_tbl.'.*', $expiry_tbl.'.*')
				->where($tracker_tbl.'.id', '=', $id)
				->orderBy($expiry_tbl.'.id', 'DESC')
				->first();
			
			$view_data = [
				'tracker' => $tracker, 
			];
			return view('admin.trackers.view', $view_data);
		}else{
			return redirect()->route('trackers');
		}
	}
	
	function edit(Request $request, $id){
		if( $request->ajax() ){
			$tracker_tbl = $this->tracker->getTable();
			$expiry_tbl = (new TrackerExpiry())->getTable();
			
			$tracker = $this->tracker->join($expiry_tbl, $tracker_tbl.'.id', '=', $expiry_tbl.'.tracker_id')
				->select($expiry_tbl.'.*', $tracker_tbl.'.*')
				->where($tracker_tbl.'.id', '=', $id)
				->orderBy($expiry_tbl.'.id', 'DESC')
				->first();
			
			$view_data = [
				'tracker' => $tracker, 
			];
			return view('admin.trackers.edit', $view_data);
		}else{
			return redirect()->route('trackers');
		}
	}

	function update(Request $request, $id){
		if( $request->ajax() ){
			$post_id = $request->input('tracker_id');
			$msg = 'Request could not be completed';
			$status = 'fail';

			if( $post_id == $id ){
				$tracker = Tracker::where('id', '<>', $id)
					->where(function($query) use ($request){
						$query->where('id_no', $request->input('id_no'))
							->orWhere('iccid', $request->input('iccid'));
					})
					->first();

				if( !$tracker ){
					$tracker = Tracker::find($id);
					
					if( $tracker ){
						DB::beginTransaction();

						try{
							$user = Auth::user();

							// $tracker->id_no = $request->input('id_no');
							// $tracker->iccid = $request->input('iccid');
							// $tracker->type = $request->input('type');
							// $tracker->mv_reg_no = $request->input('plate_no');
							$tracker->sim_card_no = $request->input('sim_card_no');
							$tracker->amount = $request->input('amount');
							$tracker->creation_time = strtotime($request->input('date_created'));
							// $tracker->activation_time = strtotime($request->input('date_activated'));
							// $tracker->expiry_time = strtotime($request->input('expiry_date'));
							$tracker->save();

							$tracker_expiry_data = [
								'user_id' => $user->id, 
								'tracker_id' => $tracker->id, 
								'activation_time' => strtotime($request->input('date_activated')), 
								'expiry_time' => strtotime($request->input('expiry_date')), 
							];
							$tracker_expiry = TrackerExpiry::create($tracker_expiry_data);

							$msg = 'Tracker detail(s) updated successfully';
							$status = 'success';

							DB::commit();
						}catch (\Exception $e){
							DB::rollback();
							
							$msg = $e->getMessage();
						}
					}else{
						$msg = 'The item you are attempting to update does not exist.';
					}
					
				}else{
					if( $tracker->id_no == $request->input('id_no') && $tracker->iccid == $request->input('iccid') ){
						$msg = 'The id number and ICCID you provided are already in use.';
					}elseif( $tracker->id_no == $request->input('id_no') ){
						$msg = 'The id number you provided is already in use.';
					}elseif( $tracker->id_no == $request->input('iccid') ){
						$msg = 'The ICCID you provided is already in use.';
					}
				}
			}
			
			return response()->json([
				'status' => $status, 
				'msg' => $msg
			]);
		}else{
			return redirect()->route('trackers');
		}
	}

	function delete(Request $request, $id){
		if( $request->ajax() ){
			$post_id = $request->input('id');
			$msg = 'Request could not be completed';
			$status = 'fail';
			
			if( $post_id == $id ){
				$tracker = Tracker::find($id);
				if( $tracker ){
					$tracker->delete();

					$msg = 'Tracker deleted successfully';
					$status = 'success';
				}else{
					$msg = 'The item you are attempting to delete does not exist.';
				}
			}
			
			return response()->json([
				'status' => $status, 
				'msg' => $msg
			]);
		}else{
			return redirect()->route('trackers');
		}
	}
}


