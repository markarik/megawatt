<?php $__env->startSection('page_title', 'Clients'); ?>


<?php $__env->startSection('content'); ?>

	<div class="dashboard-admin" >


		<div class="page-header page-header-default" >
			<div class="page-header-content" >
				<div class="page-title" >
					
					<h3 class="text-uppercase" >Clients</h3>
					
				</div>
			</div>
		</div>


		<div class="content" >
			<div class="panel panel-flat" >
				<div class="panel-body" >

					<div class="form-group form-inline" >
						<form method="get" >
							<div class="input-group" >
								<input class="form-control" name="mgwt_search" placeholder="Search here" value="<?php echo e($search_context); ?>" >
								<div class="input-group-addon no-padding" >
									<button type="submit" class="btn btn-sm btn-theme" >
										<i class="fa fa-search" ></i>
									</button>
								</div>
							</div>
							<a class="btn btn-sm btn-theme" href="<?php echo e(route('clients')); ?>" >Clear</a>
						</form>
					</div>

					<div class="form-group" >
						<button type="button" class="btn btn-theme" id="sendMessageBtn" data-target_table="#clientsTable" data-target="#sendMsgModal" data-toggle="modal" data-url="<?php echo e(route('clients.message')); ?>" >Send message</button>
					</div>

					<?php echo $__env->make('includes.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<?php echo $__env->make('includes.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

					<div class="table-responsive" >
						<table class="table table-condensed table-bordered" id="clientsTable" >
							<thead class="bg-grey" >
								<tr>
									<th>#</th>
									<th><input type="checkbox" id="checkAll" /></th>
									<th>Name</th>
									<th>Phone No</th>
									<th class="text-center" >Total Trackers</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php if( $clients->count() ): ?>

									<?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr id="<?php echo e('row' . $client->id); ?>" >
											<td><?php echo e(($clients->firstItem() + $key)); ?></td>
											<td>
												<input type="checkbox" name="id[]" value="<?php echo e($client->id); ?>" />
											</td>
											<td><?php echo e($client->name); ?></td>
											<td><?php echo e($client->phone_no); ?></td>
											<td class="text-center" ><?php echo e($client->trackers->count()); ?></td>
											<td>
												<div class="nowrap" >
													<!-- <button type="button" role="button" class="btn btn-xs btn-theme view-record" data-url="<?php echo e(route('client.view', $client->id)); ?>" data-target="#recordViewModal" data-toggle="modal" >View</button> -->
													<a class="btn btn-xs btn-theme" href="<?php echo e(route('client.view', $client->id)); ?>"  >View</a>
													<button type="button" role="button" class="btn btn-xs btn-theme edit-record" data-url="<?php echo e(route('client.edit', $client->id)); ?>" data-target="#recordEditModal" data-toggle="modal" >Edit</button>
													<button type="button" role="button" class="btn btn-xs btn-theme delete-record" data-id="<?php echo e($client->id); ?>" data-url="<?php echo e(route('client.delete', $client->id)); ?>" data-target="#recordDeleteModal" data-toggle="modal" >Delete</button>
												</div>
											</td>
										</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

								<?php else: ?>
									<tr>
										<td colspan="6" >
											<div class="alert alert-info" >No record retrieved.</div>
										</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
					
					<div class="mt-20 text-center" >
						<?php echo e($clients->links()); ?>

					</div>

				</div>
			</div>
		</div>


	</div>

	<?php echo $__env->make('includes.record-view-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('includes.record-edit-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('includes.record-delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('includes.send-msg-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/megawatt/system-laravel/resources/views/admin/clients/index.blade.php ENDPATH**/ ?>