<?php
class PagesController {
	public function home() {
		// Assign attributes for the view here
		$test = "Testytest";
		
		$items = Item::all(); // An array with all items.

		require_once('views/pages/home.php');
	}

	public function error() {
		// No variables, just error
		require_once('views/pages/error.php');
	}
}
?>