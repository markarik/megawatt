<?php $__env->startSection('page_title', 'Login'); ?>


<?php $__env->startSection('content'); ?>
	<div class="content login-form" >
		<div class="panel panel-flat" >
			<div class="panel-heading text-center" >
				<img src="<?php echo e(url('assets/imgs/logo/megawatt-logo-transparent.png')); ?>" title="MegaWatt" class="img-responsive" />
			</div>

			<hr class="no-margin" >

			<div class="panel-body" >

				<?php echo $__env->make('includes.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

				<form method="post" action="<?php echo e(route('auth.login.submit')); ?>" >
					<?php echo csrf_field(); ?>

					<div class="form-group" >
						<label class="text-bold" for="email" >Email address</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo e(old('email')); ?>">
					</div>
					
					<div class="form-group" >
						<label class="text-bold" for="password" >Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
					</div>

					<div class="form-group" >
						<input type="submit" class="btn btn-theme btn-block" value="Login" >
					</div>

					<div class="form-group text-center" >
						Forgot passowrd? <a href="#" >Click here</a>
					</div>
				</form>
				

			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/megawatt/system-laravel/resources/views/auth/login-form.blade.php ENDPATH**/ ?>