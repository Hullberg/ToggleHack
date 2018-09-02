<div class="main" style="height:100vh;">
	<div class="container" style="height:100%">
		<div class="row" style="height:100%">
			<div class="span3">
                            
                            <div class='thumbnail'>
				<img src='itemimage.jpg' >
				<div class='caption'>
                                    <?php
                                        echo "<h3>" . $item->name . "<h3>";
                                        echo "<h4>" . $item->price . "</h4>";
                                        echo "<h5>" . $item->description . "</h5>";
                                    ?>
				</div>
                            </div>
                        </div>
                    <div class="span9" style="overflow-y: scroll; height: 76%">
                        <?php
                            if ($comments == NULL) {
                                echo "Currently no comments for this item";
                            }
                            else {
                                foreach($comments as $itemcomment) {
                                    if($_SESSION['xss'] == 'ON') {
                                        // Here the XSS-prevention will handle the content of the comment
                                        $comment = htmlspecialchars($itemcomment->comment);
                                    }
                                    else {
                                        $comment = $itemcomment->comment;
                                    }
                                    
                                    echo "<div class='well'>$comment</div>";
                                }
                            }
                        ?>
                    </div>
                    <div class="span12" style="height:25%">
                        <div class="well">
                            <form method="POST" action="?controller=pages&action=addcomment">
                                <input type="text" name="itemcomment" placeholder="Add your comment here" style="width:99%"><br>
                                <?php
                                echo "<input type='hidden' name='product_id' value=$item->id>";
                                ?>
                                <button class='btn btn-success' style="float: right">Add comment</button>
                            </form>
                        </div>
                    </div>
                </div>
	</div>

</div>