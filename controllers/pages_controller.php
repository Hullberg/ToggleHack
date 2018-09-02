<?php
class PagesController {
	public function home() {
		// Assign attributes for the view here
		
		$items = Item::all(); // An array with all items.

		require_once('views/pages/home.php');
	}

	public function search() {
		$itemname = $_POST['Search'];
		$items = Item::findname($itemname);
		require_once('views/pages/home.php');
	}
        
        public function itempage() {
            
            if (isset($_GET['itemid'])) {
                $prod_id = $_GET['itemid'];
                $item = Item::find($prod_id);
                
                if ($item == NULL){
                    call('pages','error');
                }
                else {
                    $comments = ItemComment::find($prod_id);
                    require_once('views/pages/itempage.php');
                }
            } else {
                require_once('views/pages/error.php');
            }
        }
        
        public function addcomment() {
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
                    // Insertion succeeded
                    $URL = "/ToggleHack/index.php?controller=pages&action=itempage&itemid=$product_id";
                    echo "document.location.href='{$URL}';</script>";
                    echo "<META HTTP-EQUIV='refresh' content='0;URL=" . $URL . "'>";
                }
            }
        }

	public function register() {
		require_once('views/pages/register.php');
	}

	public function error() {
		// No variables, just error
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
            if ($_SESSION['cookies'] == 'OFF') {
                $_SESSION['cookies'] = 'ON';
                // Remove js-cookies and make them $_SESSION.
                // Cart-array and username
                $_SESSION['username'] = $_COOKIE['username'];
                echo "<script type='text/javascript'>deleteCookie('username');</script>";
                $_SESSION['cart_array'] = $_COOKIE['cart_array'];
                echo "<script type='text/javascript'>deleteCookie('cart_array');</script>";
                
                $URL = "/ToggleHack/index.php";
                echo "<script>document.location.href='{$URL}';</script>";
                echo "<META HTTP-EQUIV='refresh' content='0;URL=" . $URL . "'>";
            }
            else {
                $_SESSION['cookies'] = 'OFF';
                // Remove $_SESSION-cookies and make them js-cookies.
                echo "<script type='text/javascript'>setCookie('username','".$_SESSION['username']."')</script>";
                unset($_SESSION['username']);
                echo "<script type='text/javascript'>setCookie('cart_array','".$_SESSION['cart_array']."')</script>";
                unset($_SESSION['cart_array']);
                
                $URL = "/ToggleHack/index.php";
                echo "<script>document.location.href='{$URL}';</script>";
                echo "<META HTTP-EQUIV='refresh' content='0;URL=" . $URL . "'>";
            }
            call('pages','home');
        }
        
        public function reset_site() {
            // Resets database to 'factory-settings'
            $db = Db::getInstance();
            $db->query('DROP TABLE items');
            $db->query('DROP TABLE itemcomments');
            $db->query('DROP TABLE users');
            
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