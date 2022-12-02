<?php $__env->startSection('page_title', 'Agent view'); ?>


<?php $__env->startSection('content'); ?>

	<div class="dashboard-admin" >


		<div class="page-header page-header-default" >
			<div class="page-header-content" >
				<div class="page-title" >
					
					<h3 class="text-uppercase" >View agent</h3>
					
				</div>
			</div>
		</div>


		<div class="content" >
			<div class="panel panel-flat" >
				<div class="panel-body" >



					<div class="row" >
						<div class="col-sm-6" >
							<div class="form-group p-10 border-all border-rounded border-grey" >
								<p class="no-margin-top" >Agent name</p>
								<h5 class="no-margin-bottom" ><?php echo e($agent->name); ?></h5>
							</div>
						</div>

						<div class="col-sm-6" >
							<div class="form-group p-10 border-all border-rounded border-grey" >
								<p class="no-margin-top" >Ref number</p>
								<h5 class="no-margin-bottom" ><?php echo e($agent->ref_no); ?></h5>
							</div>
						</div>

						<div class="col-sm-12" >
							<div class="form-group " >
								<h5 class="no-margin-top" >Trackers</h5>

								<div class="form-group" >
									<form class="form-inline" method="GET" >
										<div id="datemonthyearpicker" class="input-group date" data-format="yyyy-mm" >
											<input class="form-control" name="yearmonth" placeholder="Month" value="<?php echo e($yearmonth); ?>" >
											<span class="input-group-addon btn btn-sm btn-theme" >
												<i class="fa fa-calendar" ></i>
											</span>
										</div>
										
										<a class="btn btn-sm btn-theme" href="<?php echo e(route('agent.view', $agent->id)); ?>" >Clear</a>
									</form>
								</div>

								<div class="table-responsive" >
									<table class="table table-condensed table-bordered" >
										<thead class="bg-grey-800" >
											<tr>
												<th>#</th>
												<th>Plate No.</th>
												<th>ID No.</th>
												<th>Sim card</th>
												<th>Activated</th>
												<th>Expiry</th>
											</tr>
										</thead>
										<tbody>
											<?php if( $agent_trackers && $agent_trackers->count() ): ?>
												<?php $__currentLoopData = $agent_trackers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tracker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<tr>
														<td><?php echo e(($loop->index + 1)); ?></td>
														<td><?php echo $tracker->mv_reg_no; ?></td>
														<td><?php echo e($tracker->id_no); ?></td>
														<td><?php echo e($tracker->sim_card_no); ?></td>
														<td><?php echo e(date('d-m-Y', $tracker->init_activation_time)); ?></td>
														<td><?php echo e(date('d-m-Y', $tracker->getExpiryTime())); ?></td>
													</tr>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php else: ?>
												<tr>
													<td colspan="6" >
														<div class="alert alert-info" >No trackers available.</div>
													</td>
												</tr>
											<?php endif; ?>
										</tbody>
									</table>
								</div>

								<?php if( $agent_trackers && $agent_trackers->count() ): ?>
									<div class="mt-20 text-center" >
										<?php echo e($agent_trackers->links()); ?>

									</div>
								<?php endif; ?>

							</div>
						</div>
					</div>



				</div>
			</div>
		</div>


	</div>

	<?php echo $__env->make('includes.record-view-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('includes.record-edit-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('includes.record-delete-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home1/megawatt/system-laravel/resources/views/admin/agents/view.blade.php ENDPATH**/ ?>