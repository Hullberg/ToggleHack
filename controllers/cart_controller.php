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
          'product_price' => '25,00',
          'product_amount' => '2'
          ),...
         */


        $cart_array = array();
        $tempindex = -1;
        if (isset($_COOKIE['cart_array'])) { // If empty, no items in cart.
            $cart_array[] = $_COOKIE['cart_array'];
            //$cart_array = explode(",",$_COOKIE['cart_array']);
            $length = count($cart_array);
            $tempindex = -1;
            for ($i = 0; $i <= $length; $i++) {
                if ($cart_array[$i]['product_id'] == $product_id) {
                    $tempindex = $product_id;
                }
            }
            if ($tempindex != -1) { // Item in cart, increase amount
                $cart_array[$tempindex]['product_amount']++;
            } else {
                $new_item = array('product_id' => $product_id, 'product_name' => $product_name, 'product_price' => $product_price, 'product_amount' => 1);
                $cart_array[] = $new_item;
            }
        } else {
            $new_item = array('product_id' => $product_id, 'product_name' => $product_name, 'product_price' => $product_price, 'product_amount' => 1);
            $cart_array[] = $new_item;
        }

        var_dump($cart_array);
        echo "<br>".serialize($cart_array);
        // Convert $cart_array to a javascript-array
        // var cart_array = [];
        // foreach($cart_array as $item) {convert to js and push to js-var}
        // id,name,price,amount
        // var item = [0,'item_0',200.00,1];
        // Update cookie
        $URL = "/ToggleHack/index.php";
        // $cart_array[index][attribute] works until here
        //var_dump($cart_array);
        echo "<br>";
        echo json_encode($cart_array);
        //$jsonformat = json_encode($cart_array);
        //var_dump($jsonformat);
        //var_dump($cart_array, serialize($cart_array));
        echo "<script type='text/javascript'>";
        echo "var cart_array = [];";
        /*foreach($cart_array as $item) {
            echo "var new_item = new Array();";
            echo "new_item[0] = " . $item[product_id] . ";";
            echo "new_item[1] = '" . $item[product_name] . "';";
            echo "new_item[2] = " . $item[product_price] . ";";
            echo "new_item[3] = " . $item[product_amount] . ";";
            //echo "var item = [" . $item[product_id] . ",'" . $item[product_name] . "'," . $item[product_price] . "," . $item[product_amount] . "];";
            echo "cart_array.push([new_item]);";
        }*/
        //echo "var cart_array = JSON.Stringify(" . json_encode($cart_array) . ");";
        
        //echo "setCookie('cart_array', cart_array);";     
        //echo "setCookie('cart_array', " . json_encode($cart_array) . ");";
        //echo "document.location.href='{$URL}';</script>";
        //echo "<META HTTP-EQUIV='refresh' content='0;URL=" . $URL . "'>";
    }

       // unset
    public function remove($itemid) {
        $todo = "todo";
    }

    public function clearCart() {
        $URL = "/ToggleHack/index.php";
        echo "<script type='text/javascript'>deleteCooke('cart_array');";
        echo "document.location.href='{$URL}';</script>";
        echo "<META HTTP-EQUIV='refresh' content='0;URL=" . $URL . "'>";
    }

    public function checkout() {
        // Get all items and redirect to some site.
        $cart = $_COOKIE['cart_array'];
        
    }
}

?>