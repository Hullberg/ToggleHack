<?php
class PagesController {
	public function home() {
		// Assign attributes for the view here
		$test = "Testytest";
		
		//$items = Item::all();
		$items = [];
		$items[] = new Item(0,'Hemming Slimming','http://gloimg.twinkledeals.com/td/2015/201507/source-img/1436466658259-P-2819655.jpg?20141203001',149.00)

		require_once('views/pages/home.php');
	}

	public function error() {
		// No variables, just error
		require_once('views/pages/error.php');
	}
}
?>