@extends('layouts.main')


@section('page_title', 'Clients')


@section('content')

	<div class="dashboard-admin" >


		<div class="page-header page-header-default" >
			<div class="page-header-content" >
				<div class="page-title" >
					
					<h3 class="text-uppercase" >Clients</h3>
					
				</div>
			</div>
		</div>


		<div class="content" >
			<div class="panel panel-flat" >
				<div class="panel-body" >

					<div class="form-group form-inline" >
						<form method="get" >
							<div class="input-group" >
								<input class="form-control" name="mgwt_search" placeholder="Search here" value="{{ $search_context }}" >
								<div class="input-group-addon no-padding" >
									<button type="submit" class="btn btn-sm btn-theme" >
										<i class="fa fa-search" ></i>
									</button>
								</div>
							</div>
							<a class="btn btn-sm btn-theme" href="{{ route('clients') }}" >Clear</a>
						</form>
					</div>

					<div class="form-group" >
						<button type="button" class="btn btn-theme" id="sendMessageBtn" data-target_table="#clientsTable" data-target="#sendMsgModal" data-toggle="modal" data-url="{{ route('clients.message') }}" >Send message</button>
					</div>

					@include('includes.errors')
					@include('includes.msgs')

					<div class="table-responsive" >
						<table class="table table-condensed table-bordered" id="clientsTable" >
							<thead class="bg-grey" >
								<tr>
									<th>#</th>
									<th><input type="checkbox" id="checkAll" /></th>
									<th>Name</th>
									<th>Phone No</th>
									<th class="text-center" >Total Trackers</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@if( $clients->count() )

									@foreach( $clients as $key => $client )
										<tr id="{{ 'row' . $client->id }}" >
											<td>{{ ($clients->firstItem() + $key) }}</td>
											<td>
												<input type="checkbox" name="id[]" value="{{ $client->id }}" />
											</td>
											<td>{{ $client->name }}</td>
											<td>{{ $client->phone_no }}</td>
											<td class="text-center" >{{ $client->trackers->count() }}</td>
											<td>
												<div class="nowrap" >
													<!-- <button type="button" role="button" class="btn btn-xs btn-theme view-record" data-url="{{ route('client.view', $client->id) }}" data-target="#recordViewModal" data-toggle="modal" >View</button> -->
													<a class="btn btn-xs btn-theme" href="{{ route('client.view', $client->id) }}"  >View</a>
													<button type="button" role="button" class="btn btn-xs btn-theme edit-record" data-url="{{ route('client.edit', $client->id) }}" data-target="#recordEditModal" data-toggle="modal" >Edit</button>
													<button type="button" role="button" class="btn btn-xs btn-theme delete-record" data-id="{{ $client->id }}" data-url="{{ route('client.delete', $client->id) }}" data-target="#recordDeleteModal" data-toggle="modal" >Delete</button>
												</div>
											</td>
										</tr>
									@endforeach

								@else
									<tr>
										<td colspan="6" >
											<div class="alert alert-info" >No record retrieved.</div>
										</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					
					<div class="mt-20 text-center" >
						{{ $clients->links() }}
					</div>

				</div>
			</div>
		</div>


	</div>

	@include('includes.record-view-modal')
	@include('includes.record-edit-modal')
	@include('includes.record-delete-modal')
	@include('includes.send-msg-modal')

@endsection

