<?php
	include("../core.php");

	$client_id = $_POST['client_id'];
	$staff_id = $_POST['staff_id'];
	$book_id = $_POST['book_id'];
	$end_hour = $_POST['end_hour'];
	$start_hour = $_POST['start_hour'];
	 $new_date = $_POST['new_date'];
	
	
	 $check = $book->checkAvailableTimeV2($start_hour, $end_hour, $staff_id, $new_date,$book_id);

	if ($check != 0 ) {
		echo '2';
	} else {
		for ($i = $start_hour; $i < $end_hour; $i++ ) {
				$book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff_id, "date" => $new_date, "time_id" => $i));
		}
		echo '1';
	}
?>
