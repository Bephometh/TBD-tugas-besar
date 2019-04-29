<?php
$serverName = "MUHARODAN\SQLEXPRESS";

$connectionInfo = array("Database"=>"TBD");

$conn = sqlsrv_connect( $serverName, $connectionInfo);
// print_r($conn);
// return;
if($conn){
	echo "Connection established. <br/>";

}else
{
	echo "Connection could not be established. <br />";
	die(print_r(sqlsrv_errors(),true));

}
?>