<!doctype html>
<html lang="en">

<head>
	<title>Admin</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="{{URL::asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/vendor/linearicons/style.css')}}">
	<link rel="stylesheet" href="{{URL::asset('assets/vendor/chartist/css/chartist-custom.css')}}">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="{{URL::asset('assets/css/main.css')}}">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
	
	<link rel="apple-touch-icon" href="{{URL::asset('image/title.png')}}">
	<link rel="icon" sizes="96x96" href="{{URL::asset('image/title.png')}}">
</head>

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a><img src="{{URL::asset('image/admin.png')}}" alt="Klorofil Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
					</ul>
				</div>
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i
							class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
					</ul>
				</div>
			</div>
		</nav>
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li>
							<a href="{{ url('home') }}">
								<i class='fa fa-home'></i>
								<span>Home</span>
							</a>
						</li>
						<li>
							<a href="{{ url('dataOrder') }}">
								<i class='fa fa-truck'></i>
								<span>Data Order</span>
							</a>
						</li>
						<li>
							<a href="{{ url('history') }}">
								<i class='fa fa-history'></i>
								<span>History Order</span>
							</a>
						</li>
						<li>
							<a href="{{ url('report') }}">
								<i class='fa fa-clipboard'></i>
								<span>Report User</span>
							</a>
						</li>
						<li>
							<a onclick="Logout()">
								<i class='fa fa-ban'></i>
								<span>Logout</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="main">
			<div class="main-content">
				<div class="panel">
					<div class="panel-body">
						@yield('content')
					</div>
				</div>
			</div>
			<div class="main-content">
				<div class="container-fluid">
					@yield('box')
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	<script type="text/javascript" src="{{URL::asset('assets/js/jquery-1.12.0.min.js')}}"></script>
	<script type="text/javascript" src="{{URL::asset('assets/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{URL::asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{URL::asset('assets/scripts/klorofil-common.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
	<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
	<script>
		function Logout() {
		firebase.auth().signOut()
            $.ajax({
                type: "get",
                url: "{{ url('logout') }}",
                data: {
                    _token: "{{csrf_token()}}"
                },
                success: function (response) {
					const Toast = Swal.fire({
							position: 'top-end',
							type: 'success',
							title: 'Sign out success',
							showConfirmButton: false,
							timer: 1500
        				})
						window.location.replace("{{url('loginadmin')}}");                   
                }
            });
	}
	</script>
</body>

</html>