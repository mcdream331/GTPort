<?php
header("Access-Control-Allow-Origin: *");

$keyword =  $_GET['keyWord'];

//establish connection
$link = mysql_connect("localhost", "root", "root");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db(cs4400) or die("Unable to select database");

$sql_query = 	"SELECT	Title, Code, Name, Email_Id
				FROM		(Course_Code NATURAL JOIN Tutor_Course) JOIN Regular_User ON
				Tutor_Username = Username
				WHERE	Course_Code LIKE CONCAT(¡®%¡¯,$keyword,¡¯%¡¯);";
				
queryresult = mysql_query($sql_query) or die('error ' . mysql_error());

$rowcount = mysql_result($queryresult);
$myResult;
$i=0;
while($i<$rowcount){
	$Title = mysql_result($queryresult, $i, "Title");
	$Code = mysql_result($queryresult, $i, "Code");
	$Name = mysql_result($queryresult, $i, "Name");
	$Email_Id = mysql_result($queryresult, $i, "Email_Id");
	
	$myResult=$myResult."<tr>
		<td>".$Title."</td>
		<td>".$Code."</td>
		<td>".$Name."</td>
		<td>".$Email_Id."</td>
	</tr>"
	
	$i++;
}

//close connection
mysql_close($link);

echo "succeed";
?>