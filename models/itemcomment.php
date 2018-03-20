<?php
class ItemComment {
    public $id;
    public $product_id;
    public $comment;
    
    public function __construct($id, $product_id, $comment) {
	$this->id = $id;
        $this->product_id = $product_id;
        $this->comment = $comment;
    }
    
    public static function find($id) {
        $db = Db::getInstance();
        $list = [];
        $id = intval($id);
        $req = $db->prepare('SELECT * FROM itemcomments WHERE product_id = :id');
        // No sql injection here, sorry.
        $req->execute(array('id' => $id));
        foreach($req->fetchAll() as $comment) {
            $list[] = new ItemComment($comment['id'], $comment['product_id'], $comment['comment']);
	}
        return $list;
    }
    
}
?>