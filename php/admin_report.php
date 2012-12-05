<?php
header("Access-Control-Allow-Origin: *");

//establish connection
$link = mysql_connect("localhost", "root", "root");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db(cs4400) or die("Unable to select database");

$sql_query = 	"SELECT	DISTINCT Code, Title
				FROM		(Course_Code NATURAL JOIN Section) NATURAL JOIN Student_Section
				WHERE 	Grade_Mode = ¡®R¡¯ AND Grade IS NOT NULL
				GROUP BY 	Code;";

$sql_query1 =   "SELECT	Code, Grade, COUNT(*)
				FROM 	(Course_Code NATURAL JOIN Section) NATURAL JOIN Student_Section
				WHERE 	Grade_Mode = ¡®R¡¯ AND Grade IS NOT NULL
				GROUP BY 	Code, Grade	
				ORDER BY	Code, Grade;";
				
queryresult = mysql_query($sql_query) or die('error ' . mysql_error());

query1result = mysql_query($sql_query1) or die('error ' . mysql_error());

$rowcount = mysql_result($query1result);
$myResult;
$i=0;
while($i<$rowcount){
	$Code = mysql_result($queryresult, $i, "Code");
	$Grade = mysql_result($queryresult, $i, "Grade");
	$Count = mysql_result($queryresult, $i, "Count");
	
	$myResult=$myResult."<tr>
		<td>".$Code."</td>
		<td>".$Grade."</td>
		<td>".$Count."</td>
	</tr>"
	
	$i++;
}
				
for(				

//close connection
mysql_close($link);

echo "succeed";
?>