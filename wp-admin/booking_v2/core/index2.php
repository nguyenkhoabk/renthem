<?php
	include("seven381/config.php");
	if (!isset($_SESSION['order_id']) || empty($_SESSION['order_id'])){
		$_SESSION['order_id'] = uniqid();
	}
	
	$page =  substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	$page="index.php";
	$sqlPage = "SELECT * FROM page WHERE source = '$page'";
	$resultPage = mysql_query($sqlPage) or die(mysql_error());
	$rowPage = mysql_fetch_assoc( $resultPage );
?>
<html lang="en">
  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Krenky Studio London, http://www.krenky.co.uk">
        <link rel="shortcut icon" href="favicon.ico">
   
        <title><?=$rowPage['meta_title']?></title>
		<meta name="description" xml:lang="en" lang="en" content="<?=$rowPage['meta_description']?>" />
        <meta name="keywords"  xml:lang="en" lang="en" content="<?=$rowPage['meta_keywords']?>" />
        <link href="css/grill.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
        
        <link href='//fonts.googleapis.com/css?family=Archivo+Black' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Libre+Baskerville' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Skranji:400,700' rel='stylesheet' type='text/css'>
 
  </head>

  <body>
  
  <div id="main_wrapper">
<header>
  	<?php
  		include("inc/header.php");
  	?>
  
  </header>
  
  
  <div id="main_box">
          <div id="navigation">
            	<?php
          		include("inc/menu.php");
          	?>
          </div>
          <?php
            	if ($rowPage['picture'] != "") {
           	?>
           		  <div id="main_img"><img src="img/<?=$rowPage['picture']?>" alt="Tasty Pita Bread" /></div>
           	<?php
            	}
            ?>
          <div id="home_txt">
           
            <h1><?=$rowPage['title']?></h1>
            <?=$rowPage['content']?>
          </div>
          <div id="photos"><img src="img/photos.png" alt="Grill Food - Order Online" /></div>
       
         	<?php
          	include("inc/footer.php");
          ?>
           </div>
  </div>
    <script type="text/javascript" src="js/jquery.js"></script>
  		  <script src="js/bootstrap.min.js"></script>
      <script src="js/bootstrap.js"></script>
  </body>
</html>
