
<div class="main">
	<div class="container">
		<div class="row">
			<div class="span3">

				<div class="well">
					Measures
				</div>


				<div class="well">
					<div class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="icon-shopping-cart"></i>
							<!-- Add total sum here -->
							<b class="caret"></b>
						</a>
						<div class="dropdown-menu well" role="menu" aria-labelledby="dLabel">
							<!-- Populate cart with items -->


							<!-- Fix the following-->
							<form method='post' action='index.php' style='display:inline-block;'>
								<input type='hidden' name='clearcart'></input>
								<button class='btn btn-success'>Clear Cart</button>
							</form>
							<form method='post' action='checkout.php' style='display:inline-block;margin-left:3em'>
								<input type='hidden' name='checkoutpurchase' value='".$_SESSION['cart_products']."'></input>
								<button class='btn btn-success'>Checkout</button>
							</form>";
						</div>
					</div>
				</div>


				<div class="well">
					<form class="form login-form" id="form_id" method="post" name="loginform" action="index.php">
						<h2>Sign in</h2>
						<div>
							<label>Username</label>
							<input id="Username" name="username" type="text" />

							<label>Password</label>
							<input id="Password" name="password" type="password" />
							<!--
							<label class="checkbox inline">
								<input type="checkbox" id="RememberMe" name="rememberme" value="option1"> Remember me
							</label>
							-->
							<br /><br />
							<button type="submit" class="btn btn-success" value="Login" id="submit">Login</button>
						</div>
						<br />
					</form>
					<!-- Some register page -->
					<a href="/">Register</a>
				</div>
			</div>

			<div class="span9" style="overflow-y: scroll">
				<p>Items in here</p>
			</div>

		</div>
	</div>

</div>