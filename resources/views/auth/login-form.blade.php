@extends('layouts.login')


@section('page_title', 'Login')


@section('content')
	<div class="content login-form" >
		<div class="panel panel-flat" >
			<div class="panel-heading text-center" >
				<img src="{{ url('assets/imgs/logo/megawatt-logo-transparent.png') }}" title="MegaWatt" class="img-responsive" />
			</div>

			<hr class="no-margin" >

			<div class="panel-body" >

				@include('includes.errors')

				<form method="post" action="{{ route('auth.login.submit') }}" >
					@csrf

					<div class="form-group" >
						<label class="text-bold" for="email" >Email address</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ old('email') }}">
					</div>
					
					<div class="form-group" >
						<label class="text-bold" for="password" >Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
					</div>

					<div class="form-group" >
						<input type="submit" class="btn btn-theme btn-block" value="Login" >
					</div>

					<div class="form-group text-center" >
						Forgot passowrd? <a href="#" >Click here</a>
					</div>
				</form>
				

			</div>
		</div>
	</div>
@endsection

