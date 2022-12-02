<div class="alert hidden msg-box" ></div>


<form method="post" action="<?php echo e(route('agent.update', $agent->id)); ?>" >
	<?php echo csrf_field(); ?>

	<div class="row" >

		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Agent name</h5>
				<input type="text" class="form-control" name="agent_name" value="<?php echo e($agent->name); ?>" />
			</div>
		</div>

		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Ref number</h5>
				<input type="text" class="form-control" name="ref_no" value="<?php echo e($agent->ref_no); ?>" />
			</div>
		</div>

				
		<input type="hidden" name="agent_id" value="<?php echo e($agent->id); ?>" />
		
	</div>

</form>

<?php /**PATH /home1/megawatt/system-laravel/resources/views/admin/agents/edit.blade.php ENDPATH**/ ?>