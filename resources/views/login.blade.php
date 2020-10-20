<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Crystal</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="imgs/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="imgs/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="imgs/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="styles/core.css">
	<link rel="stylesheet" type="text/css" href="styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="styles/style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
</head>
<body class="login-page">
    <div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo" style="text-align:center !important;"><img src="imgs/logo_crystal.png" alt="" style="width:50% !important"></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
	</div>

	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="login.html">
					<img src="imgs/logo_crystal.png" alt="">
				</a>
			</div>
			<div class="login-menu">
				<ul>
					<li><a href="register.html">Hacerse socio</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="images/login-page-img.png" alt="">
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">Iniciar sesión</h2>
						</div>
						<form>
							<div class="select-role">
								<div class="btn-group btn-group-toggle" data-toggle="buttons">
									<label class="btn active">
										<input type="radio" name="options" id="admin">
										<div class="icon"><img src="images/briefcase.svg" class="svg" alt=""></div>
										<span>Soy </span>
										Admin
									</label>
									<label class="btn">
										<input type="radio" name="options" id="user">
										<div class="icon"><img src="images/person.svg" class="svg" alt=""></div>
										<span>Soy </span>
										Miembro
									</label>
								</div>
							</div>
							<div class="input-group custom">
								<input type="text" class="form-control form-control-lg" placeholder="Usuario">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
								</div>
							</div>
							<div class="input-group custom">
								<input type="password" class="form-control form-control-lg" placeholder="**********">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<div class="row pb-30">
								<div class="col-6">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck1">
										<label class="custom-control-label" for="customCheck1">Recordar</label>
									</div>
								</div>
								<div class="col-6">
									<div class="forgot-password"><a href="forgot-password.html">Olvidó su contraseña</a></div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
										-->
										<a class="btn btn-primary btn-lg btn-block" href="index.html">Iniciar</a>
									</div>									
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
	<script src="scripts/core.js"></script>
	<script src="scripts/script.min.js"></script>
	<script src="scripts/process.js"></script>
	<script src="scripts/layout-settings.js"></script>
</body>
</html>