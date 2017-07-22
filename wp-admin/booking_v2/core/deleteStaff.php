<?php
	include("../core.php");
	
	if (isset($_POST['action']) && !empty($_POST['action'])) {
		switch ($_POST['action']) {
			case 'delete':
					$id = $_POST['id'];
					$data = array();
					$data['mark_delete'] = 1; 
					$where = " id = ".$id;
					
					echo $staff->upStaff($data,$where);
				break;
		}
	}
	
?>