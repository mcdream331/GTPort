<?php
header("Access-Control-Allow-Origin: *");

$username = $_GET['un'];
$password = $_GET['pw'];

//establish connection
$link = mysql_connect("localhost", "root", "root");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db(cs4400) or die("Unable to select database");

//SELECT PASSWORD
$sql_query = "SELECT Password  
				FROM  User  
				WHERE   Username = '$username';";

$result = mysql_query($sql_query) or die('error: ' . mysql_error());
$row = mysql_fetch_assoc($result);
if ($row != NIL) {
	if ($row["Password"] != $password) {
		echo "false";
	} else {
		echo "true";
	}
}
else {
	echo "false";
}

//close connection
mysql_close($link);
?>