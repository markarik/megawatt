<?php if( Session::has('msg') && Session::get('msg') ): ?>
	<div class="alert alert-success">
		<div>
			<?php echo e(Session::get('msg')); ?>

		</div>
	</div>
<?php endif; ?>
<?php /**PATH /home/megawatt/system-laravel/resources/views/includes/msgs.blade.php ENDPATH**/ ?>