<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BroadcastMessage;
use Validator;

class MessageController extends Controller
{

	protected $message;

	function __construct(BroadcastMessage $message){
		$this->message = $message;

		view()->share('current_menu', 'message');
	}
	
	function index(Request $request){
		$model = $this->message;
		$messages = $model->orderBy('created_at', 'DESC')->paginate(20);
		
		$view_data = [
			'messages' => $messages, 
		];
		return view('admin.messages.index', $view_data);
	}

	function view(Request $request, $id){
		$message = $this->message->find($id);

		$view_data = [
			'message' => $message, 
		];
		return view('admin.messages.view', $view_data);
	}

	function new(Request $request){
		if( $request->ajax() ){
			return view('admin.messages.edit');
		}else{
			return redirect()->route('messages');
		}
	}

	function edit(Request $request, $id){
		if( $request->ajax() ){
			$message = $this->message->find($id);

			$view_data = [
				'message' => $message, 
			];
			return view('admin.messages.edit', $view_data);
		}else{
			return redirect()->route('messages');
		}
	}

	function save(Request $request, $id = NULL){
		if( $request->ajax() ){
			$msg = 'Request could not be completed';
			$status = 'fail';

			$validator = Validator::make($request->all(), [
				'message_id' => 'numeric',
				'label' => 'required',
				'message' => 'required',
			]);

			if( !$validator->fails() ){
				$post_id = $request->input('message_id');

				if( ($post_id == $id) || (!$post_id && !$id) ){
					$message = $post_id ? BroadcastMessage::find($id) : new BroadcastMessage;
					if( $message ){
						$message->label = $request->input('label');
						$message->message = $request->input('message');
						$message->save();
						
						$msg = 'Message detail(s) ' . ($id?'updated':'saved') . ' successfully';
						$status = 'success';
					}else{
						$msg = 'The record you are trying to update could not be found';
					}
				}
			}else{
				$errors = $validator->errors()->all();
				$msg = implode('<br>', $errors);
			}
			
			return response()->json([
				'status' => $status, 
				'msg' => $msg
			]);
		}else{
			return redirect()->route('messages');
		}
	}

	function delete(Request $request, $id){
		if( $request->ajax() ){
			$post_id = $request->input('id');
			$msg = 'Request could not be completed';
			$status = 'fail';

			if( $post_id == $id ){
				$message = BroadcastMessage::find($id);
				if( $message ){
					$message->delete();

					$msg = 'Message deleted successfully';
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
			return redirect()->route('messages');
		}
	}
}

