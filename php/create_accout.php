<?php
mysql_connect($host,$username,$password) or die( "Unable to connect");;
mysql_select_db($database) or die( "Unable to select database");
$username = $_GET("username");
$password = $_GET("password");

// When password and comfirm password are equal
$sql_query = "INSERT INTO        User (Username, Password)
VALUES        ($username, $password)";
$sql_query1 = "INSERT INTO        Regular_User (Username)
VALUES        ($username)";

mysql_query ($sql_query);
mysql_query ($sql_query1);  

$usertype = $_GET("user_type");

if ($usertype="Student")
	$sql_query2 = "INSERT INTO        Student 	(Student_Username)
	VALUES        ($username);"
elseif ($usertype="Faculty")
	$sql_query2 = "INSERT INTO        Faculty 	(Instructor_Username)
	VALUES        ($username);"
//else
	//no value

mysql_query ($sql_query2);

mysql_close ();
?>
