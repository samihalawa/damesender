<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title')</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link href="{{ asset('dashboard/vendor/jqvmap/css/jqvmap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('dashboard/vendor/chartist/css/chartist.min.css') }}">
    <link href="{{ asset('dashboard/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">
	<link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <link href="{{ asset('dashboard/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="{{ asset('dashboard/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/css/style.css') }}" rel="stylesheet">

</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="index.html" class="brand-logo">
                <img class="logo-abbr" src="{{ asset('dashboard/images/logo.png') }}" alt="">
                <img class="logo-compact" src="{{ asset('dashboard/images/logo-text.png') }}" alt="">
                <img class="brand-title" src="{{ asset('dashboard/images/logo-text.png') }}" alt="">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		
		<!--**********************************
            Chat box start
        ***********************************-->
		
		<!--**********************************
            Chat box End
        ***********************************-->
		
		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                @yield('header')
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
									<div class="header-info">
										<span class="text-black">Hello, <strong>User Test</strong></span>
										<p class="fs-12 mb-0"></p>
									</div>
                                    <img src="{{ asset('dashboard/images/profile/pic1') }}.jpg" width="20" alt=""/>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{ url('/historial') }}" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2">Payment History </span>
                                    </a>
                                    <a href="{{ url('/count') }}" class="dropdown-item ai-icon">
                                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        <span class="ml-2">Free SMS & Emails </span>
                                    </a>
                                    <a href="./page-login.html" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">                 
                   <li class="{{ Request::is('/email') ? 'mm-active' : '' }}"><a href="{{ url('/email') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-promotion"></i>
							<span class="nav-text">Send Email</span>
						</a>
                    </li>
                    <li class="{{ Request::is('/sms') ? 'mm-active' : '' }}"><a href="{{ url('/sms') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-smartphone"></i>
							<span class="nav-text">Send SMS</span>
						</a>
                    </li>
                    <li class="{{ Request::is('/historial') ? 'mm-active' : '' }}"><a href="{{ url('/historial') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-calendar-5"></i>
							<span class="nav-text">Payment History</span>
						</a>
                    </li>
                    <li class="{{ Request::is('/count') ? 'mm-active' : '' }}"><a href="{{ url('/count') }}" class="ai-icon" aria-expanded="false">
							<i class="flaticon-381-gift"></i>
							<span class="nav-text">Free SMS & Emails</span>
						</a>
					</li>  
                </ul>
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
                @yield('content')
            </div>
        </div>
      


    </div>
    <script src="{{ asset('dashboard/vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('dashboard/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('dashboard/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/custom.min.js') }}"></script>
	<script src="{{ asset('dashboard/js/deznav-init.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/owl-carousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('dashboard/vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('dashboard/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/custom.min.js') }}"></script>
	<script src="{{ asset('dashboard/js/deznav-init.js') }}"></script>
	
    <!-- Datatable -->
    <script src="{{ asset('dashboard/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/plugins-init/datatables.init.js') }}"></script>
		
		
	
	<!-- Chart piety plugin files -->
    <script src="{{ asset('dashboard/vendor/peity/jquery.peity.min.js') }}"></script>
	
	
	<!-- Dashboard 1 -->
	<script src="{{ asset('dashboard/js/dashboard/dashboard-1.js') }}"></script>
	<script>
		function carouselReview(){
			/*  testimonial one function by = owl.carousel.js */
			/*  testimonial one function by = owl.carousel.js */
			jQuery('.owl-bank-wallet').owlCarousel({
				loop:true,
				autoplay:false,
				margin:0,
				nav:false,
				center:true,
				dots: false,
				navText: [''],
				responsive:{
					0:{
						items:2
					},
					
					480:{
						items:2
					},			
					
					991:{
						items:3
					},
					1200:{
						items:3
					},
					1600:{
						items:2
					}
				}
			})		
			
			jQuery('.testimonial-one').owlCarousel({
				loop:true,
				autoplay:true,
				margin:15,
				nav:true,
				dots: false,
				center:true,
				navText: ['', '<i class="las la-long-arrow-alt-right"></i>'],
				responsive:{
					0:{
						items:3
					},
					600:{
						items:5
					},	
					991:{
						items:8
					},			
					
					1200:{
						items:8
					},
					1600:{
						items:6
					}
				}
			})			
		}
		
		jQuery(window).on('load',function(){
			setTimeout(function(){
				carouselReview();
			}, 1000); 
		});
	</script>
	
</body>
</html>