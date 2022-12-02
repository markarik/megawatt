<!DOCTYPE html>

<html>

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="English" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php if (! empty(trim($__env->yieldContent('page_title')))): ?> <?php echo $__env->yieldContent('page_title'); ?> | <?php endif; ?> MegaWatt</title>
		<!-- <link rel="icon" type="image/icon" href="favicon.png" > -->
		<link rel="icon" type="image/icon" href="<?php echo e(url('assets/imgs/logo/megawatt-logo-transparent-sm.png')); ?>" >

		<?php $__env->startSection('styles'); ?>
			<?php echo $__env->make('includes.base-styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<link rel="stylesheet" type="text/css" href="<?php echo e(url('assets/css/style.css')); ?>" >
		<?php echo $__env->yieldSection(); ?>
	</head>
	
	<body screen_capture_injected="true" class="" >
		
		<?php echo $__env->make('includes.topnav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		
		<div class="page-container" >
			<div class="page-content" >
				
				<!-- Main sidebar -->
				<?php echo $__env->make('includes.sidenav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				
				<div class="content-wrapper content-body" >

					<?php echo $__env->yieldContent('content'); ?>
					
				</div>

			</div>
		</div>
		
		<?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	</body>

	<?php $__env->startSection('scripts'); ?>
		<?php echo $__env->make('includes.base-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->yieldSection(); ?>


</html>

<?php /**PATH /home/megawatt/system-laravel/resources/views/layouts/main.blade.php ENDPATH**/ ?>