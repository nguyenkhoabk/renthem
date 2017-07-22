<?php 
	$data = $_POST['data'];
	
	echo date('Y-m-d', strtotime('+1 month', strtotime($data)));
	
	
?>