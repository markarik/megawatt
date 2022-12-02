<!DOCTYPE html>

<html>

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Language" content="English" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>@hasSection('page_title') @yield('page_title') | @endif MegaWatt</title>
		<!-- <link rel="icon" type="image/icon" href="favicon.png" > -->
		<link rel="icon" type="image/icon" href="{{ url('assets/imgs/logo/megawatt-logo-transparent-sm.png') }}" >

		@section('styles')
			@include('includes.base-styles')

			<link rel="stylesheet" type="text/css" href="{{ url('assets/css/style.css') }}" >
		@show
	</head>
	
	<body screen_capture_injected="true" class="" >
		
		@include('includes.topnav')
		
		<div class="page-container" >
			<div class="page-content" >
				
				<!-- Main sidebar -->
				@include('includes.sidenav')
				
				<div class="content-wrapper content-body" >

					@yield('content')
					
				</div>

			</div>
		</div>
		
		@include('includes.footer')

	</body>

	@section('scripts')
		@include('includes.base-scripts')
	@show


</html>

