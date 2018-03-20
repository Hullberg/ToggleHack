<?php

class Item {
	public $id;
	public $name;
	public $img;
	public $price;
        public $description;

	public function __construct($id, $name, $img, $price, $description) {
		$this->id = $id;
		$this->name = $name;
		$this->img = $img;
		$this->price = $price;
                $this->description = $description;
	}

	public static function all() {
		$list = [];
		$db = Db::getInstance();
		$req = $db->query('SELECT * FROM items');
		
		foreach($req->fetchAll() as $item) {
			$list[] = new Item($item['id'], $item['name'], $item['imgurl'], $item['price'], $item['description']);
		}
		
		return $list;
	}

	public static function find($id) {
		$db = Db::getInstance();

		$id = intval($id);
		$req = $db->prepare('SELECT * FROM items WHERE id = :id');
		$req->execute(array('id' => $id));
		$item = $req->fetch();

		return new Item($item['id'], $item['name'], $item['img'], $item['price'], $item['description']);
	}

	public static function findname($itemname) {
		$db = Db::getInstance();
		$list = [];
		// SQL Unsafe
		$req = $db->prepare('SELECT * FROM items WHERE name LIKE :itemname');
		$req->execute(array('itemname' => "%" . $itemname . "%"));

		foreach($req->fetchAll() as $item) {
			$list[] = new Item($item['id'], $item['name'], $item['img'], $item['price'], $item['description']);
		}
		
		return $list;
	}
}

?>