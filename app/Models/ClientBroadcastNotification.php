<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientBroadcastNotification extends Model
{
	use HasFactory;

	protected $table = 'client_broadcast_notifications';

	protected $fillable = [
		'broadcast_id', 
		'client_id', 
		'status', 
	];
	
	function broadcast(){
		return $this->belongsTo('App\Models\Broadcast', 'broadcast_id');
	}

	function client(){
		return $this->belongsTo('App\Models\Client', 'client_id');
	}
	
}
