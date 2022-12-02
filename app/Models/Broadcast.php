<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClientBroadcastNotification;

class Broadcast extends Model
{
	use HasFactory;

	protected $table = 'broadcasts';

	protected $fillable = [
		'message_id', 
	];
	
	function message(){
		return $this->belongsTo('App\Models\BroadcastMessage', 'message_id');
	}
	
	function clients(){
		return $this->belongsToMany('App\Models\Client', (new ClientBroadcastNotification)->getTable(), 'broadcast_id', 'client_id');
	}
	
}
