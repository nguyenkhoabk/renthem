<?php
	include("../core.php");
	
	$size = $_POST['add_size'];
	$windows = $_POST['add_windows'];
	$clean_service = $_POST['clean_service'];
	
	$serviceFront = $service->getService("*", "",  array('position'=> 'ASC'));
echo '<table width="100%">';
	foreach($serviceFront as $value) {
		//freq 0
		$service_id = $value['id'];
		
		if ($value['type'] == 2) {
		$amount = 0; 
		if ($windows != 0) {
				$servicePrice = $service->getServicePrice("*", "(".$windows." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id."')  AND (frequency = 0)", "" );
				$amount = $servicePrice[0]['amount'];
		} else {
			$servicePrice = $service->getServicePrice("*", " ( service_id = '".$service_id."')  AND (frequency = 0)", "" );
		}
		if (count($servicePrice) != 0) {
?>
	<tr>
		<td>Fönsterputsning</td>
	
		<td id="window_price_<?=$service_id?>"><span id="window_price"><?=(int)$amount?></span> <span>Kr</span> </td>
		<td><input type="checkbox" value="<?=$service_id?>" onclick="getTotalPrice() " <?php if ($amount != 0) { echo 'CHECKED' ;} ?>		 name="window_service" id="window_id_0_<?=$service_id?>" class="regular-checkbox big-checkbox" /></td>
	</tr>


<?php
			}
		} else {



	//freq 1
$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id."')  AND (frequency = 1)", "" );
		if (count($servicePrice) == 1) {
?>
	<tr>
		<td><?=$value['name']?> <?php if ($service_id == 1) { echo 'en gång i månaden';}?> </td>
		
		<td><span id="clean_price_1_<?=$service_id?>"><?=(int)$servicePrice[0]['amount'] *1 ?></span> <span>Kr</span> </td>
		<td> <input type="checkbox" value="1::<?=$service_id?>" <?php if ($clean_service == "1::".$service_id) { echo 'CHECKED'; }?> onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_1_<?=$service_id?>" class="regular-checkbox big-checkbox" /></td>
	</tr>

<?php
}
		//freq 2
$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id."')  AND (frequency = 2)", "" );
		if (count($servicePrice) == 1) {
?>
	<tr>
		<td><?=$value['name']?> <?php if ($service_id == 1) { echo 'varannan vecka';}?></td>
		
		<td><span id="clean_price_2_<?=$service_id?>"><?=(int)$servicePrice[0]['amount']*2?></span> <span>Kr</span> </td>
		<td><input type="checkbox"  value="2::<?=$service_id?>" <?php if ($clean_service == "2::".$service_id) { echo 'CHECKED'; }?>  onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_2_<?=$service_id?>" class="regular-checkbox big-checkbox" /></td>
	</tr>
		

<?php
}
		//freq 4
$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id."')  AND (frequency = 4)", "" );
		if (count($servicePrice) == 1) {
?>
	<tr>	
		<td><?=$value['name']?> <?php if ($service_id == 1) { echo 'varje vecka';}?></td>
		
		<td><span id="clean_price_4_<?=$service_id?>"><?=(int)$servicePrice[0]['amount']*4?></span> <span>Kr</span></td>
		<td><input type="checkbox" value="4::<?=$service_id?>" <?php if ($clean_service == "4::".$service_id) { echo 'CHECKED'; }?> onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_4_<?=$service_id?>" class="regular-checkbox big-checkbox" /></td>
	</tr>
	
<?php
}


		$servicePrice = $service->getServicePrice("*", " (".$size." BETWEEN start_value AND end_value ) AND ( service_id = '".$service_id."')  AND (frequency = 0)", "" );
		if (count($servicePrice) == 1) {
?>
	<tr>
		<td><?=$value['name']?></td>
		
		<td><span id="clean_price_0_<?=$service_id?>"><?=(int)$servicePrice[0]['amount']?></span> <span>Kr</span> </td>
		<td><input type="checkbox"  value="0::<?=$service_id?>" <?php if ($clean_service == "0::".$service_id) { echo 'CHECKED'; }?>  onclick="Checkbox_to_RadioButton(this);" name="clean_service"  id="clean_id_0_<?=$service_id?>" class="regular-checkbox big-checkbox" /></td>
	</tr>
	
	
<?php
}
	


		} // if type
	}
?>
</table>