<?php
	include("../core.php");

	if (isset($_POST['action']) && !empty($_POST['action'])) {
		switch ($_POST['action']) {
			case 'delete':
					$id = $_POST['id'];
					
					$where = " id = ".$id;
					
					echo $service->delServicePrice($where);
				break;
		}
	}
	
	
?>