<div class="main" style="height:100vh;">
	<div class="container" style="height:100%">
		<div class="row" style="height:100%">
			<div class="span3">
                            
                            
                        </div>
                    <div class="span9" style="overflow-y: scroll; height: 76%">
                        <!-- get $cart and $tot_sum here -->
                        <?php
                            echo "<h3>If cookies are not properly hidden they can be poisoned.<br>";
                            if (isset($_COOKIE['username'])) {
                                echo "Username: <script>document.write(getCookie('username'));</script><br>";
                            }
                            if (isset($_COOKIE['cart_array'])) {
                                echo "Cart array: <script>document.write(getCookie('cart_array'));</script><br>";
                            }
                            echo "</h3>";
                            foreach($cart as $cart_item) {
                                //echo "<div class='span9' style=height:15%;width:60%;border-bottom:solid>";
                                echo "<div class='well' style='height:42px'>";
                                echo $cart_item['product_name'] . " x " . $cart_item['product_amount'] . " x $" . $cart_item['product_price'];
                                echo "<img src='itemimage.jpg' style='top:0px;margin-top:0px;float:right;width:40px;height:40px'>";
                                echo "</div>";
                            }
                            
                        ?>
                    </div>
                    <div class="span9">
                        <?php
                            echo "<div style=float:right>Total sum: " . $tot_sum . "</div><br>";
                            ?>
                    <button class="btn btn-success" style="float:right;">Possible Payment-site</button>
                    </div>
                    
                </div>
	</div>

</div>