<!doctype html>
<html lang="en" dir="ltr">
	<head>

		<!-- META DATA -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Qlifefamilyclinic Admin Panel">
		<meta name="author" content="Qlifefamilyclinic Admin Panel">
		<meta name="keywords" content="Qlifefamilyclinic Admin Panel">

		<!-- FAVICON -->
		<link rel="shortcut icon" type="image/x-icon" href="{{ url('admin-assets/images/brand/favicon.ico') }}" />

		<!-- TITLE -->
		<title>@yield('title', 'Qlifefamilyclinic Admin Panel')</title>

		<!-- BOOTSTRAP CSS -->
		<link href="{{ url('admin-assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

		<!-- STYLE CSS -->
		<link href="{{ url('admin-assets/css/style.css') }}" rel="stylesheet"/>
		<link href="{{ url('admin-assets/css/skin-modes.css') }}" rel="stylesheet"/>
		<link href="{{ url('admin-assets/css/dark-style.css') }}" rel="stylesheet"/>

		<!-- SIDE-MENU CSS -->
		<link href="{{ url('admin-assets/css/closed-sidemenu.css') }}" rel="stylesheet">

		<!--PERFECT SCROLL CSS-->
		<link href="{{ url('admin-assets/plugins/p-scroll/perfect-scrollbar.css') }}" rel="stylesheet"/>

		<!-- CUSTOM SCROLL BAR CSS-->
		<link href="{{ url('admin-assets/plugins/scroll-bar/jquery.mCustomScrollbar.css') }}" rel="stylesheet"/>

		<!--- FONT-ICONS CSS -->
		<link href="{{ url('admin-assets/css/icons.css') }}" rel="stylesheet"/>

		<!-- SIDEBAR CSS -->
		<link href="{{ url('admin-assets/plugins/sidebar/sidebar.css') }}" rel="stylesheet">

		<!-- COLOR SKIN CSS -->
		<link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ url('admin-assets/colors/color1.css') }}" />
		<link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ url('admin-assets/colors/custom.css') }}" />


		@yield('css')
	</head>

	<body class="app sidebar-mini dark-mode">

		<!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="{{ url('admin-assets/images/loader.svg') }}" class="loader-img" alt="Loader">
		</div>
		<!-- /GLOBAL-LOADER -->

		<!-- PAGE -->
		<div class="page">
			<div class="page-main">

        @include('admin.layouts.sidebar')

        @include('admin.layouts.header')

				<!-- responsive-navbar -->
				<div class="mb-1 navbar navbar-expand-lg  responsive-navbar navbar-dark d-md-none bg-white">
					<div class="collapse navbar-collapse" id="navbarSupportedContent-4">
						<div class="d-flex order-lg-2 ml-auto">
							<div class="dropdown d-sm-flex">
								<a href="#" class="nav-link icon" data-toggle="dropdown">
									<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
								</a>
								<div class="dropdown-menu header-search dropdown-menu-left">
									<div class="input-group w-100 p-2">
										<input type="text" class="form-control " placeholder="Search....">
										<div class="input-group-append ">
											<button type="button" class="btn btn-primary ">
												<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
											</button>
										</div>
									</div>
								</div>
							</div><!-- SEARCH -->
							<div class="dropdown d-md-flex">
								<a class="nav-link icon full-screen-link nav-link-bg">
									<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" class="fullscreen-button"><path d="M0 0h24v24H0V0z" fill="none"/><circle cx="12" cy="12" opacity=".3" r="3"/><path d="M7 12c0 2.76 2.24 5 5 5s5-2.24 5-5-2.24-5-5-5-5 2.24-5 5zm8 0c0 1.65-1.35 3-3 3s-3-1.35-3-3 1.35-3 3-3 3 1.35 3 3zM3 19c0 1.1.9 2 2 2h4v-2H5v-4H3v4zM3 5v4h2V5h4V3H5c-1.1 0-2 .9-2 2zm18 0c0-1.1-.9-2-2-2h-4v2h4v4h2V5zm-2 14h-4v2h4c1.1 0 2-.9 2-2v-4h-2v4z"/></svg>
								</a>
							</div><!-- FULL-SCREEN -->



						</div>
					</div>
				</div>
        <!-- End responsive-navbar -->

        <!-- App-Header -->

        <!--app-content open-->
        <div class="app-content">
          <div class="side-app">
						@if ($errors->any())
							<div class="alert alert-danger mt-4" role="alert">
								{{ $errors->first() }}
							</div>
						@endif
						@if (session('message') != null)
							<div class="alert alert-success mt-4">
								{{ session('message') }}
							</div>
						@endif
            @yield('content')
          </div>
        </div>
				<!-- CONTAINER END -->
      </div>




			<!-- FOOTER -->
			<footer class="footer">
				<div class="container">
					<div class="row align-items-center flex-row-reverse">
						<div class="col-md-12 col-sm-12 text-center">
							Copyright © 2022 <a href="#">Qlife Booking App</a>. Designed by <a href="#"> Agunfon Interactivity </a> All rights reserved.
						</div>
					</div>
				</div>
			</footer>
			<!-- FOOTER END -->
		</div>

		<!-- BACK-TO-TOP -->
		<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

		<!-- JQUERY JS -->
		<script src="{{ url('admin-assets/js/jquery-3.4.1.min.js') }}"></script>

		<!-- BOOTSTRAP JS -->
		<script src="{{ url('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ url('admin-assets/plugins/bootstrap/js/popper.min.js') }}"></script>

		<!-- SPARKLINE JS-->
		<script src="{{ url('admin-assets/js/jquery.sparkline.min.js') }}"></script>

		<!-- CHART-CIRCLE JS-->
		<script src="{{ url('admin-assets/js/circle-progress.min.js') }}"></script>

		<!-- RATING STARJS -->
		<script src="{{ url('admin-assets/plugins/rating/jquery.rating-stars.js') }}"></script>

		<!-- EVA-ICONS JS -->
		<script src="{{ url('admin-assets/iconfonts/eva.min.js') }}"></script>

		<!-- INTERNAL CHARTJS CHART JS -->
		<script src="{{ url('admin-assets/plugins/chart/Chart.bundle.js') }}"></script>
		<script src="{{ url('admin-assets/plugins/chart/utils.js') }}"></script>

		<!-- INTERNAL PIETY CHART JS -->
		<script src="{{ url('admin-assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
		<script src="{{ url('admin-assets/plugins/peitychart/peitychart.init.js') }}"></script>

		<!-- SIDE-MENU JS-->
		<script src="{{ url('admin-assets/plugins/sidemenu/sidemenu.js') }}"></script>

		<!-- PERFECT SCROLL BAR js-->
		<script src="{{ url('admin-assets/plugins/p-scroll/perfect-scrollbar.min.js') }}"></script>
		<script src="{{ url('admin-assets/plugins/sidemenu/sidemenu-scroll.js') }}"></script>

		<!-- CUSTOM SCROLLBAR JS-->
		<script src="{{ url('admin-assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js') }}"></script>

		<!-- SIDEBAR JS -->
		<script src="{{ url('admin-assets/plugins/sidebar/sidebar.js') }}"></script>

		<!-- INTERNAL APEXCHART JS -->
		<script src="{{ url('admin-assets/js/apexcharts.js') }}"></script>

		<!--INTERNAL  INDEX JS -->
		<script src="{{ url('admin-assets/js/index1.js') }}"></script>

		<!-- CUSTOM JS -->
		<script src="{{ url('admin-assets/js/custom.js') }}"></script>

		{{-- DATATABLES --}}
		<script src="{{ url('admin-assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
		<script src="{{ url('admin-assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ url('admin-assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
		<script src="{{ url('admin-assets/plugins/datatable/fileexport/dataTables.buttons.min.js') }}"></script>
		<script src="{{ url('admin-assets/plugins/datatable/fileexport/buttons.bootstrap4.min.js') }}"></script>
        <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

		@yield('script')
	</body>
</html>
