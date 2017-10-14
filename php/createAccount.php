createAccount.php DETAILS ACTIVITY Yesterday Thu 2:22 PM D David Gruenberg edited an item HTML createAccount.php Thu 1:51 PM D David Gruenberg uploaded an item HTML createAccount.php No recorded activity before October 12, 2017 Changed to grid view. All selections cleared All selections cleared All selections cleared

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Bootstrap Website Tutorial</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/styles.css">
	<style>
		body {
			padding-top: 8em;
		}

		.separator {
			border-bottom: #526747 5px solid;
		}

		.btn-login {
			color: #fff;
			background-color: #526747;
			border-color: #ccc;
			padding: .5em 3em;
		}

		.btn-login:hover {
			color: #fff;
			background-color: #234214;
			border-color: #ccc;
		}

		.navbar {
			margin-bottom: 0;
			border-radius: 0;
			background-color: #234214;
			color: #fff;
			padding: .5% 0;
			font-size: 1.1em;
			border-left: none;
			border-right: none;
			border-bottom: #526747 5px solid;
		}

		.navbar-inverse .navbar-collapse {
			border-color: #526747;
		}

		.navbar-brand {
			float: left;
			/*min-height: 55px;*/
			padding: 0 15px 5px;
		}

		.navbar-inverse .navbar-nav .active a,
		.navbar-inverse .navbar-nav .active a:focus,
		.navbar-inverse .navbar-nav .active a:hover {
			color: #fff;
			background-color: #234214;
		}

		.navbar-brand img {
			width: 5.8em;
		}

		.navbar-inverse .navbar-nav>.open>a,
		.navbar-inverse .navbar-nav>.open>a:focus,
		.navbar-inverse .navbar-nav>.open>a:hover {
			color: #fff;
			background-color: #234214;
		}

		.nav {
			margin-bottom: 0;
			border-radius: 0;
			background-color: #234214;
			color: #fff;
			padding: .5% 0;
			font-size: 1.1em;
			border: none;
		}

		.navbar-header {
			min-height: 3.8em;
		}

		.navbar-inverse .navbar-toggle:focus,
		.navbar-inverse .navbar-toggle:hover {
			background-color: #526747;
		}

		.navbar-inverse .navbar-toggle {
			border-color: #fff;
		}

		.navbar-form {
			padding: 0;
			margin-top: -.4em;
		}

		.container-flex {
			max-width: 1200px !important;
			margin: auto;
		}

		footer {
			color: #fff;
			background-color: #234214;
			border-color: #ccc;
		}

		.collapse-header {
			display: inline;
			font-weight: bold;
			color: #234214;
		}

		.collapse-header-text {
			display: inline
		}

		.dropdown-caret {
			color: #234214;
			margin-top: .5em;
		}

	</style>
</head>

<body>
	<header>
		<nav class="navbar navbar-expand navbar-inverse navbar-fixed-top">
			<div class="container-flex">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#MyNavbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
					<a class="navbar-brand" href="#"><img src="img/garage_logo_final.png" /></a>
				</div>
				<div class="collapse navbar-collapse" id="MyNavbar">
					<ul class="nav navbar-nav navbar float-left">
						<li class="active">
							<a href="#">Home</a>
						</li>
						<li role="separator" class="divider"></li>
						<li><a href="">Sales</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="">Items</a></li>
						<li role="separator" class="divider"></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="#">
								<form class="navbar-form navbar-right" role="search">
									<div class="input-group">
										<input id="search" type="text" class="form-control" placeholder="Search" name="search">
										<div class="input-group-btn">
											<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
										</div>
									</div>
								</form>
							</a>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">My Sales</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="#">My Items</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="#">Prefered Items</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="#">One more separated link</a></li>
							</ul>
						</li>
						<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<div class="container">
		<form>
			<div class="form-group">
				<label for="fname">First Name:</label>
				<input type="text" class="form-control" id="fname">
			</div>
			<div class="form-group">
				<label for="lname">Last Name:</label>
				<input type="text" class="form-control" id="lname">
			</div>
			<div class="form-group">
				<label for="phone">Phone:</label>
				<input type="tel" class="form-control" id="phone">
			</div>
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" class="form-control" id="email">
			</div>
			<div class="form-group">
				<label for="address">Address:</label>
				<input type="text" class="form-control" id="address">
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input type="text" class="form-control" id="password">
			</div>
			<div class="form-group">
				<label for="user name">User Name:</label>
				<input type="text" class="form-control" id="user name">
			</div>

			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</body>

</html>