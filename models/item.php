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
                        // Model trashed to allow for SQL injection in searchbar. Methods are still good though.
			//$list[] = new Item($item['id'], $item['name'], $item['imgurl'], $item['price'], $item['description']);
                    $list[] = $item;
		}
		
		return $list;
	}

        public static function find($id) {
            $db = Db::getInstance();
            $req = $db->prepare('SELECT id,name,price,description FROM items WHERE id = :id');
            $req->execute(array('id' => $id));
            $item = $req->fetch();
            return $item;
        }
        
        public static function findname($itemname) {
            $db = Db::getInstance();
            $list = [];
            if ($_SESSION['sql'] == 'OFF') {
                $sql = "SELECT * FROM items WHERE (name LIKE '%$itemname%' AND deletedAt IS NULL)";
                $req = $db->query($sql);   
            }
            else {
                $req = $db->prepare('SELECT * FROM items WHERE name LIKE :itemname');
		$req->execute(array('itemname' => "%" . $itemname . "%"));
            }
            foreach($req->fetchAll() as $item) {
                    $list[] = $item;
                }
            return $list;
        }
}

?>