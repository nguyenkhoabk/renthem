<?php
include("../core.php");
$book_id = $_POST['book_id'];
$date = $_POST['date'];

$book->delBook(" book_id = '".$book_id."' AND date = '".$date."' ");
?>