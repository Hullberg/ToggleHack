<?php

class CartItem {
	public $id;
	public $itemid;
	public $amount;
	public $username;

	public function __construct($id, $itemid, $amount, $username) {
		$this->id = $id;
		$this->itemid = $itemid;
		$this->amount = $amount;
		$this->username = $username;
	}

	public static function getAllCartItemsForUser($username) {
		$list = [];
		$db = Db::getInstance();
		$req = $db->prepare('SELECT * FROM cartitems WHERE username = :username');
		$req->execute(array('username' => $username));

		foreach($req->fetchAll() as $item) {
			$list[] = new CartItem($item['id'], $item['itemid'], $item['amount'], $item['username']);
		}
		
		return $list;
	}

	public static function addCartItem($itemid, $username) {
		$list = getAllCartItemsForUser($username);

		foreach($list as $object) { // See if user already has item in cart
			if ($object->id == $itemid) {
				$item = $object;
			}
		}
		if(isset($item)) { // Increase amount
			$db = Db::getInstance();
			$amount = ++$item->amount;
			$req = $db->prepare('UPDATE cartitems SET amount = :amount WHERE username = :username AND itemid = :itemid');
			$req->execute(array('amount' => $amount, 'username' => $username, 'itemid' => $itemid));

			// TODO: Catch errors
		}
		else { // Create new db-entry
			$db = Db::getInstance();
			$req = $db->prepare('INSERT INTO cartitems (itemid, amount, username) VALUES (:itemid, :amount, :username)');
			$req->execute(array('itemid' => $itemid, 'amount' => 1, 'username' => $username));
		}

		

	}

	}

	public static function decreaseCartItem($itemid, $username) {

	}

	public static function removeCartItem($itemid, $username) {

	}

}

?>