<?php

class CartController {

        public function add() {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        /*
          $cart_array = array(
          array(
          'product_id' => '100',
          'product_name' => 'item0'
          'product_price' => '25,00',
          'product_amount' => 2
          ),...
         */
        
        if (isset($_COOKIE['cart_array']) || isset($_SESSION['cart_array'])) { // If empty, no items in cart.
            if ($_SESSION['cookies'] == 'OFF') {
                $cart_array = unserialize(base64_decode($_COOKIE['cart_array']));
            }
            else {
                $cart_array = unserialize(base64_decode($_SESSION['cart_array']));
            }
            $tempindex = -1;
            $length = count($cart_array);
            for ($i = 0; $i < $length; $i++) {
                if($cart_array[$i]['product_id'] == $product_id) {
                    $tempindex = $i;
                }
            }
            
            if ($tempindex != -1) { // Item in cart, increase amount
                $item = $cart_array[$tempindex];
                $amt = $item['product_amount'] + 1;
                $cart_array[$tempindex] = array('product_id' => $item['product_id'], 'product_name' => $item['product_name'], 'product_price' => $item['product_price'], 'product_amount' => $amt);
                
            } else {
                $cart_array[] = array('product_id' => $product_id, 'product_name' => $product_name, 'product_price' => $product_price, 'product_amount' => 1);
            }
        } else {
            $cart_array[] = array('product_id' => $product_id, 'product_name' => $product_name, 'product_price' => $product_price, 'product_amount' => 1);
        }
        
        $cookiedata = base64_encode(serialize($cart_array));
        
        // Update cookie
        $URL = "/ToggleHack/index.php";
        if  ($_SESSION['cookies'] == 'OFF') {
            echo "<script type='text/javascript'>setCookie('cart_array', '".$cookiedata."');</script>";
        }
        else {
            $_SESSION['cart_array'] = $cookiedata;
        }
        echo "<script>document.location.href='{$URL}';</script>";
        echo "<META HTTP-EQUIV='refresh' content='0;URL=" . $URL . "'>";
    }

       
    public function remove() {
        $product_id = $_POST['product_id'];
        $cart_array = unserialize(base64_decode($_COOKIE['cart_array']));
        $len = count($cart_array);
        for ($i = 0; $i < $len; $i++) {
            if ($cart_array[$i]['product_id'] == $product_id) {
                unset($cart_array[$i]);
            }
        }
        $cookiedata = base64_encode(serialize($cart_array));
        $URL = "/ToggleHack/index.php";
        if ($_SESSION['cookies'] == 'OFF') { 
            echo "<script type='text/javascript'>setCookie('cart_array', '".$cookiedata."');</script>";
        }
        else {
            $_SESSION['cart_array'] = $cookiedata;
        }
        echo "<script>document.location.href='{$URL}';</script>";
        echo "<META HTTP-EQUIV='refresh' content='0;URL=" . $URL . "'>";
    }

    public function clearCart() {
        $URL = "/ToggleHack/index.php";
        if ($_SESSION['cookies'] == 'OFF') {
            echo "<script type='text/javascript'>deleteCookie('cart_array');</script>";
        }
        else {
            unset($_SESSION['cart_array']);
        }
        echo "<script>document.location.href='{$URL}';</script>";
        echo "<META HTTP-EQUIV='refresh' content='0;URL=" . $URL . "'>";
    }

    public function checkout() {
        // Get all items and redirect to checkout.
        $cart = unserialize(base64_decode($_COOKIE['cart_array']));
        $tot_sum = 0;
        foreach($cart as $cart_item) {
            $tot_sum += $cart_item['product_amount']*$cart_item['product_price'];
        }
        require_once('views/pages/checkout.php');
    }
}

?>