<div class="alert hidden msg-box" ></div>


<form method="post" action="<?php echo e($form_action); ?>" >
	<?php echo csrf_field(); ?>

	<div class="form-group" >
		<h5 class="no-margin-top" >Select message to send</h5>
		<select class="form-control" name="message" >
			<option value="" >-- Message --</option>
			<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option value="<?php echo e($message->id); ?>" ><?php echo e($message->label); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php /**PATH /home1/megawatt/system-laravel/resources/views/includes/send-msg-form.blade.php ENDPATH**/ ?>