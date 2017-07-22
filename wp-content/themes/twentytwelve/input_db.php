<?php
	$standing=$_GET['standing'];
	$start=$_GET['start'];
	$often=$_GET['often'];
	$amount=$_GET['amount'];
	$Display_date=$_GET['Display_date'];
	$timeval=$_GET['timeval'];
	$name=$_GET['name'];
	$address=$_GET['address'];
	$postno=$_GET['postno'];
	$city=$_GET['city'];
	$kvm=$_GET['kvm'];
	$mobileno=$_GET['mobileno'];
	$email=$_GET['email'];
	$custommessag=$_GET['custommessag'];
	
	include('../../../wp-config.php' );
	
	global $jal_db_version;
	$jal_db_version = "1.0";
	function jal_install() 
	{
	   global $wpdb;
	   global $jal_db_version;
		
	   $table_name = $wpdb->prefix . "bookings";
		 
	   $sql = "CREATE TABLE IF NOT EXISTS $table_name (
					  `Id` bigint(20) NOT NULL auto_increment,
					  `standing` varchar(50) NOT NULL,
					  `start` varchar(50) NOT NULL,
					  `often` varchar(50) NOT NULL,
					  `amount` varchar(50) NOT NULL,
					  `Display_date` date NOT NULL,
					  `timeval` varchar(50) NOT NULL,
					  `name` varchar(200) NOT NULL,
					  `address` text NOT NULL,
					  `postno` varchar(50) NOT NULL,
					  `city` varchar(200) NOT NULL,
					  `kvm` varchar(50) NOT NULL,
					  `mobileno` varchar(20) NOT NULL,
					  `email` varchar(200) NOT NULL,
					  `custommessag` varchar(200) NOT NULL,
					  PRIMARY KEY  (`Id`)
		);";
	   include('../../../wp-admin/includes/upgrade.php' );
	   dbDelta( $sql );
	 
	   add_option( "jal_db_version", $jal_db_version );
	   
	 
	  
	
	}
	$often=$_GET['often'];
	$amount=$_GET['amount'];
	$Display_date=$_GET['Display_date'];
	$timeval=$_GET['timeval'];
	$name=$_GET['name'];
	$address=$_GET['address'];
	$postno=$_GET['postno'];
	$city=$_GET['city'];
	$kvm=$_GET['kvm'];
	$mobileno=$_GET['mobileno'];
	$email=$_GET['email'];
	$custommessag=$_GET['custommessag'];
	jal_install();
	$table_name = $wpdb->prefix . "bookings";
	$wpdb->insert( 
			$table_name, 
			array( 
				'standing' => $standing, 
				'start' => $start,
				'often' => $often,
				'amount' => $amount,
				'Display_date' => $Display_date,
				'timeval' => $timeval,
				'name' => $name,
				'address' => $address,
				'postno' => $postno,
				'city' => $city,
				'kvm' => $kvm,
				'mobileno' => $mobileno,
				'email' => $email,
				'custommessag' => $custommessag,
				'orderTime' => current_time('mysql',1),
				'StaffId' => 1
			)
		);
		
	//echo  $wpdb->show_errors();
	//echo '==========';
	//echo $wpdb->last_query;
	$owner_email = get_option( 'admin_email' );
	$headers = 'From:' . $_GET["email"];
	$subject = 'A message from your site visitor: ' . $_GET["name"];
	$messageBody = "";
	
	if($_GET['name']!=''){
		$messageBody .= '<p>Name : ' . $_GET["name"] . '</p>' . "\n";
	}
	if($_GET['email']!=''){
		$messageBody .= '<p>Email Address: ' . $_GET['email'] . '</p>' . "\n";
	}else{
		$headers = '';
	}
	if($_GET['standing']!=''){		
		$messageBody .= '<p>Standing: ' . $_GET['standing'] . '</p>' . "\n";
	}
	if($_GET['start']!=''){		
		$messageBody .= '<p>Hurt ofta?: ' . $_GET['start'] . '</p>' . "\n";
	}
	if($_GET['often']!=''){		
		$messageBody .= '<p>Hurt stort?: ' . $_GET['often'] . '</p>' . "\n";
	}
	if($_GET['amount']!=''){		
		$messageBody .= '<p>Amount: ' . $_GET['amount'] . '</p>' . "\n";
	}				
	if($_GET['Display_date']!=''){		
		$messageBody .= '<p>Date: ' . $_GET['Display_date'] . '</p>' . "\n";
	}
	if($_GET['timeval']!=''){		
		$messageBody .= '<p>Time: ' . $_GET['timeval'] . '</p>' . "\n";
	}		
	SendMailToAdmin($name,$email,$owner_email, "", "", $subject,$messageBody, 1);
	
	$owner_email = $email;
	$headers = 'From:' . get_option( 'admin_email' );
	$subject = 'Booking Request : Reply';
	
	$messageBodyCust = '<p>Thanks for your booking request. We will contact you soon</p>'. "\n";
	$messageBodyCust .= '<h3>Booking Details : </h3>';
	$messageBodyCust .=$messageBody;
	$messageBody =$messageBodyCust;
	SendMailToAdmin("Admin",get_option( 'admin_email' ),$owner_email, "", "", $subject,$messageBody, 1);
	
	echo "<strong><center><font size='+1' style='color:green'>Thank You for booking we will contact you soon.</center></strong>";
	
?>
<?php
	
function SendMailToAdmin($myName,$myFrom,$myTo, $myCCList, $myBCCList, $mySubject,$myMsg, $MailFormat)
	{
		 if(!isset($MailFormat) || ($MailFormat!=0 && $MailFormat!=1))
			$MailFormat = 1;
		  
		 if($MailFormat==1)
		 {
		  $myMsgTop = "<table border='0' cellspacing='0' cellpadding='2' width='95%'>
		   <tr><td><font face='verdana' size='2'>";
		 
		  $myMsgBottom = "</font></td></tr></table>";
		 }
		 else
		 {
		  $myMsg = strip_tags($myMsg);
		  $myMsg = str_replace("\t","",$myMsg);
		  $myMsg = str_replace("&nbsp;","",$myMsg);
		  $myMsgTop = "";
		  $myMsgBottom = "";
		 }
		 
		 $headers = "From: $myName <$myFrom>\n";
		 $headers .= "X-Sender: <$myFrom>\n";
		 $headers .= "X-Mailer: PHP\n"; // mailer
		 $header.= "MIME-Version: 1.0\r\n"; 
		 $header.= "Content-Type: text/html; charset=utf-8\r\n"; 
		 $header.= "X-Priority: 1\r\n"; 
		 
		 		 $headers .= "Return-Path: <$myFrom>\n";  // Return path for errors
		 
		 

		 
		
		 if($MailFormat == 1)
		  $headers .= "Content-Type: text/html; charset=iso-8859-1\n"; // Mime type
		
		 if(isset($myCCList) && strlen(trim($myCCList)) > 0)
		  $headers .= "cc: $myCCList\n"; 
		
		 if(isset($myBCCList) && strlen(trim($myBCCList)) > 0)
		  $headers .= "bcc: $myBCCList\n"; 
		
		 $receipient = $myTo;
		 $subject = $mySubject;
		 $message = $myMsgTop.$myMsg.$myMsgBottom;
		
		 @mail($receipient,$subject,$message,$headers);
	}
?>
