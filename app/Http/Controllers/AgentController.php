<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;

use App\MyHelpers\CommonHelpers;

use App\Models\Agent;
use App\Models\BroadcastMessage;
use App\Models\Broadcast;
use App\Models\AgentBroadcastNotification;


class AgentController extends Controller
{

	protected $agent;

	function __construct(Agent $agent){
		$this->agent = $agent;

		view()->share('current_menu', 'agent');
	}
	
	function index(Request $request){
		$model = $this->agent;
		$search = $request->input('mgwt_search');

		if( $search ){
			$model = $model->where('name', 'LIKE', '%' . $search . '%')
				->orWhere('ref_no', 'LIKE', '%' . $search . '%');
		}
		$agents = $model->orderBy('created_at', 'DESC')->paginate(20);
		
		if( $search ){
			$agents->appends(['mgwt_search' => $search]);
		}
		
		$view_data = [
			'agents' => $agents, 
			'search_context' => $search, 
		];
		return view('admin.agents.index', $view_data);
	}

	function view(Request $request, $id){
		$yearmonth = $request->input('yearmonth');
		$agent = $this->agent->find($id);

		$view_data['yearmonth'] = $yearmonth;

		if( $agent ){
			$view_data['agent'] = $agent;

			$trackers_model = $agent->trackers();
			if( $yearmonth ){
				$min_date = $yearmonth . '-01';
				$max_date = date('Y-m-d', strtotime($min_date . ' + 1 month'));

				$btwn = [strtotime($min_date), strtotime($max_date)];
				$trackers_model = $trackers_model->whereBetween('init_activation_time', $btwn);
			}

			$agent_trackers = $trackers_model->paginate(20);
			$view_data['agent_trackers'] = $agent_trackers;
		}
		
		return view('admin.agents.view', $view_data);
	}

	function edit(Request $request, $id){
		if( $request->ajax() ){
			$agent = $this->agent->find($id);

			$view_data = [
				'agent' => $agent, 
			];
			return view('admin.agents.edit', $view_data);
		}else{
			return redirect()->route('agents');
		}
	}

	function update(Request $request, $id){
		if( $request->ajax() ){
			$post_id = $request->input('agent_id');
			$msg = 'Request could not be completed';
			$status = 'fail';
			
			if( $post_id == $id ){
				$agent = Agent::where('ref_no', $request->input('ref_no'))
					->where('id', '<>', $id)
					->first();

				if( !$agent ){
					$agent = Agent::find($id);
					if( $agent ){
						$agent->name = $request->input('agent_name');
						$agent->ref_no = $request->input('ref_no');
						$agent->save();

						$msg = 'Agent detail(s) updated successfully';
						$status = 'success';
					}else{
						$msg = 'The item you are attempting to update does not exist.';
					}
				}else{
					$msg = 'The ref number you provided is already in use.';
				}
			}
			
			return response()->json([
				'status' => $status, 
				'msg' => $msg
			]);
		}else{
			return redirect()->route('agents');
		}
	}

	function delete(Request $request, $id){
		if( $request->ajax() ){
			$post_id = $request->input('id');
			$msg = 'Request could not be completed';
			$status = 'fail';

			if( $post_id == $id ){
				$agent = Agent::find($id);
				if( $agent ){
					$agent->delete();

					$msg = 'Agent deleted successfully';
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
			return redirect()->route('agents');
		}
	}

	function message(Request $request){
		if( $request->ajax() ){
			$messages = BroadcastMessage::get();
			$form_action = route('agents.message.save');

			$view_data = [
				'form_action' => $form_action, 
				'messages' => $messages, 
			];

			return view('includes.send-msg-form', $view_data);
		}else{
			return redirect()->route('agents');
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
						
						$model = $this->agent;
						if( $request->input('send_to') == 'selected' ){
							parse_str($request->input('ids'), $ids);
							$model = $model->whereIn('id', $ids);
						}
						
						$time = time();
						$model->chunk(50, function($agents) use ($broadcast, $time){
							$insert_data = [];
							foreach($agents as $agent){
								$insert_data[] = [
									'broadcast_id' => $broadcast->id, 
									'agent_id' => $agent->id, 
									'created_at' => date('Y-m-d H:i:s', $time), 
									'updated_at' => date('Y-m-d H:i:s', $time), 
								];
							}

							DB::table( (new AgentBroadcastNotification)->getTable() )
								->insert( $insert_data );
						});

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
			return redirect()->route('agents');
		}
	}

}

