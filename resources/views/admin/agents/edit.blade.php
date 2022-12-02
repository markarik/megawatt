<div class="alert hidden msg-box" ></div>


<form method="post" action="{{ route('agent.update', $agent->id) }}" >
	@csrf

	<div class="row" >

		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Agent name</h5>
				<input type="text" class="form-control" name="agent_name" value="{{ $agent->name }}" />
			</div>
		</div>

		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Ref number</h5>
				<input type="text" class="form-control" name="ref_no" value="{{ $agent->ref_no }}" />
			</div>
		</div>

				
		<input type="hidden" name="agent_id" value="{{ $agent->id }}" />
		
	</div>

</form>

