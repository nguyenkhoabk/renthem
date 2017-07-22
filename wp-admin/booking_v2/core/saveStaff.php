<?php
	include("../core.php");
	
	if (isset($_POST['action']) && !empty($_POST['action'])) {
		switch ($_POST['action']) {
			case 'add':
					$data = array();
						$data['name'] = $_POST['staff_name'];
						$data['phone'] = $_POST['staff_phone'];
						$data['email'] = $_POST['staff_email'];
						
						$id =  $staff->setStaff($data);
						
				break;
		}
	}

?>

	<tr id="staff_row_<?=$id?>">
	  								<td><?=$data['name']?></td>
	  								<td><?=$data['phone']?></td>
	  								<td><?=$data['email']?></td>
	  								<td style="text-align: center !important;">
	  									<a href="javascript:;" onclick="editStaff('<?=$id?>');">edit</a> 	&nbsp; &#9679; &nbsp;
	  									<a href="javascript:;" onclick="deleteStaff('<?=$id?>');">delete</a>
	  								</td>
	  							</tr>