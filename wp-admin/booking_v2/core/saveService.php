<?php
	include("../core.php");
	
	if (isset($_POST['action']) && !empty($_POST['action'])) {
		switch ($_POST['action']) {
			case 'add':
					$data = array();
						$data['name'] = $_POST['service_name'];
						$data['background'] = $_POST['background'];
						
						$data['show_on'] = $_POST['show_on'];
						$data['type'] = $_POST['service_type'];
						$data['position'] = $_POST['service_position'];
						$data['url'] = $_POST['service_url'];
						
						$id =  $service->setService($data);
						
				break;
		}
	}

?>
<tr id="service_row_<?=$id?>">
									<td><?=$data['name']?></td>
									<td align="center"><?=$data['position']?></td>
									<td style="background-color:<?=$data['background']?> !important;"></td>
									<td style="text-align: center !important;">
										<a href="javascript:;" onclick="editService('<?=$id?>');">edit</a>  &nbsp; &#9679; &nbsp;
										<a href="javascript:;" onclick="deleteService('<?=$id?>');">delete</a>
									</td>
								</tr>	  