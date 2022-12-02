@extends('layouts.main')


@section('page_title', 'Home')


@section('content')

	<div class="dashboard-admin" >


		<div class="page-header page-header-default" >
			<div class="page-header-content" >
				<div class="page-title" >
					
					<h3 class="text-uppercase" >Home</h3>
					
				</div>
			</div>
		</div>


		<div class="content" >
			<div class="panel panel-flat" >
				<div class="panel-body" >

					@include('includes.errors')
					@include('includes.msgs')

					<form method="post" action="{{ route('upload-process') }}" enctype="multipart/form-data" >
						@csrf

						<div class="form-group" >

							<div class="input-group" >
								<label for="excelAttach" class="input-group-addon btn btn-theme" >
									<span>
										<i class="fa fa-file-excel-o" ></i> Attach Excel File
									</span>
								</label>
								<input type="file" class="form-control hidden" id="excelAttach" name="file_attachment" >
								<input type="text" class="form-control disabled attachment-name" disabled >
							</div>
							
						</div>

						<div class="form-group" >
							<button type="submit" role="button" class="btn btn-theme ml-5 mb-10" ><i class="fa fa-upload" ></i> Upload</button>
						</div>

					</form>
					

				</div>
			</div>
		</div>


	</div>

@endsection
