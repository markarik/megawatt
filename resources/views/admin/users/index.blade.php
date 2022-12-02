@extends('layouts.main')


@section('page_title', 'Users')


@section('content')

	<div class="dashboard-admin" >


		<div class="page-header page-header-default" >
			<div class="page-header-content" >
				<div class="page-title" >
					
					<h3 class="text-uppercase" >Users</h3>
					
				</div>
			</div>
		</div>


		<div class="content" >
			<div class="panel panel-flat" >
				<div class="panel-body" >

					@include('includes.errors')
					@include('includes.msgs')

					<div class="table-responsive" >
						<table class="table table-condensed table-bordered" >
							<thead class="bg-grey" >
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Emai</th>
									<th>Date Created</th>
									<!-- 
									{{--
									<th>Actions</th>
									--}}
									-->
								</tr>
							</thead>
							<tbody>
								@if( $users->count() )

									@foreach( $users as $user )
										<tr>
											<td>{{ ($loop->index + 1) }}</td>
											<td>{{ $user->name }}</td>
											<td>{{ $user->email }}</td>
											<td>{{ $user->created_at }}</td>

											<!-- 
											{{--
											<td>
												<div class="nowrap" >
													<button type="button" role="button" class="btn btn-xs btn-theme view-record" data-id="{{ $user->id }}" data-url="{{ route('user.view', $user->id) }}" >View</button>
													<button type="button" role="button" class="btn btn-xs btn-theme edit-record" data-id="{{ $user->id }}" data-url="{{ route('user.edit', $user->id) }}" >Edit</button>
													<button type="button" role="button" class="btn btn-xs btn-theme delete-record" data-id="{{ $user->id }}" data-url="{{ route('user.edit', $user->id) }}" >Delete</button>
												</div>
											</td>
											--}}
											-->
										</tr>
									@endforeach

								@else
									<tr colspan="4" >
										<div class="alert alert-info" >No record retrieved.</div>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					
					<div class="mt-20 text-center" >
						{{ $users->links() }}
					</div>

				</div>
			</div>
		</div>


	</div>

@endsection

