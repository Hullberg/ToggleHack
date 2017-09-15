<DOCTYPE html>
<html>
	<head>
		
		<link rel="stylesheet" href="style.css" />
		<link rel="stylesheet" href="./js/bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" href="./js/bootstrap/css/bootstrap-responsive.min.css" />
		<link rel="stylesheet" href="./css/font-awesome/css/font-awesome.min.css" />

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="./js/jquery-1.10.0.min.js"></script>
		<script src="./js/bootstrap/js/bootstrap.min.js"></script>
		<script src="./js/holder.js"></script>

		<title>ToggleHack</title>
	</head>
	<body>
		<header>
			<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
						<a class="brand" href="/ToggleHack/index.php">ToggleHack</a>
						<div class="searchfield">
							<!-- Add searchfield on some views -->
							<button class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse" type="button">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<div class="nav-collapse collapse">

								<form class="navbar-form form-search pull-right" method="post" action="index.php">
									<input id="Search" name="searchphrase" type="text" class="input-medium search-query">
									<button type="submit" class="btn">Search</button>
								</form>
							</div>
						</div>

					</div>
				</div>
			</div>
		</header>

		<?php require_once('routes.php'); ?>
		
		<footer>
			<!-- Made by Johan, Jeff & Anders -->
		</footer>

	</body>
<html>