<div class="row" >

	@if( $tracker )

	<div class="col-sm-6" >
		<div class="form-group p-10 border-all border-rounded border-grey" >
			<p class="no-margin-top" >Client name</p>
			<h5 class="no-margin-bottom" >{{ $tracker->client()->exists()?$tracker->client->name:'' }}</h5>
		</div>
	</div>

	<div class="col-sm-6" >
		<div class="form-group p-10 border-all border-rounded border-grey" >
			<p class="no-margin-top" >Client phone number</p>
			<h5 class="no-margin-bottom" >{{ $tracker->client()->exists()?$tracker->client->phone_no:'' }}</h5>
		</div>
	</div>

	<div class="col-sm-6" >
		<div class="form-group p-10 border-all border-rounded border-grey" >
			<p class="no-margin-top" >Plate number</p>
			<h5 class="no-margin-bottom" >{{ $tracker->mv_reg_no }}</h5>
		</div>
	</div>

	<div class="col-sm-6" >
		<div class="form-group p-10 border-all border-rounded border-grey" >
			<p class="no-margin-top" >Type</p>
			<h5 class="no-margin-bottom" >{{ $tracker->type }}</h5>
		</div>
	</div>

	<div class="col-sm-6" >
		<div class="form-group p-10 border-all border-rounded border-grey" >
			<p class="no-margin-top" >ID number</p>
			<h5 class="no-margin-bottom" >{{ $tracker->id_no }}</h5>
		</div>
	</div>
	
	<div class="col-sm-6" >
		<div class="form-group p-10 border-all border-rounded border-grey" >
			<p class="no-margin-top" >ICCID</p>
			<h5 class="no-margin-bottom" >{{ $tracker->iccid }}</h5>
		</div>
	</div>
	
	<div class="col-sm-6" >
		<div class="form-group p-10 border-all border-rounded border-grey" >
			<p class="no-margin-top" >Sim card number</p>
			<h5 class="no-margin-bottom" >{{ $tracker->sim_card_no }}</h5>
		</div>
	</div>
	
	<div class="col-sm-6" >
		<div class="form-group p-10 border-all border-rounded border-grey" >
			<p class="no-margin-top" >Amount</p>
			<h5 class="no-margin-bottom" >{{ $tracker->amount }}</h5>
		</div>
	</div>
	
	<div class="col-sm-6" >
		<div class="form-group p-10 border-all border-rounded border-grey" >
			<p class="no-margin-top" >Date created</p>
			<h5 class="no-margin-bottom" >{{ date('d-M-Y', $tracker->creation_time) }}</h5>
		</div>
	</div>
	
	<div class="col-sm-6" >
		<div class="form-group p-10 border-all border-rounded border-grey" >
			<p class="no-margin-top" >Date activated</p>
			<h5 class="no-margin-bottom" >{{ date('d-M-Y', $tracker->activation_time) }}</h5>
		</div>
	</div>
	
	<div class="col-sm-6" >
		<div class="form-group p-10 border-all border-rounded border-grey" >
			<p class="no-margin-top" >Expiry date</p>
			<h5 class="no-margin-bottom" >{{ date('d-M-Y', $tracker->expiry_time) }}</h5>
		</div>
	</div>
	
	@if( $tracker->expiry_time < strtotime('+ 1 month') )
		<div class="col-sm-6" >
			<div class="form-group p-10 border-all border-rounded border-grey" >
				<p class="no-margin-top" >Expiry notification</p>
				<h5 class="no-margin-bottom" >{{ $tracker->notification_sent ? 'Sent':'Not sent' }}</h5>
			</div>
		</div>
	@endif
	
	<div class="col-sm-6" >
		<div class="form-group p-10 border-all border-rounded border-grey" >
			<p class="no-margin-top" >Agent</p>
			<h5 class="no-margin-bottom" >{{ $tracker->agent()->exists()?$tracker->agent->name:'' }}</h5>
		</div>
	</div>

	@else

		<div class="col-sm-12" >
			<div class="alert alert-info" >
				This record could not be retrieved.
			</div>
		</div>

	@endif
	
</div>

