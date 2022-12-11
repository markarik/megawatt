@extends('layouts.main')


@section('page_title', 'Trackers')


@section('content')
	
	<div class="dashboard-admin" >


		<div class="page-header page-header-default" >
			<div class="page-header-content" >
				<div class="page-title" >
					
					<h3 class="text-uppercase" >
						@if( isset($active_trackers) && $active_trackers )
							Active 
						@elseif( isset($expired_trackers) && $expired_trackers )
							Expired 

							@elseif (isset($inactive_trackers) && $inactive_trackers)
							In-Active
						@endif
						Trackers
					</h3>
					
				</div>

				<ul class="nav nav-tabs">
					<li class="{{ isset($all_trackers) && $all_trackers?'active':'' }}" ><a href="{{ route('trackers') }}" >All</a></li>
					<li class="{{ isset($active_trackers) && $active_trackers?'active':'' }}" ><a href="{{ route('trackers.active') }}">Active</a></li>
					<li class="{{ isset($expired_trackers) && $expired_trackers?'active':'' }}" ><a href="{{ route('trackers.expired') }}">Expired</a></li>
					<li class="{{ isset($inactive_trackers) && $inactive_trackers?'active':'' }}" ><a href="{{ route('trackers.inactive') }}">In-Active</a></li>

				</ul>

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

							<div id="datemonthyearpicker" class="input-group date" data-format="yyyy-mm" >
								<input class="form-control" name="yearmonth" placeholder="Month" value="{{ $yearmonth }}" >
								<span class="input-group-addon btn btn-sm btn-theme" >
									<i class="fa fa-calendar" ></i>
								</span>
							</div>

							<a class="btn btn-sm btn-theme" href="{{ route('trackers') }}" >Clear</a>
						</form>
					</div>

					@include('includes.errors')
					@include('includes.msgs')

					<div class="table-responsive" >
						<table class="table table-condensed table-bordered" >
							<thead class="bg-grey" >
								<tr>
									<th>#</th>
									<th>Client</th>
									<th>Plate No.</th>
									<th>Tracker ID</th>
									<th>Sim Card</th>
									<th>Activated</th>
									<th>Expiry</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@if( $trackers->count() )
								
									@foreach( $trackers as $key => $tracker )
										<tr id="{{ 'row' . $tracker->tracker_id }}" >
											<td>{{ ($trackers->firstItem() + $key) }}</td>
											<td>{{ $tracker->client?$tracker->client->name:'--' }}</td>
											<td>{!! implode('&nbsp;', explode(' ', $tracker->mv_reg_no)) !!}</td>
											<td>{{ $tracker->id_no }}</td>
											<td>{{ $tracker->sim_card_no }}</td>
											<td>{{ date('d-m-Y', $tracker->init_activation_time) }}</td>
											<td>{{ \Carbon\Carbon::parse($tracker->expiry_time)->format('d-m-Y')}}</td>
											<td>
												<div class="nowrap" >
													<button type="button" role="button" class="btn btn-xs btn-theme view-record" data-url="{{ route('tracker.view', $tracker->tracker_id) }}" data-target="#recordViewModal" data-toggle="modal" >View</button>
													<button type="button" role="button" class="btn btn-xs btn-theme edit-record" data-url="{{ route('tracker.edit', $tracker->tracker_id) }}" data-target="#recordEditModal" data-toggle="modal" >Edit</button>

											@if (isset($inactive_trackers) && $inactive_trackers)
											<button type="button" role="button" class="btn btn-xs btn-theme delete-record" data-id="{{ $tracker->tracker_id }}" data-url="{{ route('tracker.delete', $tracker->tracker_id) }}" data-target="#recordDeleteModal" data-toggle="modal" >Delete</button>
											@endif
												</div>
											</td>
										</tr>
									@endforeach

								@else
									<tr>
												<div class="alert alert-info" >No record retrieved.</div>
										</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					

					<div class="mt-20 text-center" >
						{{ $trackers->links() }}
					</div>


				</div>
			</div>
		</div>


	</div>

	@include('includes.record-view-modal')
	@include('includes.record-edit-modal')
	@include('includes.record-delete-modal')

@endsection

