<?php
	include("../core.php");
	$id = $_POST['id'];
	
	$book->delBookPeending(" id = '".$id."' ");
	
	?>