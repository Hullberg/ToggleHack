
<div class="main">
	<div class="container">
		<div class="row">
			<div class="span3">

				<div class="well">
					Measures
					<!-- Will add toggle-buttons and info here -->
				</div>
                            <?php 
                            // TODO: Get the items from the cookie properly
                            /*if (isset($_COOKIE['cart_array'])) {
                                $cart_array = explode(",",($_COOKIE['cart_array']));
                                $temparray = [];
                                for($i = 0; $i <= count($cart_array); $i+=4) {
                                    $new_item = array('product_id' => $cart_array[$i], 'product_name' => $cart_array[$i+1], 'product_price' => $cart_array[$i+2], 'product_amount' => $cart_array[$i+3]);
                                    $temparray.push($new_item);
                                }
                            }*/
                            if(isset($_COOKIE['cart_array'])) {
                                echo $_COOKIE['cart_array'];
                            }
                            
                            ?>

				<div class="well">
					<div class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="icon-shopping-cart"></i>
							<!-- Add total sum here -->
							<b class="caret"></b>
						</a>
						<div class="dropdown-menu well" role="menu" aria-labelledby="dLabel">
							<!-- Populate cart with items -->
							<?php
                                                        // TODO
							$cart_array = $_COOKIE['cart_array'];

							foreach($cart_array as $cart_item) {
								echo "<p>".$cart_item->product_id." x ".$cart_item->product_amount." x ".$cart_item->product_price." = ".($cart_item->product_amount*$cart_item->product_price)."</p>";
							}
							?>

							<!-- Fix the following-->
							<form method='post' action='?controller=cart&action=clear' style='display:inline-block;'>
								<input type='hidden' name='clearcart'></input>
								<button class='btn btn-success'>Clear Cart</button>
							</form>
							<form method='post' action='?controller=cart&action=checkout' style='display:inline-block;margin-left:3em'>
								<input type='hidden' name='checkoutpurchase' value='".$_SESSION['cart_products']."'></input>
								<button class='btn btn-success'>Checkout</button>
							</form>";
						</div>
					</div>
				</div>


				<div class="well">
					<?php 
                                        if (isset($_COOKIE['username'])) {
                                            echo "<h3>Hello <script>document.write(getCookie('username'));</script></h3>";
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
			</div>

			<div class="span9" style="overflow-y: scroll">
				<ul class="thumbnails">
					<?php // Check cart-controller
						foreach ($items as $item) {
							echo <<<ITEMHTML
							<li class='span3'>
								<div class='thumbnail'>
									<img src='itemimage.jpg' >
									<div class='caption'>
										<h4>$item->name</h4>
										<p>$item->price</p>
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
					?>
				</ul>
			</div>

		</div>
	</div>

</div>
