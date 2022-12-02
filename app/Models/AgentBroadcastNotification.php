<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentBroadcastNotification extends Model
{
	use HasFactory;

	protected $table = 'agent_broadcast_notifications';

	protected $fillable = [
		'broadcast_id', 
		'agent_id', 
		'status', 
	];
	
	function broadcast(){
		return $this->belongsTo('App\Models\Broadcast', 'broadcast_id');
	}

	function agent(){
		return $this->belongsTo('App\Models\Agent', 'agent_id');
	}
	
}
