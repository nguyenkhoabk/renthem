<?php
if (isset($_POST['data'])) {
$date = $_POST['data'];
$vec = explode("-",$date);
	$datec= date('Y-m-d', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2]));
				//		$start_hour = $_POST['start_hour'];
				//		$end_hour = $_POST['end_hour'];
					//	for ($i = $start_hour; $i < $end_hour; $i++ ) {				
echo $datec .'<br/>' ;						
						//	$book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff, "date" => $datec, "time_id" => $i));					
					//	}
					$current_mount = 0;
					$current_week = 0;
					
					for ($j=1; $j < 48; $j++) {
						$datec= date('Y-m-d', strtotime('+'.$j.' week', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2])));
					
						IF (date("n",strtotime('+'.$j.' week', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2]))) != $current_mount) {
							$current_mount = date("n",strtotime('+'.$j.' week', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2])));
							$current_week  = 0;
						} else {
							$current_week  ++ ;
						}
						
						if ($current_week < 4 ) {
							echo $datec .'<br/>' ;	
						}
				//		$start_hour = $_POST['start_hour'];
				//		$end_hour = $_POST['end_hour'];
					//	for ($i = $start_hour; $i < $end_hour; $i++ ) {			
						
							//$book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff, "date" => $datec, "time_id" => $i));					
					//	}
					
					}

		}			
?>

<form action="" method="post">
<input type="text" name="data" value="" />
<input type="submit" name="" value="CHECK" />
</form>

<p>Date format: "yyyy-mm-dd"</p>