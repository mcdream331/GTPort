<?php
header("Access-Control-Allow-Origin: *");

//establish connection
$link = mysql_connect("localhost", "root", "root");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db(cs4400) or die("Unable to select database");

//select
$sql_query = "SELECT * FROM User";
$result = mysql_query($sql_query) or die('Select course title error' . mysql_error());


echo $result;
//close connection
mysql_close($link);

?>