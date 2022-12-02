<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientBroadcastMessage extends Model
{
	use HasFactory;

	protected $table = 'client_broadcast_message';

	protected $fillable = [
		'client_id', 
		'message_id', 
	];
	
	function client(){
		return $this->belongsTo('App\Models\Client');
	}

	function message(){
		return $this->belongsTo('App\Models\BroadcastMessage', 'message_id');
	}
	
}
