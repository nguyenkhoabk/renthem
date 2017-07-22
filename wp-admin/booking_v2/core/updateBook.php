<?php
	include("../core.php");
	
	if (isset($_POST['action']) && !empty($_POST['action'])) {
		switch ($_POST['action']) {
			case 'update':
				$clean_service = $_POST['clean_service'];
				if (strpos($clean_service,"::")){
				
				$clean_vec = explode("::",$clean_service);
				$service_id = $clean_vec[1];
				$frequency = $clean_vec[0];
				} else {
				$service_id = $clean_service;
				$frequency = 0;
				}
				
			
				$service_window_id = $_POST['window_service'];
			
				//setup client
				$book_id = $_POST['book_id'];
				$client_id = $_POST['client_id'];
				$data = array();
				$data['first_name'] = $_POST['first_name'];
				$data['last_name'] = $_POST['last_name'];
				$data['email'] = $_POST['email'];
				$data['city'] = $_POST['city'];
				$data['zipcode'] = $_POST['zip'];
				$data['address'] =$_POST['address'];
				$data['phone'] = $_POST['mobile'];
		//		$data['comment'] = mysql_real_escape_string($_POST['comment']);
				
				$client->upClient($data, " id = '".$client_id."' ");
			
			//setup booking 	
				$book_details = array();
				
					$size = $_POST['size'];
				$window =  $_POST['window'];
				
			
		$price_total = 0;	
$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id."')  AND (frequency = ".$frequency.")", "" );

if (count($servicePrice) != 0) {
$price_total +=$servicePrice[0]['amount'];
$book_details['price_size'] =$servicePrice[0]['amount'];
}
	
$servicePrice = $service->getServicePrice("*", " (".$window." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_window_id."')", "" );

if (count($servicePrice) != 0) {
$price_total +=$servicePrice[0]['amount'];
$book_details['price_windows']  =$servicePrice[0]['amount'];
}		
				
				$book_details['frequency'] = $frequency;;
				$book_details['size'] = $_POST['size'];
				$book_details['window'] = $_POST['window'];
				$book_details['special_offer'] = $_POST['special_offer'];
				$book_details['total'] = $_POST['total'];
			
				$book_details['service_id'] =$service_id;
				$book_details['service_window_id'] =$service_window_id;
				$book_details['date'] = $_POST['date'];
				
			 $book->upBookDetails($book_details, " id = '".$book_id."' " );
			 
			// setup comment	
				$book_comment = array();
				$book_comment['comment'] = $_POST['comment'];
					$book->upBookComment($book_comment, " book_id = '".$book_id."' ");
				
			// delete  previosu time and setup new one

				$book->delBook(" book_id = '".$book_id."' ");
			// setup booking	
				$start_hour = $_POST['start_hour'];
				$end_hour = $_POST['end_hour'];
				$date = $_POST['date'];
//$staff = $_POST['staff'];
				
				
			$staff_vec = explode("::",$_POST['staff']);
				//$staff = $_POST['staff'];
		
		
		foreach ($staff_vec as $staff ) {		
				
		
				for ($i = $start_hour; $i < $end_hour; $i++ ) {
					
					$book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff, "date" => $date, "time_id" => $i));
			
				}
				$vec = explode("-", $date);
				switch ($frequency) {
						case '1':
			$data = $date;				
					
	$even_status = 0 ;
	$week_number = date("W", strtotime($data));
	if ($week_number % 2 == 1) {
		$even_status = 1 ;
	}
	
	$previous_month =  date("n", strtotime($data));
		

	
	for ($i = 1; $i < 13; $i++) {
		$data = date("Y-m-d",strtotime( $data ." +28 days" ));
		$curent_month =  date("n", strtotime($data));
		
		// check if is in same month
		
		if ($previous_month == $curent_month) {
			$data = date("Y-m-d",strtotime( $data ." +7 days" ));
			$month_even =  date("W", strtotime($data));
			
			if($month_even % 2 != $even_status) { 
				$data = date("Y-m-d",strtotime( $data ." +7 days" ));
			}
		}
		$previous_month =  date("n", strtotime($data));
	
		$week_number =  date("W", strtotime($data));
				$start_hour = $_POST['start_hour'];
		$end_hour = $_POST['end_hour'];

		for ($j = $start_hour; $j < $end_hour; $j++ ) {	 
			 $book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff, "date" => $data, "time_id" => $j));
			 
		}	 
		
	}
	
						break;
					case '2':
						$dateb= date('Y-m-d',  strtotime($vec[0].'-'.$vec[1].'-'.$vec[2]));
						$start_hour = $_POST['start_hour'];
						$end_hour = $_POST['end_hour'];
					
						for ($i = $start_hour; $i < $end_hour; $i++ ) {							
							$book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff, "date" => $dateb, "time_id" => $i));					
						}
						
						
					for ($t =1 ; $t <27; $t++) { 
						$dateb= date('Y-m-d', strtotime('+'.($t*2).' week', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2])));
						$start_hour = $_POST['start_hour'];
						$end_hour = $_POST['end_hour'];
					
						for ($i = $start_hour; $i < $end_hour; $i++ ) {							
							$book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff, "date" => $dateb, "time_id" => $i));					
						}
					}
					
					
						break;
					case '4':
						$datec= date('Y-m-d', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2]));
						$start_hour = $_POST['start_hour'];
						$end_hour = $_POST['end_hour'];
						for ($i = $start_hour; $i < $end_hour; $i++ ) {							
							$book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff, "date" => $datec, "time_id" => $i));					
						}
						
								$current_mount = 0;
					$current_week = 0;
					
					for ($j=1; $j < 54; $j++) {
						$datec= date('Y-m-d', strtotime('+'.$j.' week', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2])));
					
						IF (date("n",strtotime('+'.$j.' week', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2]))) != $current_mount) {
							$current_mount = date("n",strtotime('+'.$j.' week', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2])));
							$current_week  = 0;
						} else {
							$current_week  ++ ;
						}
						
						if ($current_week < 4 ) {
							$start_hour = $_POST['start_hour'];
							$end_hour = $_POST['end_hour'];
							for ($i = $start_hour; $i < $end_hour; $i++ ) {			
								$book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff, "date" => $datec, "time_id" => $i));	
							}
						}
			
					
					}
					
				/*	
					for ($j=1; $j < 48; $j++) {
						$datec= date('Y-m-d', strtotime('+'.$j.' week', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2])));
						$start_hour = $_POST['start_hour'];
						$end_hour = $_POST['end_hour'];
						for ($i = $start_hour; $i < $end_hour; $i++ ) {							
							$book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff, "date" => $datec, "time_id" => $i));					
						}
					}*/
						break;
				}
		}	
				
			break;
		}
	}
	
	
?>