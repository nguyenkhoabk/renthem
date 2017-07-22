z<?php
	include("../core.php");
	$name = "";
	if (isset($_POST['action']) && !empty($_POST['action'])) {
		switch ($_POST['action']) {
			case 'add':
				//setup client
				$pending_book_id = $_POST['pending_book_id'];
				$sendUserEmail = $_POST['sendUserEmail'];
				
				
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
				
				
				$data = array();
				$data['first_name'] = $_POST['first_name'];
				$data['last_name'] = $_POST['last_name'];
				$data['email'] = $_POST['email'];
				$data['city'] = $_POST['city'];
				$data['zipcode'] = $_POST['zip'];
				$data['address'] = $_POST['address'];
				$data['phone'] = $_POST['mobile'];
				
				
				$name = $_POST['first_name'].' '.$_POST['last_name'];
				$email = $_POST['email'];
				$city = $_POST['city'];
				$zipcode = $_POST['zip'];
				$address = $_POST['address'];
				$phone = $_POST['mobile'];
				
				
		//		$data['comment'] = mysql_real_escape_string($_POST['comment']);
				
				$client_id = $client->setClient($data);
			
			//setup booking 	
				$book_details = array();
				
				$size = $_POST['size'];
				$window =  $_POST['window'];
	

$price_total = 0;	
if ($size != "") {
	$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id."')  AND (frequency = ".$frequency.")", "" );

	if (count($servicePrice) != 0) {
	$price_total +=$servicePrice[0]['amount'];
	$book_details['price_size'] =$servicePrice[0]['amount'];
	}
}else {
$book_details['price_size'] = 0;
}
if ($window!="") {
	$servicePrice = $service->getServicePrice("*", " (".$window." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_window_id."')", "" );

	if (count($servicePrice) != 0) {
	$price_total +=$servicePrice[0]['amount'];
	$book_details['price_windows']  =$servicePrice[0]['amount'];
	}
} else {
$book_details['price_windows']  =0;
}
	
				$book_details['frequency'] = $frequency;
				$book_details['size'] = $_POST['size'];
				
				$book_details['special_offer'] = $_POST['special_offer'];
				$book_details['total'] = $_POST['total'];
				
				
				$book_details['window'] = $_POST['window'];
			//	$book_details['price_size'] = $_POST['price_size'];
				//$book_details['price_windows'] = $_POST['price_windows'];
				$book_details['service_id'] =$service_id;
				$book_details['service_window_id'] =$service_window_id;
				$book_details['date'] = $_POST['date'];
				
	
				$book_id = $book->setBookDetails($book_details);
			// setup comment	
				$book_comment = array();
				$book_comment['comment'] = $_POST['comment'];
				$book_comment['book_id'] = $book_id;
				
				$book->setBookComment($book_comment);
				// send email confirmation
$start_hour = $_POST['start_hour'];

	$hour_tmp = $work_hour->getHour("*", " id = '".$start_hour."' ");
	$start_hour = str_pad($hour_tmp[0]['start_hour'], 2, "0", STR_PAD_LEFT). ':'.str_pad($hour_tmp[0]['start_minute'], 2, "0", STR_PAD_LEFT) ;			
	
	$end_hour = $_POST['end_hour'];
	

	$hour_tmp = $work_hour->getHour("*", " id = '".$end_hour."' ");
	$end_hour = str_pad($hour_tmp[0]['start_hour'], 2, "0", STR_PAD_LEFT) . ':'.str_pad($hour_tmp[0]['start_minute'], 2, "0", STR_PAD_LEFT);

	$date = $_POST['date'];
			
				
//	$service_id; $service_window_id;			
		$service_all_name = "";			
	$serviceFront = $service->getService("*", " id = '".$service_id."' ",  array('position'=> 'ASC'));
	$service_name = "";
	if (count($serviceFront) != 0) {
		$service_name = $serviceFront[0]['name'];
	}	
	$freq_text = " - ";
		if ($service_id == 1) {
		switch ($frequency) {
			case '1':
					$service_name .= " en g&aring;ng i m&aring;naden ";
					$freq_text = "en g&aring;ng i m&aring;naden";
				break;
			case '2':
					$service_name .= " varannan vecka ";
					$freq_text = "varannan vecka";
				break;
			case '4':
					$service_name .= " varje vecka ";
					$freq_text = "varje vecka";
				break;
			default:
				$freq_text = '1 g&aring;ng';
			break;
			
		}
	}
	
	$service_all_name = $service_name;
	
	$serviceFront = $service->getService("*", " id = '".$service_window_id."' ",  array('position'=> 'ASC'));
	$window_name = "";
	if (count($serviceFront) != 0) {
		$window_name = $serviceFront[0]['name'];
		if ($service_all_name != "") {
			$service_all_name .= " - ".$window_name;
		} else {
		$service_all_name .=$window_name;
		}
	}
	

	if (isset($_POST['special_offer']) && !empty($_POST['special_offer'])) {
		$price_total = $_POST['special_offer'];
	}

$order_no_txt = "";
if ($size !="" ) {
	$order_no_txt = $size. ' kvm';
}	
if ($order_no_txt != "") {
	if ($window != "") {
		if ( $service_id == 2 ) {
			$order_no_txt .= ' / Inkl.f&ouml;nster';
		}
		else {
			$order_no_txt .= " / ".$window.' f&ouml;nster';
		}
	}
} else {
	if ($window != "") {
		if ( $service_id == 2 ) {
			$order_no_txt .= ' Inkl.f&ouml;nster';
		}
		else {
			$order_no_txt .= $window.' f&ouml;nster';
		}
	}
}

$subject="=?utf-8?B?".base64_encode("Orderbekräftelse renthem.se")."?=";
//$subject = "Orderbekräftelse renthem.se";
			$body = '<table width="800" align="center" style="margin:auto;width:800px;">
				<tr>
					<td valign="top" width="800" style="width:800px;" colspan="2"><img src="http://renthem.se/logo_email.png" /></td>
				</tr>
				<tr>
					<td colspan="2" valign="top" width="800" style="width:800px;">
					<p>Hej '.$name.'</p>
<p>Tack för din bokning, härmed bekräftar vi den med följande uppgifter:</p>
	</td>
</tr>

	<tr>
		<td width="380" style="width:380px;"><b>Din best&auml;llning :</b></td>
		<td width="400" style="width:400px;"><b>Dina uppgifter :</b></td>
	</tr>
	<tr>
		<td width="380" style="width:380px;">St&auml;dning: '.$service_all_name.'</td>
		<td width="400" style="width:400px;">Namn: '.$name.'</td>
	</tr>
	<tr>
		<td width="380" style="width:380px;">Hur ofta?: '.$freq_text.'</td>
		<td width="400" style="width:400px;">Gatuadress: '.$address.'</td>
	</tr>
	<tr>
		<td width="380" style="width:380px;">Hur stort?: '.$order_no_txt.'</td>
		<td width="400" style="width:400px;">Postnummer/Ort: '.$zipcode.' '.$city.'</td>
	</tr>
	<tr>
		<td width="380" style="width:380px;">Kostnad efter RUT(kr): '.$price_total.'</td>
		<td width="400" style="width:400px;">Storlek p&aring; din bostad: '.$size.' kvm</td>
	</tr>
	<tr>
		<td width="380" style="width:380px;">Datum: '.$date.'</td>
		<td width="400" style="width:400px;">E-post: '.$email.'</td>
	</tr>
	<tr>
		<td width="380" style="width:380px;">Tidpunkt: '.$start_hour.' - '.$end_hour.'</td>
		<td  width="400" style="width:400px;">Mobilnr: '.$phone.'</td>
	</tr>
    <br>
Med denna bokning godkänner ni våra <a href="http://renthem.se/bokningsvillkor/">bokningsvillkor.</a>
<tr>
<td colspan="2"><br/>
<p>Med V&auml;nliga H&auml;lsningar<br/>
Rent Hem<br>
08-82 44 77</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
					<img src="http://renthem.se/cities_email.png" />
					</td>
				</tr>
			</table>';
		
			$headers = "MIME-Version: 1.0\n" .
						"Content-type: text/html; charset=utf-8\n" .
						"From: ".EMAIL."\n" .
						"Reply-To: ".EMAIL."\n" .
						"X-Mailer: PHP/" . phpversion();
	if ($sendUserEmail == 1) {						
		 $go = mail($email, $subject, $body, $headers);	

		}	 


			
			// setup booking	
				$start_hour = $_POST['start_hour'];
				$end_hour = $_POST['end_hour'];
				$date = $_POST['date'];
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
	
	
	
								
							
		/*			for ($t = 1; $t <= 11; $t ++) {
							$dated= date('Y-m-d', strtotime('+'.$t.' month', strtotime($vec[0].'-'.$vec[1].'-'.$vec[2])));
							$start_hour = $_POST['start_hour'];
							$end_hour = $_POST['end_hour'];
							for ($i = $start_hour; $i < $end_hour; $i++ ) {
								$book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff, "date" => $dated, "time_id" => $i));
							}
					}	*/
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
				
			
			
			if (isset($pending_book_id) && !empty($pending_book_id)) {
				$book->delBookPeending( ' id = "'.$pending_book_id.'"');
				$book->delBookCommentPeending( ' book_id = "pen-'.$pending_book_id.'"');
			}
			
				
			break;
		}
	}
	
	
?>