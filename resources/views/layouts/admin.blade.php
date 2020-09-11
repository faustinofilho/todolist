<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<!-- Mirrored from www.vasterad.com/themes/hireo/dashboard-manage-candidates.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Sep 2020 20:37:09 GMT -->
<head>

<!-- Basic Page Needs
================================================== -->
<title>Todolist</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- CSS
================================================== -->
<link rel="stylesheet" href="{{ url('/') }}/assets/css/style.css">
<link rel="stylesheet" href="{{ url('/') }}/assets/css/colors/blue.css">

</head>
<body class="gray">

<!-- Wrapper -->
<div id="wrapper">

<!-- Header Container
================================================== -->
<header id="header-container" class="fullwidth dashboard-header not-sticky">

	<!-- Header -->
	<div id="header">
		<div class="container">
			
			<!-- Left Side Content -->
			<div class="left-side">
				
				<!-- Logo -->
				<div id="logo">
					<a href=""><h1 style="color: red; font-size: 50px; margin-top: 25px"><strong>TodoList</strong></h1></a>
				</div>

			</div>
			<!-- Left Side Content / End -->


			<!-- Right Side Content / End -->
			<div class="right-side">


			</div>
			<!-- Right Side Content / End -->

		</div>
	</div>
	<!-- Header / End -->

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->


<!-- Dashboard Container -->
<div class="dashboard-container">

	<!-- Dashboard Sidebar
	================================================== -->
	<div class="dashboard-sidebar">
		<div class="dashboard-sidebar-inner" data-simplebar>
			<div class="dashboard-nav-container">

				<!-- Responsive Navigation Trigger -->
				<a href="#" class="dashboard-responsive-nav-trigger">
					<span class="hamburger hamburger--collapse" >
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</span>
					<span class="trigger-title">Painel</span>
				</a>
				
				<!-- Navigation -->
				<div class="dashboard-nav">
					<div class="dashboard-nav-inner">

						<ul data-submenu-title="Painel">
							<li><a href="{{ route('admin.projeto.index') }}"><i class="icon-material-outline-dashboard"></i> Projetcs</a></li>
							
							<li><a href="" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"><i class="icon-material-outline-power-settings-new"></i> sair</a></li>
						</ul>

						<form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
						
					</div>
				</div>
				<!-- Navigation / End -->

			</div>
		</div>
	</div>
	<!-- Dashboard Sidebar / End -->


	<!-- Dashboard Content
	================================================== -->
	<div class="dashboard-content-container" data-simplebar>
		<div class="dashboard-content-inner" >
			
			
			<!-- Row -->
			<div class="row">
				@yield('content')
			</div>
			<!-- Row / End -->

			<!-- Footer -->
			<div class="dashboard-footer-spacer"></div>
			<div class="small-footer margin-top-15">
				<div class="small-footer-copyrights">
					© {{ date('Y') }} <strong>TodoList</strong>
				</div>
				<ul class="footer-social-links">
					<li>
						<a href="https://www.linkedin.com/in/faustino-tavares-de-santana-filho-95825435/" title="LinkedIn" data-tippy-placement="top">
							<i class="icon-brand-linkedin-in"></i>
						</a>
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<!-- Footer / End -->

		</div>
	</div>
	<!-- Dashboard Content / End -->

</div>
<!-- Dashboard Container / End -->

</div>
<!-- Wrapper / End -->


<!-- Scripts
================================================== -->
<script src="{{ url('/') }}/assets/js/jquery-3.4.1.min.js"></script>
<script src="{{ url('/') }}/assets/js/jquery-migrate-3.1.0.min.html"></script>
<script src="{{ url('/') }}/assets/js/mmenu.min.js"></script>
<script src="{{ url('/') }}/assets/js/tippy.all.min.js"></script>
<script src="{{ url('/') }}/assets/js/simplebar.min.js"></script>
<script src="{{ url('/') }}/assets/js/bootstrap-slider.min.js"></script>
<script src="{{ url('/') }}/assets/js/bootstrap-select.min.js"></script>
<script src="{{ url('/') }}/assets/js/snackbar.js"></script>
<script src="{{ url('/') }}/assets/js/clipboard.min.js"></script>
<script src="{{ url('/') }}/assets/js/counterup.min.js"></script>
<script src="{{ url('/') }}/assets/js/magnific-popup.min.js"></script>
<script src="{{ url('/') }}/assets/js/slick.min.js"></script>
<script src="{{ url('/') }}/assets/js/custom.js"></script>

<script>
// Snackbar for user status switcher
$('#snackbar-user-status label').click(function() { 
	Snackbar.show({
		text: 'Your status has been changed!',
		pos: 'bottom-center',
		showAction: false,
		actionText: "Dismiss",
		duration: 3000,
		textColor: '#fff',
		backgroundColor: '#383838'
	}); 
}); 

$.ajaxSetup({
   headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   }
});
</script>

@yield('scripts')

</body>

</html>