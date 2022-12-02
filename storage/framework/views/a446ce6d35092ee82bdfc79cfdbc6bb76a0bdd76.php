<?php if($errors->any()): ?>
	<div class="alert alert-danger">
		<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<span><?php echo $error; ?></span><br>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
<?php endif; ?>

<?php /**PATH /home1/megawatt/system-laravel/resources/views/includes/errors.blade.php ENDPATH**/ ?>