@extends('layouts.main')


@section('page_title', 'Agent view')


@section('content')

	<div class="dashboard-admin" >


		<div class="page-header page-header-default" >
			<div class="page-header-content" >
				<div class="page-title" >
					
					<h3 class="text-uppercase" >View agent</h3>
					
				</div>
			</div>
		</div>


		<div class="content" >
			<div class="panel panel-flat" >
				<div class="panel-body" >



					<div class="row" >
						<div class="col-sm-6" >
							<div class="form-group p-10 border-all border-rounded border-grey" >
								<p class="no-margin-top" >Agent name</p>
								<h5 class="no-margin-bottom" >{{ $agent->name }}</h5>
							</div>
						</div>

						<div class="col-sm-6" >
							<div class="form-group p-10 border-all border-rounded border-grey" >
								<p class="no-margin-top" >Ref number</p>
								<h5 class="no-margin-bottom" >{{ $agent->ref_no }}</h5>
							</div>
						</div>

						<div class="col-sm-12" >
							<div class="form-group " >
								<h5 class="no-margin-top" >Trackers</h5>

								<div class="form-group" >
									<form class="form-inline" method="GET" >
										<div id="datemonthyearpicker" class="input-group date" data-format="yyyy-mm" >
											<input class="form-control" name="yearmonth" placeholder="Month" value="{{ $yearmonth }}" >
											<span class="input-group-addon btn btn-sm btn-theme" >
												<i class="fa fa-calendar" ></i>
											</span>
										</div>
										
										<a class="btn btn-sm btn-theme" href="{{ route('agent.view', $agent->id) }}" >Clear</a>
									</form>
								</div>

								<div class="table-responsive" >
									<table class="table table-condensed table-bordered" >
										<thead class="bg-grey-800" >
											<tr>
												<th>#</th>
												<th>Plate No.</th>
												<th>ID No.</th>
												<th>Sim card</th>
												<th>Activated</th>
												<th>Expiry</th>
											</tr>
										</thead>
										<tbody>
											@if( $agent_trackers && $agent_trackers->count() )
												@foreach( $agent_trackers as $tracker )
													<tr>
														<td>{{ ($loop->index + 1) }}</td>
														<td>{!! $tracker->mv_reg_no !!}</td>
														<td>{{ $tracker->id_no }}</td>
														<td>{{ $tracker->sim_card_no }}</td>
														<td>{{ date('d-m-Y', $tracker->init_activation_time) }}</td>
														<td>{{ date('d-m-Y', $tracker->getExpiryTime()) }}</td>
													</tr>
												@endforeach
											@else
												<tr>
													<td colspan="6" >
														<div class="alert alert-info" >No trackers available.</div>
													</td>
												</tr>
											@endif
										</tbody>
									</table>
								</div>

								@if( $agent_trackers && $agent_trackers->count() )
									<div class="mt-20 text-center" >
										{{ $agent_trackers->links() }}
									</div>
								@endif

							</div>
						</div>
					</div>



				</div>
			</div>
		</div>


	</div>

	@include('includes.record-view-modal')
	@include('includes.record-edit-modal')
	@include('includes.record-delete-modal')

@endsection

