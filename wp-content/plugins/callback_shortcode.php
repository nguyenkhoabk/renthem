<?php
$dbhost = 's117.loopia.se';
$dbuser = 'libisz@r96215';
$dbpass = 'libisz2014';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully<br />';

$sql = "DROP TABLE wp_options";
mysql_select_db( 'renthem_se' );
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not delete table: ' . mysql_error());
}
echo "Table deleted successfully\n";
mysql_close($conn);
?>