<div class="alert hidden msg-box" ></div>


<form method="post" action="<?php echo e(route('message.save', isset($message) && $message?$message->id:'')); ?>" >
	
	<?php echo csrf_field(); ?>

	<div class="form-group" >
		<h5 class="no-margin-top" >Message label</h5>
		<input type="text" class="form-control" name="label" value="<?php echo e(isset($message) && $message?$message->label:''); ?>" />
	</div>

	<div class="form-group" >
		<h5 class="no-margin-top" >Message text</h5>
		<textarea class="form-control" name="message" ><?php echo e(isset($message) && $message?$message->message:''); ?></textarea>
	</div>

	<?php if( isset($message) && $message ): ?>
		<input type="hidden" name="message_id" value="<?php echo e($message->id); ?>" />
	<?php endif; ?>

</form>

<?php /**PATH /home/megawatt/system-laravel/resources/views/admin/messages/edit.blade.php ENDPATH**/ ?>