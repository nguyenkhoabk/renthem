<?php
	include("../core.php");
	$book_id =  $_POST['book_id'];
	if (isset($_POST['start_date']) && !empty($_POST['start_date'])) {
		$start_date = $_POST['start_date'];
	}
	if (isset($_POST['end_date']) && !empty($_POST['end_date'])) {
		$end_date = $_POST['end_date'];
	}
	$books = $book->getBookDates($book_id);
	
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
	echo '<h1>Cleaning Dates:</h1>';
	echo '<table style="border:0px solid !important;"> <tr style="border:0px solid !important;"><td style="border:0px solid !important;width:350px !important;">';
	echo '<table style="width:300px !important;">';
	foreach($vector as $value ) {
	
		if ( (strtotime($value['dates']['data']."00:00") > strtotime($start_date ." 00:00")) && (strtotime($value['dates']['data']."00:00") < strtotime($end_date ." 23:59"))) {
			if ($curent_month != $value['month']) {
				echo '<tr>
					<td colspan="2">'.showMonthName($value['month']).'</td>
				</tr>';
				$curent_month = $value['month'];
			}
			
			$hour_1 = $work_hour->getHour("*"," id = '".$value['dates']['start-hour']."'",array('start_hour'=> 'ASC','start_minute'=> 'ASC'));
			$hour_2 = $work_hour->getHour("*", " id = '".($value['dates']['end-hour']+1)."'",array('start_hour'=> 'ASC','start_minute'=> 'ASC'));

			
			echo '<tr>
				<td width="200">'.$value['dates']['data'].'</td>
				<td>'.str_pad($hour_1[0]['start_hour'], 2, '0', STR_PAD_LEFT).'<sup>'.str_pad($hour_1[0]['start_minute'], 2, '0', STR_PAD_LEFT).'</sup> - '.str_pad($hour_2[0]['start_hour'], 2, '0', STR_PAD_LEFT).'<sup>'.str_pad($hour_2[0]['start_minute'], 2, '0', STR_PAD_LEFT).'</td>
			</tr>';
		
		}
	}
	echo '</table></td>';
	/*
		[month]
			[data]
			[start-hour]
			[end-hour]
	
	*/
	
?>
<td style="border:0px solid !important;" valign="bottom">
	<button class="btn b-cancel" type="button" onclick="return sendCleaningDateEmail('<?=$book_id?>')">Send Email to Client</button>
</td>
<td style="border:0px solid !important;" valign="bottom"><input type="text" name="clean_date_start" id="clean_date_start" class="caledar" style="text-align: center;" value="<?=$start_date?>" /></td>
<td style="border:0px solid !important;" valign="bottom"><input type="text" name="clean_date_end" id="clean_date_end" class="caledar" style="text-align: center;" value="<?=$end_date ?>" /></td>
<td style="border:0px solid !important;" valign="bottom"><button class="btn b-save" type="button" onclick="return cleaningDatesInterval('<?=$book_id?>');">Update List</button></td>
</tr>
</table>

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