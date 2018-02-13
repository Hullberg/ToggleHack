<?php
class PagesController {
	public function home() {
		// Assign attributes for the view here
		$test = "Testytest";
		
		$items = Item::all(); // An array with all items.

		//$user = "test";
		//$cartList = CartItem::getAllCartItemsForUser($user);
		//$cartList = CartItem::getAll();

		require_once('views/pages/home.php');
	}

	public function search() {
		$test = "Testytest";

		$itemname = $_POST['Search'];
		

		$items = Item::findname($itemname);

		require_once('views/pages/home.php');
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