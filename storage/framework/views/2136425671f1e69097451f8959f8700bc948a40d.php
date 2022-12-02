<div class="alert hidden msg-box" ></div>


<form method="post" action="<?php echo e(route('tracker.update', $tracker->id)); ?>" >
	<?php echo csrf_field(); ?>

	<div class="row" >

		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Plate number</h5>
				<input type="text" class="form-control disabled" disabled value="<?php echo e($tracker->mv_reg_no); ?>" />
			</div>
		</div>

		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Type</h5>
				<input type="text" class="form-control disabled" disabled value="<?php echo e($tracker->type); ?>" />
			</div>
		</div>

		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >ID number</h5>
				<input type="text" class="form-control disabled" disabled value="<?php echo e($tracker->id_no); ?>" />
			</div>
		</div>
		
		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >ICCID</h5>
				<input type="text" class="form-control disabled" disabled value="<?php echo e($tracker->iccid); ?>" />
			</div>
		</div>
		
		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Sim card number</h5>
				<input type="text" class="form-control" name="sim_card_no" value="<?php echo e($tracker->sim_card_no); ?>" />
			</div>
		</div>
		
		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Amount</h5>
				<input type="text" class="form-control" name="amount" value="<?php echo e($tracker->amount); ?>" />
			</div>
		</div>
		
		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Date created</h5>
				<input type="text" class="form-control" name="date_created" value="<?php echo e(date('d-m-Y', $tracker->creation_time)); ?>" />
			</div>
		</div>
		
		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Date activated</h5>
				<input type="text" class="form-control" name="date_activated" value="<?php echo e(date('d-m-Y', $tracker->activation_time)); ?>" />
			</div>
		</div>
		
		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Expiry date</h5>
				<input type="text" class="form-control" name="expiry_date" value="<?php echo e(date('d-m-Y', $tracker->expiry_time)); ?>" />
			</div>
		</div>
		
		<input type="hidden" name="tracker_id" value="<?php echo e($tracker->id); ?>" />
		
	</div>

</form>


<div class="alert hidden msg-box" ></div>

<?php /**PATH /home/megawatt/system-laravel/resources/views/admin/trackers/edit.blade.php ENDPATH**/ ?>