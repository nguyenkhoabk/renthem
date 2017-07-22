<?php
	include("../core.php");
	$book_id =  $_POST['book_id'];
	$clean_date_end =  $_POST['clean_date_end'];
	$clean_date_start =  $_POST['clean_date_start'];
	
	$books = $book->getBookDates($book_id);
	$email_table = '';
$vector = array();

	$curent_month = "";
	$curent_date = "";
	$curent_start_hour = "";
	$curent_end_hour = "";
	$month_count = -1;
	$tmp_data = "";
	foreach($books as $value) {
		$data = $value['date'];
		
		$vec = explode("-", $data);
		if (($tmp_data == '')  ||  ($tmp_data != $data) ) {
		$month_count ++;
			$vector[$month_count]['month'] = $vec[1];
			$vector[$month_count]['dates']['data'] = $data;
			$vector[$month_count]['dates']['start-hour'] = $value['time_id'];
			$vector[$month_count]['dates']['end-hour'] = $value['time_id'];
			
			 $tmp_data = $data;
		} else 	if ($tmp_data == $data) {
			$vector[$month_count]['dates']['end-hour'] = $value['time_id'];
			
		}
		
		
	}

	
	$curent_month = -1;
		$email_table .= '<table style="width:350px !important;">';
	foreach($vector as $value ) {
		if($clean_date_end != $clean_date_start) {
				if ( (strtotime($value['dates']['data']."00:00") > strtotime($clean_date_start ." 00:00")) && (strtotime($value['dates']['data']."00:00") < strtotime($clean_date_end ." 23:59"))) {
				if ($curent_month != $value['month']) {
					$email_table .=  '<tr>
						<td colspan="2"><b>'.showMonthName($value['month']).'</b></td>
					</tr>';
					$curent_month = $value['month'];
				}
				$end_date = $value['dates']['end-hour']+1;
				$hour_1 = $work_hour->getHour("*"," id = '".$value['dates']['start-hour']."'",array('start_hour'=> 'ASC','start_minute'=> 'ASC'));
				$hour_2 = $work_hour->getHour("*", " id = '".$end_date."'",array('start_hour'=> 'ASC','start_minute'=> 'ASC'));

				
				$email_table .= '<tr>
					<td width="250">'.$value['dates']['data'].'</td>
					<td>'.str_pad($hour_1[0]['start_hour'], 2, '0', STR_PAD_LEFT).'<sup>'.str_pad($hour_1[0]['start_minute'], 2, '0', STR_PAD_LEFT).'</sup> - '.str_pad($hour_2[0]['start_hour'], 2, '0', STR_PAD_LEFT).'<sup>'.str_pad($hour_2[0]['start_minute'], 2, '0', STR_PAD_LEFT).'</td>
				</tr>';
		
		}
		
		} else {
			if ($curent_month != $value['month']) {
				$email_table .=  '<tr>
					<td colspan="2"><b>'.showMonthName($value['month']).'</b></td>
				</tr>';
				$curent_month = $value['month'];
			}
			$end_date = $value['dates']['end-hour']+1;
			$hour_1 = $work_hour->getHour("*"," id = '".$value['dates']['start-hour']."'",array('start_hour'=> 'ASC','start_minute'=> 'ASC'));
			$hour_2 = $work_hour->getHour("*", " id = '".($end_date)."'",array('start_hour'=> 'ASC','start_minute'=> 'ASC'));

			
			$email_table .= '<tr>
				<td width="250">'.$value['dates']['data'].'</td>
				<td>'.str_pad($hour_1[0]['start_hour'], 2, '0', STR_PAD_LEFT).'<sup>'.str_pad($hour_1[0]['start_minute'], 2, '0', STR_PAD_LEFT).'</sup> - '.str_pad($hour_2[0]['start_hour'], 2, '0', STR_PAD_LEFT).'<sup>'.str_pad($hour_2[0]['start_minute'], 2, '0', STR_PAD_LEFT).'</td>
			</tr>';
		
		}
		
	}
	$email_table .=  '</table></td>';
	
	
	
	$book_info = $book->getBookDates($book_id);
	
	$client_id = $book_info[0]['client_id'];
	
	$client_info = $client->getClient(" * ", " id = '".$client_id."' ");
	
	$first_name = $client_info[0]['first_name'];
	$last_name = $client_info[0]['last_name'];
	$email = $client_info[0]['email'];

	$email_body = 'Hej '.$first_name.' '.$last_name.'<br/>
<br/>
Dina städtillfällen för år 2015:<br/><br/>

'.$email_table.'
<br/><br/>
Med Vänlig Hälsning<br/>
www.renthem.se<br/>
08-82 44 77';

$subject="=?utf-8?B?".base64_encode("Dina städtillfällen för ".date("Y"))."?=";

$headers = "MIME-Version: 1.0\n" .
						"Content-type: text/html; charset=utf-8\n" .
						"From: ".EMAIL."\n" .
						"Reply-To: ".EMAIL."\n" .
						"X-Mailer: PHP/" . phpversion();
			
		 $go = mail($email, $subject, $email_body, $headers);	
	 


	?>


<?php

 



	function showMonthName($month) {
		switch($month) {
			case '1': return 'Januari';	break;
			case '2': return 'Februari';	break;
			case '3': return 'Mars';	break;
			case '4': return 'April';	break;
			case '5': return 'Maj';	break;
			case '6': return 'Juni';	break;
			case '7': return 'Juli';	break;
			case '8': return 'Augusti';	break;
			case '9': return 'September';	break;
			case '10': return 'Oktober';	break;
			case '11': return 'November';	break;
			case '12': return 'December';	break;
		}
	}
	
?>