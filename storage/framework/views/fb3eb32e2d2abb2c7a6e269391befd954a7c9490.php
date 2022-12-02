<div class="row" >

	<?php if( $message ): ?>

		<div class="col-sm-12" >
			<div class="form-group p-10 border-all border-rounded border-grey" >
				<p class="no-margin-top" >Label</p>
				<h5 class="no-margin-bottom" ><?php echo e($message->label); ?></h5>
			</div>
		</div>

		<div class="col-sm-12" >
			<div class="form-group p-10 border-all border-rounded border-grey" >
				<p class="no-margin-top" >Message</p>
				<h5 class="no-margin-bottom" ><?php echo e($message->message); ?></h5>
			</div>
		</div>

	<?php endif; ?>
	
</div>

<?php /**PATH /home1/megawatt/system-laravel/resources/views/admin/messages/view.blade.php ENDPATH**/ ?>