$(document).ready(function(){

	eventHandlers();

	initializeDatepickers();

});


function eventHandlers(){

	// Ajax complete event
	$(document).on('ajaxComplete', function(e, request, settings){
		var resp_txt = request.responseText;

		if( settings.type && typeof resp_txt === 'string' ){
			var resp_json = {};

			try{
				resp_json = JSON.parse(resp_txt);
			}catch(exception){
				// console.log( exception );
			}
			
			if( !resp_json.length ){
				// var resp_dom = $('<div></div>').append( resp_txt.trim() );
				initializeDatepickers();
			}
		}
	});
	

	// Change date event 
	$('body').on('changeDate', '*[id^="datetimepicker"], *[id^="datepicker"], *[id^="datemonthyearpicker"], *[id^="datedaymonthpicker"]', function (e) {
		var _this = $(this), 
			input = _this.is('input')?_this:_this.find('input'), 
			date = input.val();
			
		_this.closest('form').submit();
	});


	// Excel attachment event 
	$('form').on('change', 'input#excelAttach', function(e){
		var name = '';
		if( this.files.length ){
			$(this).closest('.input-group').find('.attachment-name').val(this.files[0].name);
		}
	});

	// Modals show event
	$('.modal#recordViewModal, .modal#recordEditModal, .modal#sendMsgModal').on('show.bs.modal', function(e){
		var modal = $(this), 
			loader = modal.find('.loader-holder'), 
			form_holder = modal.find('.form-holder'), 
			invoker = $(e.relatedTarget), 
			url = invoker.data('url');

		loader.removeClass('hidden');
		form_holder.empty();
		modal.removeClass('submit-complete');

		var callback = function(resp){
			modal.find('.form-holder').html(resp);
			loader.addClass('hidden');

			if( invoker[0].id == 'sendMessageBtn' ){
				var table = $( invoker.data('target_table') );
				if( table.length ){
					table.wrap('<form>');
					var data = table.closest('form').serialize();
					table.unwrap('form');

					modal.find('input[name="ids"]').val( data );
				}
			}
		}

		$.get(url, callback);
	});


	$('.modal#recordEditModal').on('click', '.save-changes', function(e){
		modalFormSubmit( $(this) );
	});

	$('.modal#recordDeleteModal').on('click', '.confirm-delete', function(e){
		modalFormSubmit( $(this) );
	});

	$('.modal#sendMsgModal').on('click', '#sendMessage', function(e){
		modalFormSubmit( $(this) );
	});

	$('.modal#recordEditModal, .modal#recordDeleteModal').on('hide.bs.modal', function(e){
		// if( $(this).find('.alert').hasClass('hidden') ){
		if( $(this).hasClass('submit-complete') ){
			window.location.reload();
		}
	});


	$('.modal#recordDeleteModal').on('show.bs.modal', function(e){
		var modal = $(this), 
			form = modal.find('form'), 
			msg_box = modal.find('.msg-box'), 
			invoker = $(e.relatedTarget), 
			url = invoker.data('url'), 
			id = invoker.data('id');

		msg_box.empty().removeClass('alert-danger alert-success').addClass('hidden');
		form.find('input[name="id"]').val(id);
		form.prop('action', url);
		modal.removeClass('submit-complete');
	});
	
	$('body').on('change input', 'table #checkAll', function(){
		$(this).closest('table').find('input[type="checkbox"]').prop('checked', $(this).is(':checked'));
	});
	
}


function modalFormSubmit( submit_btn ){
	var modal = submit_btn.closest('.modal'), 
		form_holder = modal.find('.form-holder'), 
		form = modal.find('form'), 
		url = form.prop('action'), 
		msg_box = modal.find('.msg-box'), 
		loader = modal.find('.loader-holder');

	msg_box.empty().removeClass('alert-danger alert-success').addClass('hidden');
	loader.removeClass('hidden');

	var callback = function(resp){
		loader.addClass('hidden');

		msg_box.html( resp.msg ).removeClass('hidden');
		if( resp.status == 'success' ){
			msg_box.addClass('alert-success');
			form.remove();
			
			if( submit_btn.hasClass('confirm-delete') ){
				var id = form.find('input[name="id"]').val();
				$('.content').find('.panel-body table tr#row' + id).remove();
			}

			if( submit_btn.hasClass('confirm-delete') || submit_btn.hasClass('save-changes') ){
				submit_btn.remove();
			}
			
			modal.addClass('submit-complete');
		}else{
			msg_box.addClass('alert-danger');
		}
	}

	$.post(url, form.serializeArray(), callback, 'json');
}


function initializeDatepickers(){
	var date_picker_elems = $('body').find('*[id^="datetimepicker"], *[id^="datepicker"], *[id^="datemonthyearpicker"], *[id^="datedaymonthpicker"]');
	
	if( date_picker_elems.length ){
		date_picker_elems.each(function(){
			var input = $(this).is(':input') ? $(this) : $(this).find('input');
			input.data('init_val', $(this).find('input').val());
			input.prop( 'readonly', !input.hasClass('editable') );
			
			var position = 'bottom-left';
			var passed_position = $(this).data('dp_position');
			if( typeof passed_position != 'undefined' && passed_position ){
				position = passed_position.trim();
				if( position.indexOf('-') == -1 ){
					position += '-left';
				}
			}

			var start_date = '';
			var passed_start_date = $(this).data('startdate');
			if( typeof passed_start_date != 'undefined' && passed_start_date ){
				start_date = passed_start_date.trim();
			}

			var min_view = 2;
			var start_view = 2;
			var format = 'dd-mm-yyyy'; // 'yyyy-mm-dd';
			var passed_format = $(this).data('format');
			var initial_date = $(this).data('initial_date');
			
			if( $(this).prop('id').indexOf('datetimepicker') == 0 ){
				format = 'dd-mm-yyyy hh:ii'; // 'yyyy-mm-dd hh:ii';
				min_view = 0;
			}else if( $(this).prop('id').indexOf('datemonthyearpicker') == 0 ){
				// format = '01-mm-yyyy'; // 'yyyy-mm-01';
				format = (typeof passed_format != 'undefined' && passed_format)?passed_format:'01-mm-yyyy';
				
				min_view = 3;
				start_view = 3;
			}else if( $(this).prop('id').indexOf('datedaymonthpicker') == 0 ){
				var date = new Date();
				var year = date.getFullYear();
				format = (typeof passed_format != 'undefined' && passed_format)?passed_format:'mm-dd';
				format = year + '-'+format;
				
				min_view = 2;
				start_view = 3;
			}else if( typeof passed_format != 'undefined' && passed_format ){
				format = passed_format;
			}

			var datetimepicker_config = {
				minView: min_view,
				startView: start_view,
				format: format,
				todayHighlight: true,
				autoclose: true,
				pickerPosition: position, 
				bootcssVer: 3,
			}
			
			if( typeof initial_date != 'undefined' && initial_date ){
				datetimepicker_config.initialDate = initial_date;
			}
			if( start_date.length ){
				datetimepicker_config.startDate = start_date;
			}
			
			$(this).datetimepicker( datetimepicker_config ).on('hide show', function(event) {
				event.preventDefault();
				event.stopPropagation();
			});
		});
		
		
		date_picker_elems.on('focus', 'input', function(){
			$(this).closest( date_picker_elems ).find('.add-on').click();
		});
	}
	
}

