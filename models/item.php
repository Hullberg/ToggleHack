<?php

class Item {
	public $id;
	public $name;
	public $img;
	public $price;

	public function __construct($id, $name, $img, $price) {
		$this->id = $id;
		$this->name = $name;
		$this->img = $img;
		$this->price = $price;
	}

	public static function all() {
		$list = [];
		$db = Db::getInstance();
		//$req = $db->query('SELECT * FROM items');
		$stmt = "SELECT * from items";
		foreach($db->query($stmt) as $item) {
			$list[] = new Item($item['id'], $item['name'], $item['imgurl'], $item['price']);
		}
		
		return $list;
	}

	public static function find($id) {
		$db = Db::getInstance();

		$id = intval($id);
		$req = $db->prepare('SELECT * FROM items WHERE id = :id');
		$req->execute(array('id' => $id));
		$item = $req->fetch();

		return new Item($item['id'], $item['name'], $item['img'], $item['price']);
	}

	public static function findname($itemname) {
		$db = Db::getInstance();
		$list = [];
		// SQL Unsafe
		$req = $db->prepare('SELECT * FROM items WHERE name LIKE :name');
		$req->execute(array('name' => $name));

		foreach($req->fetchAll() as $item) {
			$list[] = new Item($item['id'], $item['name'], $item['img'], $item['price']);

			return $list;
		}
	}
}

?>