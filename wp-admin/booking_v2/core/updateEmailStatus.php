<?php
		include("../core.php");
		
	if ($_POST['status'] == "off") {
			$emailCls->upEmail(array("status"=> "0") , " id = 1");
	?>
						<button onclick="emailStatusChange('on');" class="btn b-email-off">Auto Email OFF</button> 		
					<?php	
						
	} else {
		$emailCls->upEmail(array("status"=> "1") , " id = 1");
	?>
						<button onclick="emailStatusChange('off');" class="btn b-email-on">Auto Email ON</button> 		
					<?php
	}

?>