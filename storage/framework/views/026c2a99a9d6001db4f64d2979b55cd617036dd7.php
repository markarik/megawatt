<div class="modal fade" id="sendMsgModal" tabindex="-1" role="dialog" aria-labelledby="sendMsgModalLabel" aria-hidden="true" data-backdrop="static" >
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="sendMsgModalLabel">Send message <span class="title-append" ></span></h4>
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
				<button type="button" class="btn btn-theme" id="sendMessage" >Send</button>
				<button type="button" class="btn btn-theme" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<?php /**PATH /home1/megawatt/system-laravel/resources/views/includes/send-msg-modal.blade.php ENDPATH**/ ?>