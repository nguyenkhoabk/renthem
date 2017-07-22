<?php	
	include("core.php");
	
	$service_id = $_POST['service_id'];
	$window_no = intval($_POST['window_no']);
	
	$servicePrice = $service->getServicePrice("*", " (".$window_no." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id."')  AND (frequency = 0)", "" );
	echo number_format($servicePrice[0]['amount'],0).' <span>Kr</span>';
?>