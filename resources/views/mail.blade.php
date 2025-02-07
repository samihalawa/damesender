@extends('layouts.dashboard')

@section('header')
    Send Email
@endsection('header')

@section('content')
<div class="container">
	{!! Form::open(['url'=>'mail', 'method'=>'POST', 'autocomplete'=>'off', "enctype"=>"multipart/form-data"]) !!}
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
						<a class="nav-link step-tab active" data-toggle="tab" href="#tabs-1" role="tab">1. Recipients</a>
					</li>
					<li class="nav-item">
						<a class="nav-link step-tab" data-toggle="tab" href="#tabs-2" role="tab">2. Info</a>
					</li>
					<li class="nav-item">
						<a class="nav-link step-tab" data-toggle="tab" href="#tabs-3" role="tab">3. Template</a>
					</li>
					<li class="nav-item">
						<a class="nav-link step-tab" data-toggle="tab" href="#tabs-4" role="tab">4. Write your mail</a>
					</li>
				</ul><!-- Tab panes -->

				<div class="tab-content">
					<div class="tab-pane active pt-4" id="tabs-1" role="tabpanel">
						<div class="form-group">
							<label for="recipients">Select a list of recipients (CSV):</label>

							<select name="recipients" class="form-control" id="recipients">
									<option></option>
									@foreach($files_csv as $file)
			                        <option value="{{$file->id }}">{{$file->name}}<span style="font-weight:bold!important"> ({{General::countFiles($file->id)}}) </span></option>   
			                    	@endforeach
							</select>

						</div>
					</div>
					<div class="tab-pane pt-4" id="tabs-2" role="tabpanel">
						<div class="form-group row">
							<label for="name" class="col-sm-4 col-form-label">From (name):</label>
							<div class="col-sm-8">
								<input class="form-control" type="text" value="{{old('name')}}"  placeholder="From (name)..." name="name" id="name" required>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="email" class="col-sm-4 col-form-label">From (email):</label>
							<div class="col-sm-8">
								<select name="email" class="form-control">
									<option></option>
									@foreach($emails as $email)
			                        <option value="{{$email->email }}">{{$email->email}}</option>   

			                      
			                    @endforeach
								</select>
<!--
								<input class="form-control" type="email" placeholder="From (email)..." name="email" id="email" required>-->
							</div>
						</div>
<!--
						<div class="form-group row">
							<label for="cc" class="col-sm-4 col-form-label">CC:</label>
							<div class="col-sm-8">
								<input class="form-control" type="text" placeholder="CC..." name="cc" id="cc">
							</div>
						</div>

						<div class="form-group row">
							<label for="bcc" class="col-sm-4 col-form-label">BCC:</label>
							<div class="col-sm-8">
								<input class="form-control" type="text" placeholder="BCC..." name="bcc" id="bcc">
							</div>
						</div>
					-->
					<div class="form-group row">
						<label for="bcc" class="col-sm-4 col-form-label">Nombre Campaña</label>
						<div class="col-sm-8">
							<input class="form-control" type="text" value="{{old('campaing')}}" placeholder="No incluya caracteres especiales" name="campaing" id="campaing" required>
						</div>
					</div>

					<div class="form-group row">
						<label for="bcc" class="col-sm-4 col-form-label">
							Fecha de envio zona horaria Europa/ Madrid {{ date("Y-m-d H:i:s")}}	
						</label>
						<div class="col-sm-8">
							<input  class="form-control" value="{{old('datetime')}}"   type="datetime-local" name="datetime"> 
							<!--
							<input class="form-control" type="date" name="datetime" id="datetime" required>
							-->
						</div>
					</div>

					<div class="form-group row">
							<label for="subject" class="col-sm-4 col-form-label">Subject:</label>
							<div class="col-sm-8">
								<input class="form-control" type="text" value="{{old('subject')}}" placeholder="Subject..." name="subject" id="subject" required>
							</div>
					</div>

						<div class="form-group row">
							<label for="name" class="col-sm-4 col-form-label">Email Copia:</label>
							<div class="col-sm-8">
								<input class="form-control" type="email" value="{{old('copia')}}" placeholder="Email para recibir copia de la campaña" name="copia" id="copia" required>
							</div>
						</div>
					</div>
					<div class="tab-pane pt-4" id="tabs-3" role="tabpanel">
						<div class="form-group row">
							<label for="type" class="col-sm-4 col-form-label">Create mail using:</label>
							<div class="col-sm-8">
								
								<select name="type" id="type">
									<optgroup label="Select one">
										<option value="0">Rich Text Editor</option>
										<option value="1">Template</option>
									</optgroup>
								</select>
							</div>
						</div>

						<div class="container-plain">
							<div class="row mt-4 mb-4">
								<div class="col pt-4">
									<p class="h4 font-weight-light">Select one of the following responsive templates for email design:</p>
								</div>
							</div>
							@foreach(array_chunk($templates, 3) as $items)
								<div class="row mb-4">
									@foreach($items as $i)
									<div class="mb-4 col-lg-4 col-md-4 col-sm-12 colxs-12 d-flex align-items-stretch template-item">
										<div class="card card-item" style="width: 18rem;">
											<img class="card-img-top img-item" src="{{asset($i['dir'])}}" alt="Card image cap">
											<div class="card-body">
												<p class="card-text text-capitalize font-weight-bold filename">{{ $i['name'] }}</p>
											</div>
										</div>
									</div>
									@endforeach
								</div>
							@endforeach
						</div>
					</div>

					<div class="tab-pane pt-4" id="tabs-4" role="tabpanel">
						<div class="form-group mt-4 container-plain">
							<label for="plain">Content1:</label>
							<textarea class="form-control" name="plain" id="plain" rows="10"></textarea>
						</div>
						<div class="form-group mt-4 hidden" id="container-editor">
							<label for="content">Content2:</label>
							<!-- quite el editor id=editor porque transaforma el html -->
							<button id="preview-btn" type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#myModal">Preview</button>
						
							<textarea class="form-control" name="content" name="plain" id="plain" rows="10"></textarea>
						</div>
						<div class="d-flex justify-content-center">
							<button id="preview-btn" type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#myModal">Preview</button>
							<button id="send-mail" class="btn btn-primary">Send</button>
						</div>
					</div>
				</div>


					
				

				<!-- The Modal -->
				<div class="modal" id="myModal">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
						
							<!-- Modal Header -->
							<div class="modal-header">
								<h4 class="modal-title">Mail Template Viewer</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							
							<!-- Modal body -->
							<div class="modal-body" id="viewer"></div>
							
							<!-- Modal footer -->
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
							
						</div>
					</div>
				</div>

			</div>
		</div>
	{!! Form::close() !!}
</div>
@endsection

@push('js')
<script src="{{ asset('dashboard/js/template.js') }}"></script>
@endpush