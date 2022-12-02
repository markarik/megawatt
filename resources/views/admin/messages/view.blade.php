<div class="row" >

	@if( $message )

		<div class="col-sm-12" >
			<div class="form-group p-10 border-all border-rounded border-grey" >
				<p class="no-margin-top" >Label</p>
				<h5 class="no-margin-bottom" >{{ $message->label }}</h5>
			</div>
		</div>

		<div class="col-sm-12" >
			<div class="form-group p-10 border-all border-rounded border-grey" >
				<p class="no-margin-top" >Message</p>
				<h5 class="no-margin-bottom" >{{ $message->message }}</h5>
			</div>
		</div>

	@endif
	
</div>

