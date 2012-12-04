<?php
header("Access-Control-Allow-Origin: *");

$username = $_GET['un'];
$password = $_GET['pw'];
$usertype = $_GET['ut'];
//establish connection
$link = mysql_connect("localhost", "root", "root");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db(cs4400) or die("Unable to select database");

//insert user
$sql_query = "INSERT INTO User (Username, Password) VALUES ('$username', '$password')";
$sql_query1 = "INSERT INTO Regular_User (Username) VALUES ('$username')";

mysql_query($sql_query) or die('insert user table error: ' . mysql_error());
mysql_query($sql_query1) or die('insert regular user table error: ' . mysql_error());

if ($usertype == "student") {
	$sql_query2 = "INSERT INTO Student (Student_Username) VALUES ('$username');";
} elseif ($usertype == "faculty") {
	$sql_query2 = "INSERT INTO Faculty (Instructor_Username, Dept_Id) VALUES ('$username','1');";
}

mysql_query($sql_query2) or die('insert student/faculty table error:' . mysql_error());
//close connection
mysql_close($link);

echo "succeed";
?>