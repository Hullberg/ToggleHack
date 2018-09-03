
<div class="main">
	<div class="container">
		<div class="row">
			<div class="span3">

				<div class="well">
                                    <h4>Protective measures</h4>
					<!-- Will add toggle-buttons and info here -->
                                        <form method="POST" action="?controller=pages&action=toggle_sql">
                                            <label style='float:left'>SQL Injection</label>
                                            <div style='margin-left: 1em' class="dropdown">
						  <img src="https://image.flaticon.com/icons/png/512/8/8235.png" style="width:10px;height:10px">
						  <div class="dropdown-content">
                                                      <p>When an attacker exploits the connection to the database, and attempts to alter the queries. <a href="https://www.veracode.com/security/sql-injection">Explanation</a></p>
						  </div>
                                            </div>
                                            <input style='float:right' class='btn btn-success' type="submit" value="<?php echo $_SESSION['sql']; ?>"/>
                                        </form>
                                        <form method="POST" action="?controller=pages&action=toggle_xss">
                                            <label style='float:left'>Cross-Site Scripting</label>
                                            <div style='margin-left: 1em' class="dropdown">
						  <img src="https://image.flaticon.com/icons/png/512/8/8235.png" style="width:10px;height:10px">
						  <div class="dropdown-content">
                                                      <p>When an attacker attempts to alter the code, possibly adding persistent attacks to affect others using the site. <a href="https://www.veracode.com/security/cross-site-scripting-prevention">Explanation</a></p>
						  </div>
                                            </div>
                                            <input style='float:right' class='btn btn-success' type="submit" value="<?php echo $_SESSION['xss']; ?>">
                                        </form>
                                        <form method="POST" action="?controller=pages&action=toggle_cookies">
                                            <label style='float:left'>Cookie Manipulation</label>
                                            <div style='margin-left: 1em' class="dropdown">
						  <img src="https://image.flaticon.com/icons/png/512/8/8235.png" style="width:10px;height:10px">
						  <div class="dropdown-content">
                                                      <p>When an attacker exploits the site's cookies for various reasons. Specifically Cookie poisoning in this case. <a href="http://www.infosectoday.com/Articles/Cookie_Tampering.htm">Explanation</a></p>
						  </div>
                                            </div>
                                            <input style='float:right' class='btn btn-success' type="submit" value="<?php echo $_SESSION['cookies']; ?>">
                                        </form>
				</div>
                            

				<div class="well">
					<div class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="icon-shopping-cart"></i>
							<!-- Add total sum here -->
                                                        <?php
                                                        if($_SESSION['cookies'] == 'ON') {
                                                            $c_temp = $_SESSION['cart_array'];
                                                        }
                                                        else {
                                                            $c_temp = $_COOKIE['cart_array'];
                                                        }
                                                        if(isset($c_temp)) {
                                                            $cart_array = unserialize(base64_decode($c_temp));
                                                            $tot_sum = 0;
                                                            foreach($cart_array as $cart_item) {
                                                                $tot_sum = $tot_sum + floatval($cart_item['product_price'] * $cart_item['product_amount']);
                                                            }
                                                            echo "$" . $tot_sum;
                                                        }
                                                        else {
                                                            echo "$0";
                                                        }
							?>
							<b class="caret"></b>
						</a>
						<div class="dropdown-menu well" role="menu" aria-labelledby="dLabel">
							<!-- Populate cart with items -->
							<?php
                                                        if($_SESSION['cookies'] == 'ON') {
                                                            $c_temp = $_SESSION['cart_array'];
                                                        }
                                                        else {
                                                            $c_temp = $_COOKIE['cart_array'];
                                                        }
                                                        if(isset($c_temp)) {
                                                            $cart_array = unserialize(base64_decode($c_temp));
                                                            foreach($cart_array as $cart_item) {
                                                                echo "<p style='float:left;display:inline'>" . $cart_item['product_name']." x ".$cart_item['product_amount']." = $".($cart_item['product_price']*$cart_item['product_amount'])."</p>";
                                                                echo "<form method='POST' action='?controller=cart&action=remove'>";
                                                                echo "<input type='hidden' name='product_id' value=".$cart_item['product_id']." />";
                                                                echo "<button style='float:right; display:inline'>x</button></form><br>";
                                                            }
                                                        }
							?>
							<form method='post' action='?controller=cart&action=clearCart' style='display:inline-block;'>
								<input type='hidden' name='clearcart'></input>
								<button class='btn btn-success'>Clear Cart</button>
							</form>
							<form method='post' action='?controller=cart&action=checkout' style='display:inline-block;margin-left:3em'>
								<input type='hidden' name='checkoutpurchase' value='".$_SESSION['cart_products']."'></input>
								<button class='btn btn-success'>Checkout</button>
							</form>
						</div>
					</div>
				</div>


				<div class="well">
					<?php 
                                        if($_SESSION['cookies'] == 'ON') {
                                            $c_temp = $_SESSION['username'];
                                        }
                                        else {
                                            $c_temp = $_COOKIE['username'];
                                        }
                                        //var_dump($c_temp);
                                        if (isset($c_temp)) {
                                            echo "<h3>Hello <script>document.write('$c_temp');</script></h3>";
                                            ?>
                                    <form method="POST" name="logoutform" action="?controller=users&action=logout">
                                        <button type="submit" class="btn btn-success" value="Logout" id="submit">Log out</button>
                                    </form>
                                    <?php
                                        }
                                        else {
                                            echo "<h3>Hello Guest</h3>";
                                            ?>
					<form class="form login-form" id="form_id" method="POST" name="loginform" action="?controller=users&action=login">
						<h2>Sign in</h2>
						<div>
							<label>Username</label>
							<input id="loginusername" name="loginusername" type="text" style="width:80%" />

							<label>Password</label>
							<input id="loginpassword" name="loginpassword" type="password" style="width:80%" />
							
							<br /><br />
							<button type="submit" class="btn btn-success" value="Login" id="submit">Login</button>
						</div>
						<br />
					</form>
                                                
					<a href="?controller=pages&action=register">Register</a>
                                        <?php } ?>
                                        
				</div>
                            <div class='well'>
                                <form method='POST' action='?controller=pages&action=reset_site'>
                                    <button class='btn btn-success'>Reset database to 'original' state</button>
                                </form>
                            </div>
			</div>

			<div class="span9" style="overflow-y: scroll">
				<ul class="thumbnails">
					<?php /*
                                                // Check cart-controller
						foreach ($items as $item) {
							echo <<<ITEMHTML
							<li class='span3'>
								<div class='thumbnail'>
									<a href='http://localhost:8888/ToggleHack/index.php?controller=pages&action=itempage&itemid=$item->id'><img src='itemimage.jpg' ></a>
									<div class='caption'>
										<h4><a href='http://localhost:8888/ToggleHack/index.php?controller=pages&action=itempage&itemid=$item->id'>$item->name</a></h4>
										<p>$ $item->price</p>
										<form method='POST' action='?controller=cart&action=add'>
											<input type='hidden' name='product_id' value=$item->id />
											<input type='hidden' name='product_name' value=$item->name />
											<input type='hidden' name='product_price' value=$item->price />
											<input type='hidden' name='type' value='add_product' />
											<button class='btn btn-success'>Add to Cart</button>
										</form>
									</div>
								</div>
							</li>
ITEMHTML;
						}
                                                */
                                        foreach ($items as $item) {
                                            echo <<<ITEMHTML
                                            <li class='span3'>
                                                <div class='thumbnail'>
                                                    <a href='http://localhost:8888/ToggleHack/index.php?controller=pages&action=itempage&itemid=$item[0]'><img src='itemimage.jpg'></a>
                                                    <div class='caption'>
                                                        <h4><a href='http://localhost:8888/ToggleHack/index.php?controller=pages&action=itempage&itemid=$item[0]'>$item[1]</a></h4>
                                                        <p>$item[2]</p>
                                                        <p>$item[3]</p>
                                                        <form method='POST' action='?controller=cart&action=add'>
                                                            <input type='hidden' name='product_id' value=$item[0] />
                                                            <input type='hidden' name='product_name' value=$item[1] />
                                                            <input type='hidden' name='product_price' value=$item[2] />
                                                            <input type='hidden' name='type' value='add_product' />
                                                            <button class='btn btn-success'>Add to Cart</button>
							</form>
ITEMHTML;
                                        }
                                                
					?>
				</ul>
			</div>

		</div>
	</div>

</div>
