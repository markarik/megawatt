<div class="alert hidden msg-box" ></div>


<form method="post" action="{{ route('message.save', isset($message) && $message?$message->id:'') }}" >
	
	@csrf

	<div class="form-group" >
		<h5 class="no-margin-top" >Message label</h5>
		<input type="text" class="form-control" name="label" value="{{ isset($message) && $message?$message->label:'' }}" />
	</div>

	<div class="form-group" >
		<h5 class="no-margin-top" >Message text</h5>
		<textarea class="form-control" name="message" >{{ isset($message) && $message?$message->message:'' }}</textarea>
	</div>

	@if( isset($message) && $message )
		<input type="hidden" name="message_id" value="{{ $message->id }}" />
	@endif

</form>

