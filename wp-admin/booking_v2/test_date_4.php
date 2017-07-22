<?php
if (isset($_POST['data'])) {
$data = $_POST['data'];


	
	
	// 0 even
	// 1 not even
	$even_status = 0 ;
	$week_number = date("W", strtotime($data));
	if ($week_number % 2 == 1) {
		$even_status = 1 ;
	}
	
	$previous_month =  date("n", strtotime($data));
	echo '<br/>Date '. $data;
	echo '<br/>Week Number: '.$week_number;
	
	echo '<br/><br/>';
	
	
	for ($i = 1; $i < 11; $i++) {
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
		echo '<br/>Date '. $data;
		$week_number =  date("W", strtotime($data));
		echo '<br/>Week Number: '.$week_number;
		echo '<br/><br/>';
	}
	
}
?>



<form action="" method="post">
<input type="text" name="data" value="" />
<input type="submit" name="" value="CHECK" />
</form>

<p>Date format: "yyyy-mm-dd"</p>