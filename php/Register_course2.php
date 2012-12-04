<?php

//establish connection
$link = mysql_connect("localhost", "root", "root");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db(cs4400) or die("Unable to select database");

//insert user
$sql_query = "INSERT INTO        Student_Section(Student_Username, CRN, Grade_Mode) VALUES        ($username, $CRN, $gradingMode)";
mysql_query($sql_query) or die('insert user table error: ' . mysql_error());

$sql_query1 = "SELECT    Code, Title, Letter, Grade_Mode
FROM        (Course_Code NATURAL JOIN Section) NATURAL JOIN Student_Section
WHERE    Term = $term AND Student_Username = $username";
mysql_query($sql_query1) or die('insert regular user table error: ' . mysql_error());

//close connection
mysql_close($link);
echo "done";
?>