<div class="modal fade" id="recordEditModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" data-backdrop="static" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="editModalLabel">Edit <span class="title-append" ></span></h4>
				<hr class="no-margin-bottom" >
			</div>
			<div class="modal-body">
				<div class="loader-holder" >
					<img src="<?php echo e(url('assets/imgs/ajax-loader.gif')); ?>" title="Loader" class="img-responsive m-auto" />
				</div>
				<div class="form-holder" ></div>
			</div>
			<div class="modal-footer">
				<hr class="no-margin-top" >
				<button type="button" class="btn btn-theme save-changes" >Save</button>
				<button type="button" class="btn btn-theme" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<?php /**PATH /var/www/work/app/resources/views/includes/record-edit-modal.blade.php ENDPATH**/ ?>