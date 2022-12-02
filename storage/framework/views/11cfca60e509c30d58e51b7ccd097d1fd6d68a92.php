<?php $__env->startSection('page_title', 'Messages'); ?>


<?php $__env->startSection('content'); ?>

	<div class="dashboard-admin" >


		<div class="page-header page-header-default" >
			<div class="page-header-content" >
				<div class="page-title" >
					
					<h3 class="text-uppercase" >Messages</h3>
					
				</div>
			</div>
		</div>


		<div class="content" >
			<div class="panel panel-flat" >
				<div class="panel-body" >
					
					<?php echo $__env->make('includes.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<?php echo $__env->make('includes.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

					<div class="form-group text-right" >
						<button type="button" role="button" class="btn btn-theme edit-record" data-url="<?php echo e(route('message.new')); ?>" data-target="#recordEditModal" data-toggle="modal" >New Message</button>
					</div>

					<div class="table-responsive" >
						<table class="table table-condensed table-bordered" >
							<thead class="bg-grey" >
								<tr>
									<th>#</th>
									<th>Label</th>
									<th>Message</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php if( $messages->count() ): ?>

									<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr id="<?php echo e('row' . $message->id); ?>" >
											<td><?php echo e(($messages->firstItem() + $key)); ?></td>
											<td><?php echo e($message->label); ?></td>
											<td><?php echo e($message->message); ?></td>
											<td>
												<div class="nowrap" >
													<button type="button" role="button" class="btn btn-xs btn-theme view-record" data-url="<?php echo e(route('message.view', $message->id)); ?>" data-target="#recordViewModal" data-toggle="modal" >View</button>
													<button type="button" role="button" class="btn btn-xs btn-theme edit-record" data-url="<?php echo e(route('message.edit', $message->id)); ?>" data-target="#recordEditModal" data-toggle="modal" >Edit</button>
													<button type="button" role="button" class="btn btn-xs btn-theme delete-record" data-id="<?php echo e($message->id); ?>" data-url="<?php echo e(route('message.delete', $message->id)); ?>" data-target="#recordDeleteModal" data-toggle="modal" >Delete</button>
												</div>
											</td>
										</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

								<?php else: ?>
									<tr>
										<td colspan="4" >
											<div class="alert alert-info" >No record retrieved.</div>
										</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
					
					<div class="mt-20 text-center" >
						<?php echo e($messages->links()); ?>

					</div>

				</div>
			</div>
		</div>


	</div>

	<?php echo $__env->make('includes.record-view-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('includes.record-edit-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('includes.record-delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/megawatt/system-laravel/resources/views/admin/messages/index.blade.php ENDPATH**/ ?>