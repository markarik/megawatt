<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackerExpiry extends Model
{
	use HasFactory;

	protected $table = 'trackers_expiries';

	protected $fillable = [
		'tracker_id', 
		'user_id', 
		'activation_time',
		'expiry_time', 
		'notification', 
	];
	protected $casts = [
        'expiry_time' => 'date:Y-m-d'
    ];
	function user(){
		return $this->belongsTo('App\Models\User');
	}

	function tracker(){
		return $this->belongsTo('App\Models\Tracker');
	}

}

