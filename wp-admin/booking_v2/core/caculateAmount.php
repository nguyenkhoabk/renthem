<?php
	include("../core.php");
	$size = $_POST['size'];
	$service_id = $_POST['service'];
	$frequency = $_POST['frequency'];
	
	if ($size != "") {
	$price = $service->getServicePrice(" amount ", "  ( ".$size." BETWEEN start_value AND end_value )  AND frequency = '".$frequency."' AND service_id = '".$service_id."' " , "");
	if (count($price) == 1) {
		echo $price[0]['amount'];
	} else {
		echo '0.00';
	}
	}else {
		echo '0.00';
	}
	
?>