<?php
$link = mysql_connect("localhost", "root", "root");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db(cs4400) or die("Unable to select database");

//Get username
$username = $_GET("username");

//View Course
SELECT Code, Title FROM (Course_Code NATURAL JOIN Section) NATURAL JOIN Student_Section WHERE GRADE_MODE = 'R' AND Grade IS NOT NULL GROUP BY Code;
