<?php
class PagesController {
    
        public function verifyCookies() {
            $pub_key = openssl_get_publickey(file_get_contents('public.pem'));
                $f1 = 0; // username flag
                $f2 = 0; // cart flag
                if ($_COOKIE['username'] != NULL) {
                    $f1 += 1;
                    $user = $_COOKIE['username'];
                    $signature_user = file_get_contents('signature_user.dat');
                    $r1 = openssl_verify($user, $signature_user, $pub_key);
                    $f1 += $r1;
                    if ($f1 % 2 != 0) { echo "username failed signature check<br>"; }
                }
                if ($_COOKIE['cart_array'] != NULL) {
                    $f2 += 1;
                    $cart = $_COOKIE['cart_array'];
                    $signature_cart = file_get_contents('signature_cart.dat');
                    $r2 = openssl_verify($cart, $signature_cart, $pub_key);
                    $f2 += $r2;
                    if ($f2 % 2 != 0) { echo "cart failed signature check<br>"; }
                }
                
                if ($f1 % 2 == 0 && $f2 % 2 == 0) { // Odd numbers = naughty business
                    // Nothing happens, carry on citizen.
                    //echo "No lollygagging!";
                }
                else {
                    //echo "Do not steal that sweetroll!";
                    // Perhaps remove all cookies?
                    $URL = "/ToggleHack/index.php";
                    echo "<script type='text/javascript'>deleteCookie('cart_array');</script>";
                    echo "<script type='text/javascript'>deleteCookie('username');</script>";
                    echo "<script type='text/javascript'>alert('Cookies have been altered and therefore deleted.');</script>";
                    echo "<script>document.location.href='{$URL}';</script>";
                    echo "<META HTTP-EQUIV='refresh' content='0;URL=" . $URL . "'>";
                }
                
        }
    
	public function home() {
            // Retrieves all items from the database
            $items = Item::all(); // An array with all items.
            //var_dump($_COOKIE);
            
            if ($_SESSION['cookies'] == 'ON') {
                //verify signature of cookies
                $this->verifyCookies();
                
            }
            require_once('views/pages/home.php');
	}

	public function search() {
            // Retrieves all items similar to search input
            $itemname = $_POST['Search'];
            $items = Item::findname($itemname);
            
            if ($_SESSION['cookies'] == 'ON') {
                $this->verifyCookies();
                
            }
            require_once('views/pages/home.php');
	}
        
        public function itempage() {
            
            if ($_SESSION['cookies'] == 'ON') {
                //verify signature of both cookies
                $this->verifyCookies();
                
            }
            
            if (isset($_GET['itemid'])) {
                $item_id = $_GET['itemid'];
                $item = Item::find($item_id);
                if ($item == NULL){
                    call('pages','error');
                }
                else {
                    $comments = ItemComment::find($item_id);
                    require_once('views/pages/itempage.php');
                }
            } else {
                // No item ID => No item page.
                require_once('views/pages/error.php');
            }
        }
        
        public function addcomment() {
            if ($_SESSION['cookies'] == 'ON') {
                $this->verifyCookies();
            }
            $comment = $_POST['itemcomment'];
            $product_id = $_POST['product_id'];
            if(!isset($comment) && !isset($product_id)) {
                require_once('views/pages/error.php');
            }
            else {
                // No SQL-injection, just allowing persistent XSS in itempage.php
                $db = Db::getInstance();
                $insert = $db->prepare('INSERT INTO itemcomments(product_id,comment) VALUES(:product_id,:comment)');
                if($insert->execute(array(':product_id' => $product_id, ':comment' => $comment))) {
                    // Insertion succeeded, page refreshed to see new content
                    $URL = "/ToggleHack/index.php?controller=pages&action=itempage&itemid=$product_id";
                    echo "document.location.href='{$URL}';</script>";
                    echo "<META HTTP-EQUIV='refresh' content='0;URL=" . $URL . "'>";
                }
            }
        }

	public function register() {
            if ($_SESSION['cookies'] == 'ON') {
                //verify signature of both cookies
                $this->verifyCookies();
                
            }
            require_once('views/pages/register.php');
	}

	public function error() {
            if ($_SESSION['cookies'] == 'ON') {
                //verify signature of both cookies
                $this->verifyCookies();
                
            }
            require_once('views/pages/error.php');
	}
        
        public function toggle_sql() {
            if ($_SESSION['sql'] == 'OFF') {
                $_SESSION['sql'] = 'ON';
            }
            else {
                $_SESSION['sql'] = 'OFF';
            }
            call('pages','home');
        }
        
        public function toggle_xss() {
            if ($_SESSION['xss'] == 'OFF') {
                $_SESSION['xss'] = 'ON';
            }
            else {
                $_SESSION['xss'] = 'OFF';
            }
            call('pages','home');
        }
       
        
        public function toggle_cookies() {
            // Toggle openSSL signature of the cookies
            
            $user = $_COOKIE['username'];
            $cart = $_COOKIE['cart_array'];
           
            
            if ($_SESSION['cookies'] == 'OFF') {
                $_SESSION['cookies'] = 'ON';
                $passphrase = "password";
                $priv_key = openssl_get_privatekey(file_get_contents('private.pem'), $passphrase);
                
                //create signature
                openssl_sign($user, $signature_user, $priv_key);
                openssl_sign($cart, $signature_cart, $priv_key);
                
                file_put_contents('signature_user.dat', $signature_user);
                file_put_contents('signature_cart.dat', $signature_cart);
                
                
            }
            else {
                $_SESSION['cookies'] = 'OFF';
            }
            call('pages','home');
        }
        
        public function reset_site() {
            // Resets database to 'factory-settings'
            $db = Db::getInstance();
            $db->query('DROP TABLE IF EXISTS items');
            $db->query('DROP TABLE IF EXISTS itemcomments');
            $db->query('DROP TABLE IF EXISTS users');
            
            $db->query('CREATE TABLE items (
                        id INT NOT NULL AUTO_INCREMENT,
                        name VARCHAR(255) NOT NULL,
                        price DECIMAL(5,2) NOT NULL,
                        description LONGTEXT NOT NULL,
                        PRIMARY KEY(id)
                        )');
            $db->query("INSERT INTO items (name, price, description) VALUES ('item0', 800.00, 'Imagine a black t-shirt')");
            $db->query("INSERT INTO items (name, price, description) VALUES ('item1', 400.00, 'Imagine a nice golden watch')");
            $db->query("INSERT INTO items (name, price, description) VALUES ('item2', 200.00, 'Imagine a smartphone')");
            $db->query("INSERT INTO items (name, price, description) VALUES ('item3', 100.00, 'Imagine a laptop')");
            $db->query("INSERT INTO items (name, price, description) VALUES ('item4', 50.00, 'Imagine some kitchen utensil')");
            $db->query("INSERT INTO items (name, price, description) VALUES ('item5', 25.00, 'Imagine some weight-lifting equipment')");
            
            $db->query("CREATE TABLE users (
                        username VARCHAR(255) NOT NULL,
                        md5pass VARCHAR(255),
                        bcryptpass VARCHAR(255),
                        PRIMARY KEY(username)
                        )");
            $db->query('INSERT INTO users (username, md5pass, bcryptpass) VALUES ("ADMIN", "e3274be5c857fb42ab72d786e281b4b8", "$2y$10$VGhpcyFzQVN0cmluZ1QwQO85a87OTivyWwtMZBY45idFrNE6BguL.")');
            $db->query('INSERT INTO users (username, md5pass, bcryptpass) VALUES ("test", "098f6bcd4621d373cade4e832627b4f6", "$2y$10$VGhpcyFzQVN0cmluZ1QwQOISBc6ojqyBA61b/bIdj4gbMADzuuIsW")');
            
            $db->query("CREATE TABLE itemcomments (
                        id INT NOT NULL AUTO_INCREMENT,
                        product_id INT NOT NULL,
                        comment LONGTEXT NOT NULL,
                        PRIMARY KEY(id)
                        )");
            $db->query("INSERT INTO itemcomments (product_id, comment) VALUES ('1','good product')");
            call('pages','home');
        }
}
?>