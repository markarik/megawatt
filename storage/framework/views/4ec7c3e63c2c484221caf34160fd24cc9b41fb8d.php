<?php $__env->startSection('page_title', 'Home'); ?>


<?php $__env->startSection('content'); ?>

	<div class="dashboard-admin" >


		<div class="page-header page-header-default" >
			<div class="page-header-content" >
				<div class="page-title" >
					
					<h3 class="text-uppercase" >Home</h3>
					
				</div>
			</div>
		</div>


		<div class="content" >
			<div class="panel panel-flat" >
				<div class="panel-body" >

					<?php echo $__env->make('includes.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<?php echo $__env->make('includes.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

					<form method="post" action="<?php echo e(route('upload-process')); ?>" enctype="multipart/form-data" >
						<?php echo csrf_field(); ?>

						<div class="form-group" >

							<div class="input-group" >
								<label for="excelAttach" class="input-group-addon btn btn-theme" >
									<span>
										<i class="fa fa-file-excel-o" ></i> Attach Excel File
									</span>
								</label>
								<input type="file" class="form-control hidden" id="excelAttach" name="file_attachment" >
								<input type="text" class="form-control disabled attachment-name" disabled >
							</div>
							
						</div>

						<div class="form-group" >
							<button type="submit" role="button" class="btn btn-theme ml-5 mb-10" ><i class="fa fa-upload" ></i> Upload</button>
						</div>

					</form>
					

				</div>
			</div>
		</div>


	</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/work/app/resources/views/admin/home.blade.php ENDPATH**/ ?>