<?php
header("Access-Control-Allow-Origin: *");

$username = $_GET['un'];
//establish connection
$link = mysql_connect("localhost", "root", "root");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db(cs4400) or die("Unable to select database");

//see if it's admin user
$sql_query1 = "SELECT 	Username
					FROM 	Administrator
					WHERE	Username = '$username';";
$result1 = mysql_query($sql_query1) or die('error1: ' . mysql_error());
$row1 = mysql_fetch_assoc($result1);
if ($row1 == NIL) {

	$sql_query2 = "SELECT	Instructor_Username
						FROM		Faculty
						WHERE	Instructor_Username = '$username';";

	$result2 = mysql_query($sql_query2) or die('error2: ' . mysql_error());
	$row2 = mysql_fetch_assoc($result2);
	if ($row2 == NIL){
		echo "student";
	}
	else {
		echo "faculty";
	}
} else {
	echo "admin";
}
mysql_close($link);
?>