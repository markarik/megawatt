<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClientBroadcastNotification;

class Client extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
		'email',
		'phone_no',
	];
	
	function trackers(){
		return $this->hasMany('App\Models\Tracker');
	}
	
	function broadcasts(){
		return $this->belongsToMany('App\Models\Broadcast', (new ClientBroadcastNotification)->getTable(), 'client_id', 'broadcast_id');
	}
}
