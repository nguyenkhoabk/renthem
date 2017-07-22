<?php
	include("../core.php");
	
	if (isset($_POST['action']) && !empty($_POST['action'])) {
		switch ($_POST['action']) {
			case 'add':
				//setup client
				$clean_service = $_POST['clean_service'];
				$clean_vec = explode("::",$clean_service);
				$service_id = $clean_vec[1];
				$frequency = $clean_vec[0];
				$name = $_POST['name'];

				$service_window_id = $_POST['window_service'];
				
				
				$data = array();
				$data['name'] = $_POST['name'];
				$data['email'] = $_POST['email'];
				$data['city'] = $_POST['city'];
				$data['zipcode'] = $_POST['zip'];
				$data['address'] = $_POST['address'];
				$data['phone'] = $_POST['mobile'];
				
				
				$name = $_POST['name'];
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

	
				$book_details['frequency'] = $frequency;
				$book_details['size'] = $_POST['size'];
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

	$hour_tmp = $hour->getHour("*", " id = '".$start_hour."' ");
	$start_hour = $hour_tmp[0]['start_hour']. ':'.$hour_tmp[0]['start_minute']. ;			
	
	$end_hour = $_POST['end_hour'];
	

	$hour_tmp = $hour->getHour("*", " id = '".$end_hour."' ");
	$end_hour = $hour_tmp[0]['start_hour']. ':'.$hour_tmp[0]['start_minute']. ;

	$date = $_POST['date'];
				
				
//	$service_id; $service_window_id;			
	$service_all_name = "";			
	$serviceFront = $service->getService("*", " id = '".$service_id."' ",  array('position'=> 'ASC'));
	$service_name = "";
	if (count($serviceFront) != 0) {
		$service_name = $serviceFront[0]['name'];
	}	
	$freq_text = "";
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
		}
	}
	

	
				
$subject = "Orderbekraftelse renthem.se";
			$body = '
			
			<table width="650" align="center" style="margin:auto;width:417px;">
				<tr>
					<td valign="top" width="650" style="width:650px;" colspan="2"><img src="https://renthem.se/logo_email.png" /></td>
				</tr>
				<tr>
					<td colspan="2" valign="top" width="650" style="width:650px;">
					<p>Hej '.$name.'</p><br/>
<p>Tack f&ouml;r eran bokning, h&auml;rmed bekr&auml;ftar vi eran bokning med f&ouml;ljande uppgifter:</p>
<br/>

<table width="450" style="width:450px;">
	<tr>
		<td width="225" style="width:225px;"><b>Din best&auml;llning :</b></td>
		<td width="225" style="width:225px;"><b>Dina uppgifter :</b></td>
	</tr>
	<tr>
		<td>St&auml;dning: '.$service_all_name.'</td>
		<td>Namn : '.$name.'</td>
	</tr>
	<tr>
		<td>Hur ofta?: ".$freq_text."</td>
		<td>Gatuadress : '.$address.'</td>
	</tr>
	<tr>
		<td>Hur stort?: '.$size.' kvm / '.$window.' f&ouml;nster</td>
		<td>Postnummer/Ort : '.$zipcode.' '.$city.'</td>
	</tr>
	<tr>
		<td>Kostnad efter RUT(kr): '.$price_total.'</td>
		<td>Storlek p&aring; din bostad : '.$size.'</td>
	</tr>
	<tr>
		<td>Datum: '.$date.'</td>
		<td>E-post: '.$email.'</td>
	</tr>
	<tr>
		<td>Tidpunkt: '.$start_hour.'- '.$end_hour.'</td>
		<td>Mobilnr: '.$phone.'</td>
	</tr>
</table>
<br>
Med denna bokning godkänner ni våra <a href="https://renthem.se/bokningsvillkor/">bokningsvillkor.</a>
<br>
<br/>
<p>Med Vänliga Hälsningar<br/>
Rent Hem</p>
<br><br>
Privatperson - presenterade priset är efter rut-avdrag och inkl. moms
Företag - presenterade priset är exkl. moms

					</td>
				</tr>
				<tr>
					<td colspan="2">
					<img src="https://renthem.se/cities_email.png" />
					</td>
				</tr>
			</table>';
			$email = $email;
			
			$headers = "MIME-Version: 1.0\n" .
						"Content-type: text/html; charset=utf-8\n" .
						"From: ".EMAIL."\n" .
						"Reply-To: ".EMAIL."\n" .
						"X-Mailer: PHP/" . phpversion();
							
			 $go = mail($email, $subject, $body, $headers);	

			 


			
			// setup booking	
				$start_hour = $_POST['start_hour'];
				$end_hour = $_POST['end_hour'];
				$date = $_POST['date'];
				$staff = $_POST['staff'];
				
		
				for ($i = $start_hour; $i < $end_hour; $i++ ) {
					
					$book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff, "date" => $date, "time_id" => $i));
			
				}
				$vec = explode("-", $date);
				switch ($frequency) {
					case '1':
						$date= date('d-m-Y', strtotime('+1 week', strtotime($vec[2].'-'.$vec[1].'-'.$vec[0])));
						$start_hour = $_POST['start_hour'];
						$end_hour = $_POST['end_hour'];
						
						$staff = $_POST['staff'];
						
				
						for ($i = $start_hour; $i < $end_hour; $i++ ) {
							
							$book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff, "date" => $date, "time_id" => $i));
					
						}
						break;
					case '2':
						$date= date('d-m-Y', strtotime('+2 week', strtotime($vec[2].'-'.$vec[1].'-'.$vec[0])));
						$start_hour = $_POST['start_hour'];
						$end_hour = $_POST['end_hour'];
					
						$staff = $_POST['staff'];
						
				
						for ($i = $start_hour; $i < $end_hour; $i++ ) {
							
							$book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff, "date" => $date, "time_id" => $i));
					
						}

						break;
					case '4':
						$date= date('d-m-Y', strtotime('+4 week', strtotime($vec[2].'-'.$vec[1].'-'.$vec[0])));
						$start_hour = $_POST['start_hour'];
						$end_hour = $_POST['end_hour'];
						
						$staff = $_POST['staff'];
						
				
						for ($i = $start_hour; $i < $end_hour; $i++ ) {
							
							$book->setBook(array("client_id" => $client_id, "book_id" => $book_id , "staff_id" => $staff, "date" => $date, "time_id" => $i));
					
						}

						break;
				}
				
				
			break;
		}
	}
	
	
?>