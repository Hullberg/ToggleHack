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
}
?>