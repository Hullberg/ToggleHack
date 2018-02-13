
<div class="main">
	<div class="container">
		<div class="row">
			<div class="span3">

				<div class="well">
					Measures
					<!-- Will add toggle-buttons and info here -->
				</div>

			</div>

			<div class="span9" style="overflow-y: scroll">
				<form id="register_form" method="POST" name="register_form" action="?controller=users&action=register">
					<h3>Register to the site</h3>
					<div>
						<label>Username</label>
						<input id="registerusername" name="registerusername" type="text" style="width:75%" />

						<label>Password</label>
						<input id="registerpassword" name="registerpassword" type="password" style="width:75%" />
						<br />
						<input type="submit" class="btn btn-success" value="Register"/>

					</div>
				</form>
			</div>

		</div>
	</div>

</div>
