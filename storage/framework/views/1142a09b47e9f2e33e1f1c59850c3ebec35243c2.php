<?php $__env->startSection('page_title', 'Trackers'); ?>


<?php $__env->startSection('content'); ?>
	
	<div class="dashboard-admin" >


		<div class="page-header page-header-default" >
			<div class="page-header-content" >
				<div class="page-title" >
					
					<h3 class="text-uppercase" >
						<?php if( isset($active_trackers) && $active_trackers ): ?>
							Active 
						<?php elseif( isset($expired_trackers) && $expired_trackers ): ?>
							Expired 
						<?php endif; ?>
						Trackers
					</h3>
					
				</div>

				<ul class="nav nav-tabs">
					<li class="<?php echo e(isset($all_trackers) && $all_trackers?'active':''); ?>" ><a href="<?php echo e(route('trackers')); ?>" >All</a></li>
					<li class="<?php echo e(isset($active_trackers) && $active_trackers?'active':''); ?>" ><a href="<?php echo e(route('trackers.active')); ?>">Active</a></li>
					<li class="<?php echo e(isset($expired_trackers) && $expired_trackers?'active':''); ?>" ><a href="<?php echo e(route('trackers.expired')); ?>">Expired</a></li>
				</ul>

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

							<div id="datemonthyearpicker" class="input-group date" data-format="yyyy-mm" >
								<input class="form-control" name="yearmonth" placeholder="Month" value="<?php echo e($yearmonth); ?>" >
								<span class="input-group-addon btn btn-sm btn-theme" >
									<i class="fa fa-calendar" ></i>
								</span>
							</div>

							<a class="btn btn-sm btn-theme" href="<?php echo e(route('trackers')); ?>" >Clear</a>
						</form>
					</div>

					<?php echo $__env->make('includes.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
					<?php echo $__env->make('includes.msgs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

					<div class="table-responsive" >
						<table class="table table-condensed table-bordered" >
							<thead class="bg-grey" >
								<tr>
									<th>#</th>
									<th>Client</th>
									<th>Plate No.</th>
									<th>Tracker ID</th>
									<th>Sim Card</th>
									<th>Activated</th>
									<th>Expiry</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php if( $trackers->count() ): ?>
								
									<?php $__currentLoopData = $trackers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tracker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr id="<?php echo e('row' . $tracker->tracker_id); ?>" >
											<td><?php echo e(($trackers->firstItem() + $key)); ?></td>
											<td><?php echo e($tracker->client?$tracker->client->name:'--'); ?></td>
											<td><?php echo implode('&nbsp;', explode(' ', $tracker->mv_reg_no)); ?></td>
											<td><?php echo e($tracker->id_no); ?></td>
											<td><?php echo e($tracker->sim_card_no); ?></td>
											<td><?php echo e(date('d-m-Y', $tracker->init_activation_time)); ?></td>
											<td><?php echo e(date('d-m-Y', $tracker->expiry_time)); ?></td>
											<td>
												<div class="nowrap" >
													<button type="button" role="button" class="btn btn-xs btn-theme view-record" data-url="<?php echo e(route('tracker.view', $tracker->tracker_id)); ?>" data-target="#recordViewModal" data-toggle="modal" >View</button>
													<button type="button" role="button" class="btn btn-xs btn-theme edit-record" data-url="<?php echo e(route('tracker.edit', $tracker->tracker_id)); ?>" data-target="#recordEditModal" data-toggle="modal" >Edit</button>
													<button type="button" role="button" class="btn btn-xs btn-theme delete-record" data-id="<?php echo e($tracker->tracker_id); ?>" data-url="<?php echo e(route('tracker.delete', $tracker->tracker_id)); ?>" data-target="#recordDeleteModal" data-toggle="modal" >Delete</button>
												</div>
											</td>
										</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

								<?php else: ?>
									<tr>
										<td colspan="8" >
											<div class="alert alert-info" >No record retrieved.</div>
										</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
					

					<div class="mt-20 text-center" >
						<?php echo e($trackers->links()); ?>

					</div>


				</div>
			</div>
		</div>


	</div>

	<?php echo $__env->make('includes.record-view-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('includes.record-edit-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('includes.record-delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/megawatt/system-laravel/resources/views/admin/trackers/index.blade.php ENDPATH**/ ?>