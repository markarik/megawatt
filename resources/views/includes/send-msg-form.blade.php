<div class="alert hidden msg-box" ></div>


<form method="post" action="{{ $form_action }}" >
	@csrf

	<div class="form-group" >
		<h5 class="no-margin-top" >Select message to send</h5>
		<select class="form-control" name="message" >
			<option value="" >-- Message --</option>
			@foreach($messages as $message)
				<option value="{{ $message->id }}" >{{ $message->label }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group" >
		<h5 class="no-margin-top" >Send to</h5>
		<label>
			<input type="radio" name="send_to" value="selected" >&nbsp;Selected users&nbsp;&nbsp;
		</label>
		<label>
			<input type="radio" name="send_to" value="all" >&nbsp;All users&nbsp;&nbsp;
		</label>
	</div>

	<input type="hidden" name="ids" value="" />

</form>

