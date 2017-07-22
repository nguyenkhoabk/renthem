<?php
	include("core.php");
	
	if (isset($_POST['action']) && !empty($_POST['action']) && ($_POST['action'] == "saveBooking")) {
		$data = array();
		
		$clean_service = explode("::",$_POST['clean_service']);
		$data['clean_service_frequency'] = $clean_service[0];
		$data['clean_service_id'] = $clean_service[1];
		
		$data['window_service_id'] = $_POST['window_service'];
		$data['window_no'] = $_POST['window_no'];

		$data['first_name'] = $_POST['frmBookFirstName'];
		$data['last_name'] = $_POST['frmBookLastName'];
		$data['street'] = $_POST['frmBookStreet'];
		$data['zip'] = $_POST['frmBookZip'];
		$data['city'] = $_POST['frmBookCity'];
		$data['size'] = $_POST['frmBookSize'];
		$data['mobile'] = $_POST['frmBookMobile'];
		$data['email'] = $_POST['frmBookEmail'];
		$data['data'] = $_POST['frmBookDate'];
	//	$data['comment'] = $_POST['frmBookComment'];
		$data['hour'] = $_POST['frmBookHour'];
		$data['up_date'] = time();
		
		$book = new book();
		$book_id =  $book->setBookPending($data);
		
		$dataComment = array();
		$dataComment['comment'] = $_POST['frmBookComment'];
		$dataComment['book_id'] = "pen-".$book_id;
		
		$book->setBookComment($dataComment);
			// send email
			
			$subject = "Din bokning renthem.se";
			$body = '
			
			<table width="650" align="center" style="margin:auto;width:650px;">
				<tr>
					<td valign="top" colspan="2" width="650" style="width:650px;"><img src="https://renthem.se/logo_email.png" /></td>
				</tr>
				<tr>
					<td colspan="2" valign="top" width="650" style="width:650px;">
					<p>Hej '.$data['first_name'].' '.$data['last_name'].'</p><br/>
<p>Tack f&ouml;r eran bokning, en orderbekr&auml;ftelse kommer att skickas ut inom 5 arbetstimmar till eran e-mail med era bokningsuppgifter.</p>
<br/>
<p>Med V&auml;nliga H&auml;lsningar<br/>
Rent Hem</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
					<img src="https://renthem.se/cities_email.png" />
					</td>
				</tr>
			</table>';
			$email = $_POST['frmBookEmail'];
			
			$headers = "MIME-Version: 1.0\n" .
						"Content-type: text/html; charset=utf-8\n" .
						"From: ".EMAIL."\n" .
						"Reply-To: ".EMAIL."\n" .
						"X-Mailer: PHP/" . phpversion();
							
			 $go = mail($email, $subject, $body, $headers);	
	
	
	// send to admin
	
		
				
//	$service_id; $service_window_id;			
		$service_all_name = "";			
	$serviceFront = $service->getService("*", " id = '".$data['clean_service_id']."' ",  array('position'=> 'ASC'));
	$service_name = "";
	if (count($serviceFront) != 0) {
		$service_name = $serviceFront[0]['name'];
	}	
	$freq_text = "";
		if ($data['clean_service_id'] == 1) {
		switch ($data['clean_service_frequency']) {
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
	
	$serviceFront = $service->getService("*", " id = '".$data['window_service_id']."' ",  array('position'=> 'ASC'));
	$window_name = "";
	if (count($serviceFront) != 0) {
		$window_name = $serviceFront[0]['name'];
		if ($service_all_name != "") {
			$service_all_name .= " - ".$window_name;
		}
	}		


$price_total = 0;	
if ($data['size']!= "") {
	$servicePrice = $service->getServicePrice("*", " (".$data['size']." BETWEEN start_value AND end_value ) AND ( service_id = '".$data['clean_service_id']."')  AND (frequency = ".$data['clean_service_frequency'].")", "" );

	if (count($servicePrice) != 0) {
	$price_total +=$servicePrice[0]['amount'];
	$book_details['price_size'] =$servicePrice[0]['amount'];
	}
}else {
$book_details['price_size'] = 0;
}
if ($data['window_no']!="") {
	$servicePrice = $service->getServicePrice("*", " (".$data['window_no']." BETWEEN start_value AND end_value ) AND ( service_id = '".$data['window_service_id']."')", "" );

	if (count($servicePrice) != 0) {
	$price_total +=$servicePrice[0]['amount'];
	$book_details['price_windows']  =$servicePrice[0]['amount'];
	}
} else {
$book_details['price_windows']  =0;
}

$order_no_txt = "";
if ($data['size']!="" ) {
	$order_no_txt = $data['size']. ' kvm';
}	
if ($order_no_txt != "") {
	if ($data['window_no'] != "") {
		$order_no_txt .= " / ".$data['window_no'].' f&ouml;nster';
	}
} else {
	if ($data['window_no'] != "") {
		$order_no_txt .= $data['window_no'].' f&ouml;nster';
	}
}


$subject = "Ny kundbokning";
			$body = '<table width="800" align="center" style="margin:auto;width:800px;">
		
				<tr>
					<td  valign="top" width="800" style="width:800px;">
				
<table width="800" style="width:800px;">
	<tr>
		<td width="400" style="width:400px;"><b>Din best&auml;llning :</b></td>
		<td width="400" style="width:400px;"><b>Dina uppgifter :</b></td>
	</tr>
	<tr>
		<td width="400" style="width:400px;">St&auml;dning: '.$service_all_name.'</td>
		<td width="400" style="width:400px;">Namn: '.$data['first_name'].' '.$data['last_name'].'</td>
	</tr>
	<tr>
		<td width="400" style="width:400px;">Hur ofta?: '.$freq_text.'</td>
		<td width="400" style="width:400px;">Gatuadress: '.$data['street'].'</td>
	</tr>
	<tr>
		<td width="400" style="width:400px;">Hur stort?: '.$order_no_txt.'</td>
		<td width="400" style="width:400px;">Postnummer/Ort: '.$data['zip'].' '.$data['city'].'</td>
	</tr>
	<tr>
		<td width="400" style="width:400px;">Kostnad efter RUT(kr): '.$price_total.'</td>
		<td width="400" style="width:400px;">Mobilnr: '.$data['mobile'].'</td>
	</tr>
	<tr>
		<td width="400" style="width:400px;">Datum: '.$data['data'].'</td>
		<td width="400" style="width:400px;">E-post: '.$data['email'].'</td>
	</tr>

</table>

					</td>
				</tr>
			
			</table>';
		
			$headers = "MIME-Version: 1.0\n" .
						"Content-type: text/html; charset=utf-8\n" .
						"From: bokning@renthem.se\n" .
						"Reply-To: bokning@renthem.se\n" .
						"X-Mailer: PHP/" . phpversion();
							
			 $go = mail("bokning@renthem.se", $subject, $body, $headers);	
		
			// $go = mail("ciprian.timpau@yahoo.com", $subject, $body, $headers);	

	
	
	
	
	
	
	
	
	}
?>