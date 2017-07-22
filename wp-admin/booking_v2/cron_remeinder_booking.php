<?php
error_reporting(-1);
	/*define ("DB_HOST", "s507.loopia.se") ;
	define ("DB_USER", "wp@r115695") ;
	define ("DB_PASSWORD", "noby045082") ;
	define ("DB_DATABASE", "renthem_se_db_1") ;  
*/

 define ("DB_HOST", "localhost") ;
	define ("DB_USER", "admin_renthem") ;
	define ("DB_PASSWORD", "^M^Q9@i2#t40gRix") ;
	define ("DB_DATABASE", "admin_renthem") ;  
	
	
	
	$dbh = mysql_connect( DB_HOST, DB_USER, DB_PASSWORD );
	mysql_selectdb( DB_DATABASE, $dbh );
		
		
		$sqlStatus = "SELECT * FROM email_status WHERE id = 1";
		$resultStatus = mysql_query($sqlStatus) or die(mysql_error());
		$rowStatus = mysql_fetch_assoc( $resultStatus );

	if ($rowStatus['status'] == 1) {	
		
	$day_search =  date("Y-m-d",strtotime("+1 day", time()));
	$day_no =  date("N",strtotime("+1 day", time()));
	switch ($day_no) {
		case '1':
				$day_name = "Måndag";
			break;
		case '2':
				$day_name = "Tisdag";
			break;
		case '3':
				$day_name = "Onsdag";
			break;
		case '4':
				$day_name = "Torsdag";
			break;
		case '5':
				$day_name = "Fredag";
			break;
		case '6':
				$day_name = "Lördag";
			break;
		case '7':
				$day_name = "Söndag";
			break;
			
	}
	$sql = "SELECT * FROM book WHERE date = '$day_search' GROUP BY book_id ";
	$result = mysql_query($sql) or die(mysql_error());
	while( $row = mysql_fetch_assoc( $result ) ) {
	echo	$client_id =  $row['client_id'];
		
		$sqlClient = "SELECT * FROM client WHERE id = '$client_id'";
		$resultClient = mysql_query($sqlClient) or die(mysql_error());
		$rowClient = mysql_fetch_assoc( $resultClient );
	echo ' --- ';	
		echo $first_name = $rowClient['first_name'];
		echo $last_name = $rowClient['last_name'];
	echo ' --- ';
		echo $email_dest = $rowClient['email'];
	echo ' --- ';	
		$email_body ="Hej ".$first_name." ".$last_name."<br/>
		<br/>
Vi vill påminna dig om att vi kommer och gör ditt hem rent och fint på ".$day_name.", ".$day_search .".<br/>

<br/><br/>
<br/>
Med Vänlig Hälsning<br/>
Rent Hem (08-82 44 77)<br/>
www.renthem.se<br/>
<br/>
<br/>
(detta är ett automatiskt mailutskick och går inte att svara på)";
			 $email_subject = "Påminnelse städbesök på ".$day_name;

				$sub = '=?UTF-8?B?'.base64_encode($email_subject).'?=';
				$headers = "MIME-Version: 1.0\n" .
							"Content-type: text/html; charset=utf-8\n" .
							"From: Rent Hem <noreply@renthem.se>\n" .
							"Reply-To: Rent Hem <noreply@renthem.se>\n" .
							"X-Mailer: PHP/" . phpversion();
						


		//$email_dest = "nobynator@gmail.com";					
				
	  mail($email_dest, $sub, $email_body, $headers);	
				 echo '<br/>'; 
	}	
}


?>
