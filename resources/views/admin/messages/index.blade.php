@extends('layouts.main')


@section('page_title', 'Messages')


@section('content')

	<div class="dashboard-admin" >


		<div class="page-header page-header-default" >
			<div class="page-header-content" >
				<div class="page-title" >
					
					<h3 class="text-uppercase" >Messages</h3>
					
				</div>
			</div>
		</div>


		<div class="content" >
			<div class="panel panel-flat" >
				<div class="panel-body" >
					
					@include('includes.errors')
					@include('includes.msgs')

					<div class="form-group text-right" >
						<button type="button" role="button" class="btn btn-theme edit-record" data-url="{{ route('message.new') }}" data-target="#recordEditModal" data-toggle="modal" >New Message</button>
					</div>

					<div class="table-responsive" >
						<table class="table table-condensed table-bordered" >
							<thead class="bg-grey" >
								<tr>
									<th>#</th>
									<th>Label</th>
									<th>Message</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@if( $messages->count() )

									@foreach( $messages as $key => $message )
										<tr id="{{ 'row' . $message->id }}" >
											<td>{{ ($messages->firstItem() + $key) }}</td>
											<td>{{ $message->label }}</td>
											<td>{{ $message->message }}</td>
											<td>
												<div class="nowrap" >
													<button type="button" role="button" class="btn btn-xs btn-theme view-record" data-url="{{ route('message.view', $message->id) }}" data-target="#recordViewModal" data-toggle="modal" >View</button>
													<button type="button" role="button" class="btn btn-xs btn-theme edit-record" data-url="{{ route('message.edit', $message->id) }}" data-target="#recordEditModal" data-toggle="modal" >Edit</button>
													<button type="button" role="button" class="btn btn-xs btn-theme delete-record" data-id="{{ $message->id }}" data-url="{{ route('message.delete', $message->id) }}" data-target="#recordDeleteModal" data-toggle="modal" >Delete</button>
												</div>
											</td>
										</tr>
									@endforeach

								@else
									<tr>
										<td colspan="4" >
											<div class="alert alert-info" >No record retrieved.</div>
										</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					
					<div class="mt-20 text-center" >
						{{ $messages->links() }}
					</div>

				</div>
			</div>
		</div>


	</div>

	@include('includes.record-view-modal')
	@include('includes.record-edit-modal')
	@include('includes.record-delete-modal')

@endsection

