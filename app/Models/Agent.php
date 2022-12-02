<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AgentBroadcastNotification;

class Agent extends Model
{
	use HasFactory;

	protected $fillable = [
		'name', 
		'ref_no', 
	];
	
	function trackers(){
		return $this->hasMany('App\Models\Tracker');
	}
	
	function broadcasts(){
		return $this->belongsToMany('App\Models\Broadcast', (new AgentBroadcastNotification)->getTable(), 'agent_id', 'broadcast_id');
	}

}
