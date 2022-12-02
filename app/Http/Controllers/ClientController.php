<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;

use App\MyHelpers\CommonHelpers;

use App\Models\Client;
use App\Models\BroadcastMessage;
use App\Models\Broadcast;
use App\Models\ClientBroadcastNotification;

class ClientController extends Controller
{
	
	protected $client;

	function __construct(Client $client){
		$this->client = $client;

		view()->share('current_menu', 'client');
	}
	
	function index(Request $request){
		$model = $this->client;
		$search = $request->input('mgwt_search');

		if( $search ){
			$model = $model->where('name', 'LIKE', '%' . $search .'%')
				->orWhere('phone_no', 'LIKE', '%' . $search .'%');
		}
		$clients = $model->orderBy('created_at', 'DESC')->paginate(20);
		
		if( $search ){
			$clients->appends(['mgwt_search' => $search]);
		}
		
		$view_data = [
			'clients' => $clients, 
			'search_context' => $search, 
		];
		return view('admin.clients.index', $view_data);
	}

	function view(Request $request, $id){
		$yearmonth = $request->input('yearmonth');
		$client = $this->client->find($id);

		$view_data['yearmonth'] = $yearmonth;

		if( $client ){
			$view_data['client'] = $client;

			$trackers_model = $client->trackers();
			if( $yearmonth ){
				$min_date = $yearmonth . '-01';
				$max_date = date('Y-m-d', strtotime($min_date . ' + 1 month'));

				$btwn = [strtotime($min_date), strtotime($max_date)];
				$trackers_model = $trackers_model->whereBetween('init_activation_time', $btwn);
			}

			$agent_trackers = $trackers_model->paginate(20);
			$view_data['client_trackers'] = $agent_trackers;
		}
		
		return view('admin.clients.view', $view_data);
	}
	
	function edit(Request $request, $id){
		if( $request->ajax() ){
			$client = $this->client->find($id);

			$view_data = [
				'client' => $client, 
			];
			return view('admin.clients.edit', $view_data);
		}else{
			return redirect()->route('clients');
		}
	}

	function update(Request $request, $id){
		if( $request->ajax() ){
			$post_id = $request->input('client_id');
			$msg = 'Request could not be completed';
			$status = 'fail';

			if( $post_id == $id ){
				$client = $this->client->where('phone_no', $request->input('phone_no'))
					->where('id', '<>', $id)
					->first();
					
				if( !$client ){
					$client = $this->client->find($id);
					if( $client ){
						$client->name = $request->input('client_name');
						$client->phone_no = $request->input('phone_no');
						$client->save();

						$msg = 'Client detail(s) updated successfully';
						$status = 'success';
					}else{
						$msg = 'The item you are attempting to update does not exist.';
					}
				}else{
					$msg = 'The phone number you provided is already in use.';
				}
			}
			
			return response()->json([
				'status' => $status, 
				'msg' => $msg
			]);
		}else{
			return redirect()->route('clients');
		}
	}

	function delete(Request $request, $id){
		if( $request->ajax() ){
			$post_id = $request->input('id');
			$msg = 'Request could not be completed';
			$status = 'fail';

			if( $post_id == $id ){
				$client = $this->client->find($id);
				if( $client ){
					if( $client->trackers()->count() ){
						$msg = 'This client\'s record cannot be deleted since it has tracker(s) information attached.';
					}else{
						$client->delete();

						$msg = 'Client deleted successfully';
						$status = 'success';
					}
				}else{
					$msg = 'The item you are attempting to delete does not exist.';
				}
			}
			
			return response()->json([
				'status' => $status, 
				'msg' => $msg
			]);
		}else{
			return redirect()->route('clients');
		}
	}

	function message(Request $request){
		if( $request->ajax() ){
			$messages = BroadcastMessage::get();
			$form_action = route('clients.message.save');

			$view_data = [
				'form_action' => $form_action, 
				'messages' => $messages, 
			];

			return view('includes.send-msg-form', $view_data);
		}else{
			return redirect()->route('clients');
		}
	}

	function sendMessage(Request $request){
		if( $request->ajax() ){
			$msg = 'Request could not be completed';
			$status = 'fail';

			$validator = Validator::make($request->all(), [
				'message' => 'required|numeric', 
				'send_to' => 'required|in:selected,all', 
				'ids' => 'required_if:send_to,selected', 
			], [
				'required_if' => 'To send to "Selected users", you have to select at least one row from the table'
			]);

			if( !$validator->fails() ){
				$message = BroadcastMessage::find( $request->input('message') );

				if( $message ){
					DB::beginTransaction();

					try{
						$broadcast = new Broadcast();
						$broadcast->message_id = $message->id;
						$broadcast->save();
						
						$model = $this->client;
						if( $request->input('send_to') == 'selected' ){
							parse_str($request->input('ids'), $ids);
							$model = $model->whereIn('id', $ids);
						}

						$time = time();
						$model->chunk(50, function($clients) use ($broadcast, $time){
							$insert_data = [];
							foreach($clients as $client){
								$insert_data[] = [
									'broadcast_id' => $broadcast->id, 
									'client_id' => $client->id, 
									'created_at' => date('Y-m-d H:i:s', $time), 
									'updated_at' => date('Y-m-d H:i:s', $time), 
								];
							}

							DB::table( (new ClientBroadcastNotification)->getTable() )
								->insert( $insert_data );
						});

						/*
						$model->chunk(20, function($clients) use ($find, $message){
							foreach($clients as $client){
								$find = ['#name', '#phone'];
								$replace = [$client->name, $client->phone_no];
								
								$sms_body = str_replace($find, $replace, $message->message);
								$sent = CommonHelpers::sendSms($client->phone_no, $sms_body);
							}
						});
						*/
						
						DB::commit();

						$msg = 'Message has been scheduled successfully.';
						$status = 'success';
					}catch(Exception $e){
						DB::rollback();

						$msg = 'Something went wrong.';
					}
				}else{
					$msg = 'The message you selected could not be found.';
				}
				
			}else{
				$errors = $validator->errors()->all();
				$msg = implode('<br>', $errors);
			}

			return response()->json([
				'status' => $status, 
				'msg' => $msg, 
			]);
		}else{
			return redirect()->route('clients');
		}
	}

}

