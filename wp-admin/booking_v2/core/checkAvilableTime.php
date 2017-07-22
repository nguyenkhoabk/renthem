<?php
	include("../core.php");
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$staff_id = $_POST['staff'];
	$date = $_POST['date'];
	$book_id = 0;
	$frequency = 0;
	if (isset($_POST['frequency']) && !empty($_POST['frequency'])) {
		$frequency = $_POST['frequency'];
	}

	if (isset($_POST['book_id']) && !empty($_POST['book_id'])) {
		$book_id = $_POST['book_id'];
	}
	$count_time = "";
	
	if ($book_id != 0) {
	
			$vec = explode("-", $date);

		
	
	
		switch ($frequency) {
			case '1':
			
						$data	= $date;		
$day_name = date("l", strtotime($data));
$week_no =  date("W",strtotime($data))- date("W", strtotime(date("Y-m-01", strtotime($data)))) + 1;
for ($t = 0; $t< 12; $t++) {
if ( ( date("N",strtotime( date("Y-m-1",strtotime($data)))) >= 3) && ( (date("j",strtotime($data)) > 3 ) && (date("j",strtotime($data)) <= 14 ) ) ) {
	$week_no --;
}

	$position = "";

	switch($week_no) {
		case '1': $position = "first ";	break;
		case '2': $position = "second ";	break;
		case '3': $position = "third ";	break;
		case '4': $position = "fourth ";	break;
		default: $position = "fifth ";	break;
	}


	$month_name = date("F", strtotime($data));
	$year = date("Y", strtotime($data));

	 $new_date =  date("Y-m-d",strtotime($position." ".$day_name." of ".$month_name." ".$year));
	 
	 if (date("m", strtotime($new_date)) != date("m", strtotime($data)) ) {
	  $new_date =  date("Y-m-d",strtotime("fourth ".$day_name." of ".$month_name." ".$year));
	 }
	 $aux += $book->checkAvailableTime($start_time, $end_time, $staff_id, $new_date,$book_id);

	  $data = date('Y-m-d', strtotime('+1 month', strtotime(date("Y-m-1", strtotime($data)))));
 
 }
				
				break;
			case '2':
			
				
					for ($t =1 ; $t <24; $t++) { 
						$dateb= date('Y-m-d', strtotime('+'.($t*2).' week', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2])));
				
						$aux += $book->checkAvailableTime($start_time, $end_time, $staff_id, $dateb, $book_id);
					}
					
					
					
				break;
			case '4':
			
			for ($j=1; $j < 48; $j++) {
						$datec= date('Y-m-d', strtotime('+'.$j.' week', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2])));
						$aux += $book->checkAvailableTime($start_time, $end_time, $staff_id, $datec, $book_id);
					}
					
					
				break;
			case '0':
				$aux += $book->checkAvailableTime($start_time, $end_time, $staff_id, $date, $book_id);
			break;
				
		}

	} else {
	
		
			$vec = explode("-", $date);


		
	
		$aux = 0;
	
	
		switch ($frequency) {
			case '1':
			
				
				$data	= $date;		
$day_name = date("l", strtotime($data));
$week_no =  date("W",strtotime($data))- date("W", strtotime(date("Y-m-01", strtotime($data)))) + 1;
for ($t = 0; $t< 12; $t++) {
if ( ( date("N",strtotime( date("Y-m-1",strtotime($data)))) >= 3) && ( (date("j",strtotime($data)) > 3 ) && (date("j",strtotime($data)) <= 14 ) ) ) {
	$week_no --;
}

	$position = "";

	switch($week_no) {
		case '1': $position = "first ";	break;
		case '2': $position = "second ";	break;
		case '3': $position = "third ";	break;
		case '4': $position = "fourth ";	break;
		default: $position = "fifth ";	break;
	}


	$month_name = date("F", strtotime($data));
	$year = date("Y", strtotime($data));

	 $new_date =  date("Y-m-d",strtotime($position." ".$day_name." of ".$month_name." ".$year));
	 
	 if (date("m", strtotime($new_date)) != date("m", strtotime($data)) ) {
	  $new_date =  date("Y-m-d",strtotime("fourth ".$day_name." of ".$month_name." ".$year));
	 }
	 $aux += $book->checkAvailableTime($start_time, $end_time, $staff_id, $new_date);

	  $data = date('Y-m-d', strtotime('+1 month', strtotime(date("Y-m-1", strtotime($data)))));
 
 }
 

				break;
			case '2':
			
				
					for ($t =1 ; $t <24; $t++) { 
						 $dateb= date('Y-m-d', strtotime('+'.($t*2).' week', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2])));
								
						$aux += $book->checkAvailableTime($start_time, $end_time, $staff_id, $dateb);
					}
					
					
					
				break;
			case '4':
			
			for ($j=1; $j < 48; $j++) {
						$datec= date('Y-m-d', strtotime('+'.$j.' week', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2])));
						$aux += $book->checkAvailableTime($start_time, $end_time, $staff_id, $datec);
					}
					
					
				break;
			case '0':
				$aux += $book->checkAvailableTime($start_time, $end_time, $staff_id, $date);
			break;	
		}
	
	
	}
	
	
	echo $aux;
	
?>