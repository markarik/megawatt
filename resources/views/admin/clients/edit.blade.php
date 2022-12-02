<div class="alert hidden msg-box" ></div>


<form method="post" action="{{ route('client.update', $client->id) }}" >
	@csrf

	<div class="row" >

		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Client name</h5>
				<input type="text" class="form-control" name="client_name" value="{{ $client->name }}" />
			</div>
		</div>

		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Phone number</h5>
				<input type="text" class="form-control" name="phone_no" value="{{ $client->phone_no }}" />
			</div>
		</div>

				
		<input type="hidden" name="client_id" value="{{ $client->id }}" />
		
	</div>

</form>

