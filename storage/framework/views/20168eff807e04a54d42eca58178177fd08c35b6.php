<div class="modal fade" id="recordDeleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true" data-backdrop="static" >
	<div class="modal-dialog modal-sm" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="deleteModalLabel">Confirm delete</h4>
				<hr class="no-margin-bottom" >
			</div>
			<div class="modal-body">
				<div class="loader-holder hidden" >
					<img src="<?php echo e(url('assets/imgs/ajax-loader.gif')); ?>" title="Loader" class="img-responsive m-auto" />
				</div>
				<div class="form-holder" >
					<div class="alert hidden msg-box" ></div>

					<form method="post" action="" >
						<?php echo csrf_field(); ?>
						<input type="hidden" name="id" value="" >
					</form>

					<h5 class="no-margin" >Are you sure you want to delete this item?</h5>

				</div>
			</div>
			<div class="modal-footer">
				<hr class="no-margin-top" >
				<button type="button" class="btn btn-theme confirm-delete" >Delete</button>
				<button type="button" class="btn btn-theme" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?php /**PATH /home/megawatt/system-laravel/resources/views/includes/record-delete-modal.blade.php ENDPATH**/ ?>