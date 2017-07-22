<?php
	include("../core.php");
		$book_id = $_POST['book_id'];

		$book->delBook(" book_id =  '".$book_id."' ");
		$book->delBookDetails(" id =  '".$book_id."' ");
?>