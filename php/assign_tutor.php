<?php
header("Access-Control-Allow-Origin: *");

//establish connection
$link = mysql_connect("localhost", "root", "root");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db(cs4400) or die("Unable to select database");

//insert user
$sql_query = "SELECT DISTINCT Title FROM Section WHERE Instructor_Username = $username";
$title = mysql_query($sql_query) or die('Select course title error' . mysql_error());

$sql_query1 = "SELECT    Name FROM Regular_User JOIN Apply_Tutor ON Student_Username = Username WHERE    Title = $title;";
$result = mysql_query($sql_query1) or die('select tutor name error' . mysql_error());

//close connection
mysql_close($link);

echo $result;
?>