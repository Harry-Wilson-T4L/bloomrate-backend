<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<!--Meta data-->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>

		<!--Favicon -->
		<link rel="icon" href="{{ asset('assets/images/brand/logo.png') }}" type="image/x-icon"/>
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/brand/logo.png') }}" />

		<!-- Title -->
        <title>Login - {{ config('app.name') }}</title>

		<!-- Dashboard css -->
		<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

		<!-- C3 Charts css -->
		<link href="{{ asset('assets/plugins/charts-c3/c3-chart.css') }}" rel="stylesheet" />

		<!-- Custom scroll bar css-->
		<link href="{{ asset('assets/plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.css') }}" rel="stylesheet" />

		<!---Font icons css-->
		<link  href="{{ asset('assets/fonts/fonts/font-awesome.min.css') }}" rel="stylesheet" />
		<link href="{{ asset('assets/plugins/web-fonts/plugin.css') }}" rel="stylesheet" />
	</head>
	<body class="bg-account bg-primary">
		<div class="page">
			<div class="page-content">
				<div class="container text-center">
					<div class="row">
						<div class="col-lg-4 d-block mx-auto">
							<div class="row">
								<div class="col-xl-12 col-md-12 col-md-12">
									<div class="text-center mb-6">
										<h2 style="color: white;">{{ config('app.name') }}</h2>
									</div>
									<div class="card">
										<div class="card-body">
											<h3>Login</h3>
											<p class="text-muted">Sign In to your account</p>
                                            <form action="{{ url('admin/login') }}" method="post"> @csrf

                                                @if(Session::has('invalid')) <div class="text-danger">{{ Session::get('invalid') }}</div>@endif
                                                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                                <div class="input-group mb-3">
                                                    <span class="input-group-addon "><i class="fa fa-user"></i></span>
                                                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                                                </div>

                                                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                                                <div class="input-group">
                                                    <span class="input-group-addon toggle-password"><i class="fa fa-eye"></i></i></span>
                                                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                                                    </div>
                                                </div>
                                            </form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    $(document).ready(function () {
        $('.toggle-password').click(function () {
            $(this).toggleClass('active');

            var input = $('#password');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
            } else {
                input.attr('type', 'password');
            }
        });
    });
</script>