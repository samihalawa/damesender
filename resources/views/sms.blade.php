@extends('layouts.base')

@section('content')
{!! Form::open(['url'=>'email', 'method'=>'POST', 'autocomplete'=>'off', 'files' => true]) !!}
{!! Form::token() !!}
	<div class="row justify-content-center">
		<div class="col-lg-8">
			<div class="section-title text-center">
				<h3>Select a list of recipients, add content and send it</h3>
				<span class="text-uppercase">it's easy</span>
			</div>
		</div>
	</div>
	
	<div class="row justify-content-center">
		<div class="col-lg-10">
			<span id="recipient-error"></span>

			@if (session()->has('data'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					{{session()->get('data')}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			@endif

			@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
				@foreach($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			<ul class="nav nav-tabs" role="tablist" id="steps-tab">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">1. Recipients</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">2. Write your message</a>
				</li>
			</ul><!-- Tab panes -->

			<div class="tab-content">
				<div class="tab-pane active pt-4" id="tabs-1" role="tabpanel">
					<div class="form-group">
						<label for="recipients">Select a list of recipients (CSV):</label>
						<input type="file" class="form-control-file" name="recipients" id="recipients" required>
					</div>
				</div>
				<div class="tab-pane pt-4" id="tabs-2" role="tabpanel">
					<div class="form-group mt-4 container-plain">
						<label for="content">Content:</label>
						<textarea class="form-control" name="content" id="content" rows="10"></textarea>
					</div>
					<div class="d-flex justify-content-center">
						<button id="send-mail" class="btn btn-primary">Send</button>
					</div>
					</div>
			</div>

		</div>
	</div>
{!! Form::close() !!}
@endsection