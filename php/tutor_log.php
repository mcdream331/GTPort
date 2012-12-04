<?php
header("Access-Control-Allow-Origin: *");

//establish connection
$link = mysql_connect("localhost", "root", "root");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db(cs4400) or die("Unable to select database");

//insert user
$sql_query = "SELECT     Name FROM     Regular_User Where         Username = $username";
$tutorname = mysql_query($sql_query) or die('Select course title error' . mysql_error());

$sql_query1 = "SELECT     Code FROM     Tutor_Course NATURAL JOIN Course_Code Where         Tutor_Username = $username";
$code = mysql_query($sql_query1) or die('select tutor name error' . mysql_error());

$result = array($tutorname, $code);
//close connection
mysql_close($link);

echo $result;