<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>DameSender</title>

  <!-- Bootstrap core CSS -->
  <link href="home/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="home/css/scrolling-nav.css" rel="stylesheet">
  <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link href="dashboard/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="dashboard/vendor/chartist/css/chartist.min.css">
	<link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <link href="dashboard/vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="dashboard/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="dashboard/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="dashboard/css/style.css" rel="stylesheet">
    
    <link rel="stylesheet" href="css/magnific-popup.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">DameSender</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#emails">Emails</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#sms">SMS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#plans">Plans</a>
		  </li>
		  @if(!Auth::user())
		  <li>
		  <button type="button" class="btn btn-rounded btn-primary"><a href="/login" style="color:white">Login</a></button>
		  </li>
		  <li><button type="button" class="btn btn-rounded btn-primary"><a href="/register" style="color:white">Register</a></button></li>
		  @else
		  <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="/email">Dashboard</a>
		  </li>
		  @endif 
		  
        </ul>
      </div>
    </div>
  </nav>

  <header class="bg-primary text-white">
    <div class="container text-center">
      <h1>DameSender Logo</h1>
      
    </div>
  </header>

  <section id="emails" class="bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
			<div class="card mb-3" style="max-width: 540px; border-radius:4px">
				<div class="row no-gutters">
					<div class="col-md-4">
						<img src="img/mail.png" class="card-img" style="padding-top:25%"alt="...">
					</div>
					<div class="col-md-8">
						<div class="card-body text-center">
							<h5 class="card-title">Email Subscription</h5>
							<h5 class="text-indigo">400/Month</h5>
							<p class="card-text"> Charged @2/1000 emails</p>
							<div class="col-auto">
								<label class="sr-only" for="inlineFormInputGroup"></label>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
									<div class="input-group-text" style="border-radius: 6px;">1000*</div>
									</div>
									<input type="number" class="form-control" id="quantityEmails" placeholder=""style="border-radius: 6px;" >
								</div>
								<br>
							</div>
							<a href="#" class="btn btn-primary" style="width: 100%;">Buy</a>
						</div>
					</div>
					
 				 </div>
			</div>
		</div>
		<div class="col">
			<div class="card text-white bg-dark mb-3 text-center" style="max-width: 18rem;border-radius:4px">
			<div class="card-body">
				<h5 class="text-indigo">Free Emails </h5>
				<p style="font-size:0.8rem; padding-top:2px;">Free Email           -</p>
				<p style="font-size:0.8rem;">Emails Remaining     <b>15485 (unbranded)</b> </p>
				<p class="card-text" style="font-size:0.8rem;">Prueba de descripcion de las cards, example test of descriptions Cards</p>
				<h5 class="text-indigo">Email Credits</h5>
				<p style="font-size:0.8rem; padding-top:2px;">Email Credits    <b>8896 Auto Rechargue</b> </p>
				<p class="card-text" style="font-size:0.8rem; padding-top:2px;" >Prueba de descripcion de las cards, example test of descriptions Cards</p>
			</div>
			</div>
		</div>
	  </div>
	 
    </div>
  </section>

  <section id="sms" class="bg-light">
  <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
			<div class="card mb-3" style="max-width: 540px; border-radius:4px">
				<div class="row no-gutters">
					<div class="col-md-4 text-center">
						<img src="img/sms.jpg" class="card-img text-center"style="padding-top:25%" alt="...">
					</div>
					<div class="col-md-8">
						<div class="card-body text-center">
							<h5 class="card-title">SMS Subscription</h5>
							<h5 class="text-indigo">400/Month</h5>
							<p class="card-text"> Charged @2/1000 SMS</p>
							<div class="col-auto">
								<label class="sr-only" for="inlineFormInputGroup"></label>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
									<div class="input-group-text" style="border-radius: 6px;">1000*</div>
									</div>
									<input type="number" class="form-control" id="quantitySMS" placeholder=""style="border-radius: 6px;" >
								</div>
								<br>
							</div>
							<a href="#" class="btn btn-primary" style="width: 100%;">Buy</a>
						</div>
					</div>
					
 				 </div>
			</div>
		</div>
		<div class="col">
			<div class="card text-white bg-dark mb-3 text-center" style="max-width: 18rem;border-radius:4px">
			
			<div class="card-body">
				<h5 class="text-indigo">Free SMS</h5>
				<p style="font-size:0.8rem; padding-top:2px;">Free SMS           -</p>
				<p style="font-size:0.8rem;">SMS Remaining     <b>15485 (unbranded)</b> </p>
				<p class="card-text" style="font-size:0.8rem;">Prueba de descripcion de las cards, example test of descriptions cards</p>
			</div>
			</div>
		</div>
	  </div>
    </div>
  </section>

  <section id="plans" >
  <div class="container">
      	<div class="row" >	
			<h2 style="margin-left:42%">Our Plans</h2>
			<br>
		</div>
  
	<div class="row">
		<div class="col">
		<div class="card text-center bg-light" style="width: 18rem;">
				<div class="card-body">
					<h5 class="card-title">Plan de prueba Silver</h5>
					<p class="card-text">2000 SMS + 1000 Emails $400/Month</p>
					<a href="#" class="btn btn-rounded btn-primary">Buy</a>
				</div>
			</div>
		</div>
			<div class="col">
			<div class="card text-center" style="width: 18rem;">
				<div class="card-body">
					<h5 class="card-title">Plan de prueba Gold</h5>
					<p class="card-text">5000 SMS + 3000 Emails $600/Month</p>
					<p class="card-text">Free 500 Emails Credits</p>
					<a href="#" class="btn btn-rounded btn-primary">Buy</a>
				</div>
			</div>
			</div>
			<div class="col">
			<div class="card text-center" style="width: 18rem;">
				<div class="card-body">
					<h5 class="card-title">Plan de prueba Gold</h5>
					<p class="card-text">5000 SMS + 3000 Emails $600/Month</p>
					<p class="card-text">Free 500 Emails Credits</p>
					<a href="#" class="btn btn-rounded btn-primary">Buy</a>
				</div>
        	</div>
			</div>
			
	</div>	
	</div>  
      
	
  </section>

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; DameSender</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
  <script src="home/vendor/jquery/jquery.min.js"></script>
  <script src="home/vendor/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="home/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  

  <!-- Plugin JavaScript -->
  <script src="home/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom JavaScript for this theme -->
  <script src="home/js/scrolling-nav.js"></script>

  <script src="js/vendor/jquery-2.2.4.min.js"></script>
    
    <script src="js/vendor/bootstrap.min.js"></script>   
    <script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/main.js'"></script>
    <script src="dashboard/vendor/global/global.min.js"></script>
	<script src="dashboard/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="dashboard/vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="dashboard/js/custom.min.js"></script>
	<script src="dashboard/js/deznav-init.js"></script>
    <script src="dashboard/vendor/owl-carousel/owl.carousel.js"></script>
    <script src="dashboard/vendor/global/global.min.js"></script>
	<script src="dashboard/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="dashboard/js/custom.min.js"></script>
	<script src="dashboard/js/deznav-init.js"></script>	
    <!-- Datatable -->
    <script src="dashboard/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="dashboard/js/plugins-init/datatables.init.js"></script>
	<!-- Chart piety plugin files -->
    <script src="dashboard/vendor/peity/jquery.peity.min.js"></script>
	<!-- Dashboard 1 -->
	<script src="dashboard/js/dashboard/dashboard-1.js"></script>

</body>

</html>
