<div class="alert hidden msg-box" ></div>


<form method="post" action="<?php echo e(route('client.update', $client->id)); ?>" >
	<?php echo csrf_field(); ?>

	<div class="row" >

		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Client name</h5>
				<input type="text" class="form-control" name="client_name" value="<?php echo e($client->name); ?>" />
			</div>
		</div>

		<div class="col-sm-6" >
			<div class="form-group p-10 border-al border-rounded border-grey" >
				<h5 class="no-margin-top" >Phone number</h5>
				<input type="text" class="form-control" name="phone_no" value="<?php echo e($client->phone_no); ?>" />
			</div>
		</div>

				
		<input type="hidden" name="client_id" value="<?php echo e($client->id); ?>" />
		
	</div>

</form>

<?php /**PATH /home/megawatt/system-laravel/resources/views/admin/clients/edit.blade.php ENDPATH**/ ?>