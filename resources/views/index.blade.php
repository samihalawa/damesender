<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>Mail Sender Lambda SES</title>

	<link href="https://fonts.googleapis.com/css?family=Poppins:300,500,600" rel="stylesheet">
		<!--
		CSS
		============================================= -->
		<link rel="stylesheet" href="{{asset('css/linearicons.css')}}">
		<link rel="stylesheet" href="{{asset('css/owl.carousel.css')}}">
		<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
		<link rel="stylesheet" href="{{asset('css/nice-select.css')}}">
		<link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}">
		<link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
		<link rel="stylesheet" href="{{asset('css/main.css')}}">
		<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
	</head>
	<body>
		<div class="main-wrapper-first">
			<header>
				<div class="container">
					<div class="header-wrap">
						<div class="header-top d-flex justify-content-between align-items-center">
							<div class="logo">
								<a class="text-white" href="index.html">Mail Sender Lambda SES</a>
							</div>
							<!-- <div class="main-menubar d-flex align-items-center">
								<nav class="hide">
									<a href="index.html">Home</a>
									<a href="generic.html">Generic</a>
									<a href="elements.html">Elements</a>
								</nav>
								<div class="menu-bar"><span class="lnr lnr-menu"></span></div>
							</div> -->
						</div>
					</div>
				</div>
			</header>
			<div class="banner-area">
				<div class="container">
					<div class="row justify-content-center height align-items-center">
						<div class="col-lg-8">
							<div class="banner-content text-center">
								<h1 class="text-white text-uppercase">Mail Sender Lambda SES</h1>
							</div>
						</div>
					</div>
				</div>
			</div>

			
			<!-- Start Subscription Area -->
			<section class="subscription-area">
				<div class="container">
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
										<a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">2. Info</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">3. Template</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">4. Write your mail</a>
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
										<div class="form-group row">
											<label for="name" class="col-sm-4 col-form-label">From (name):</label>
											<div class="col-sm-8">
												<input class="form-control" type="text" placeholder="From (name)..." name="name" id="name">
											</div>
										</div>
										
										<div class="form-group row">
											<label for="email" class="col-sm-4 col-form-label">From (email):</label>
											<div class="col-sm-8">
												<input class="form-control" type="text" placeholder="From (email)..." name="email" id="email">
											</div>
										</div>

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
										
										<div class="form-group row">
											<label for="subject" class="col-sm-4 col-form-label">Subject:</label>
											<div class="col-sm-8">
												<input class="form-control" type="text" placeholder="Subject..." name="subject" id="subject">
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
											<label for="plain">Content:</label>
											<textarea class="form-control" name="plain" id="plain" rows="10"></textarea>
										</div>
										<div class="form-group mt-4 hidden" id="container-editor">
											<label for="content">Content:</label>
											<textarea name="content" id="editor"></textarea>
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
			</section>

			<!-- End Subscription Area -->
			<!-- Start Footer Widget Area -->
			<section class="footer-widget-area">
				<div class="container">
					<div class="row">
						<div class="col-md-4">
							<div class="single-widget d-flex flex-wrap justify-content-between">
								<div class="icon d-flex align-items-center justify-content-center">
									<span class="lnr lnr-pushpin"></span>
								</div>
								<div class="desc">
									<h6 class="title text-uppercase">Address</h6>
									<p>56/8, panthapath, west <br> dhanmondi, kalabagan, <br>Dhaka - 1205</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="single-widget d-flex flex-wrap justify-content-between">
								<div class="icon d-flex align-items-center justify-content-center">
									<span class="lnr lnr-earth"></span>
								</div>
								<div class="desc">
									<h6 class="title text-uppercase">Mail Address</h6>
									<div class="contact">
										<a href="mailto:info@dataarc.com">info@dataarc.com</a> <br>
										<a href="mailto:support@dataarc.com">support@dataarc.com</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="single-widget d-flex flex-wrap justify-content-between">
								<div class="icon d-flex align-items-center justify-content-center">
									<span class="lnr lnr-phone"></span>
								</div>
								<div class="desc">
									<h6 class="title text-uppercase">Phone Number</h6>
									<div class="contact">
										<a href="tel:1545">012 4562 982 3612</a> <br>
										<a href="tel:54512">012 6321 956 4587</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- End Footer Widget Area -->
			<!-- Start footer Area -->
			<footer>
				<div class="container">
					<div class="footer-content d-flex justify-content-between align-items-center flex-wrap">
						<div class="logo text-white">
							MAIL SENDER LAMBDA SES
						</div>
						<div class="copy-right-text">Copyright &copy; 2020  | Mail Sender Lambda SES</div>
						<div class="footer-social">
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-dribbble"></i></a>
							<a href="#"><i class="fa fa-behance"></i></a>
						</div>
					</div>
				</div>
			</footer>
			<!-- End footer Area -->
		</div>




		<script src="{{asset('js/vendor/jquery-2.2.4.min.js')}}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="{{asset('js/vendor/bootstrap.min.js')}}"></script>
		<script src="{{asset('js/jquery.ajaxchimp.min.js')}}"></script>
		<script src="{{asset('js/owl.carousel.min.js')}}"></script>
		<script src="{{asset('js/jquery.nice-select.min.js')}}"></script>
		<script src="{{asset('js/jquery.magnific-popup.min.js')}}"></script>
		<script src="{{asset('js/main.js')}}"></script>
	</body>
</html>
