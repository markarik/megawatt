<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
	use HasFactory;

	protected $fillable = [
		'client_id', 
		'agent_id', 
		'id_no',
		'iccid', 
		'type', 
		'sim_card_no', 
		'mv_reg_no', 
		'amount', 
		'init_activation_time', 
		'creation_time', 
		'expiry_time', 

	];

	
	/* Casting the expiry_time column to a date format. */
protected $casts = [
        'expiry_time' => 'date:Y-m-d',
		// 'init_activation_time' => 'date:Y-m-d',


		
    ];
	
	protected $expiry_model;
	
	function client(){
		return $this->belongsTo('App\Models\Client');
	}

	function agent(){
		return $this->belongsTo('App\Models\Agent');
	}

	function expiries(){
		return $this->hasMany('App\Models\TrackerExpiry');
	}

	private function getExpiryModel(){
		$expiry = $this->expiries()
			// ->orderBy('created_at', 'DESC')
			->orderBy('id', 'DESC')
			->first();

		$this->expiry_model = $expiry && $expiry->exists() ? $expiry:NULL;
	}

	function getActivationTime(){
		if( !$this->expiry_model ){
			$this->getExpiryModel();
		}

		return $this->expiry_model ? $this->expiry_model->activation_time:0;
	}

	function getExpiryTime(){
		if( !$this->expiry_model ){
			$this->getExpiryModel();
		}
		
		return $this->expiry_model ? $this->expiry_model->expiry_time:0;
	}

}

