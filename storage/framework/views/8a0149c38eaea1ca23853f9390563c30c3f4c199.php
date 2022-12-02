<?php $__env->startSection('page_title', 'Users'); ?>


<?php $__env->startSection('content'); ?>

	<div class="dashboard-admin" >


		<div class="page-header page-header-default" >
			<div class="page-header-content" >
				<div class="page-title" >
					
					<h3 class="text-uppercase" >Users</h3>
					
				</div>
			</div>
		</div>


		<div class="content" >
			<div class="panel panel-flat" >
				<div class="panel-body" >

					<?php echo $__env->make('includes.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<?php echo $__env->make('includes.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

					<div class="table-responsive" >
						<table class="table table-condensed table-bordered" >
							<thead class="bg-grey" >
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Emai</th>
									<th>Date Created</th>
									<!-- 
									
									-->
								</tr>
							</thead>
							<tbody>
								<?php if( $users->count() ): ?>

									<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr>
											<td><?php echo e(($loop->index + 1)); ?></td>
											<td><?php echo e($user->name); ?></td>
											<td><?php echo e($user->email); ?></td>
											<td><?php echo e($user->created_at); ?></td>

											<!-- 
											
											-->
										</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

								<?php else: ?>
									<tr colspan="4" >
										<div class="alert alert-info" >No record retrieved.</div>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
					
					<div class="mt-20 text-center" >
						<?php echo e($users->links()); ?>

					</div>

				</div>
			</div>
		</div>


	</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/megawatt/system-laravel/resources/views/admin/users/index.blade.php ENDPATH**/ ?>