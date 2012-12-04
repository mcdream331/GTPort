<?php
header("Access-Control-Allow-Origin: *");

$courseCode =  $_GET['courseCode'];

//establish connection
$link = mysql_connect("localhost", "root", "root");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db(cs4400) or die("Unable to select database");

$username = $GET_['username'];

$sql_query = 	"CREATE VIEW NameOfInstructor
				AS SELECT 	Name
				FROM 	Regular_User
				WHERE 	Regular_User.Username IN
							(SELECT 	Instructor_Username
							FROM 	Section
							WHERE 	CRN IN (SELECT 	CRN
			        			   FROM 	Student_Section
			        			   WHERE 	Student_Username=$Username));";
								   
queryresult1 = mysql_query($sql_query) or die('error: ' . mysql_error());

$sql_query2 =   "CREATE VIEW NameAndCourseCode
				AS SELECT 	NameOfInstructor.Name, Course_Code.Title, Course_Code.Code, Section.CRN
				FROM  	((NameOfInstructor NATURAL JOIN  Regular_User) JOIN Section ON Regular_User.Username=Section.Instructor_Username) NATURAL JOIN Course_Code
				ORDER BY 	NameOfInstructor.Name;";
				
queryresult2 = mysql_query($sql_query2) or die('error: ' . mysql_error());

$sql_query3 =   "SELECT 	NameAndCourseCode.NameOfInstructor.Name, NameAndCourseCode.Code, NameAndCourseCode.Course_Code.Title, Section.Grade, COUNT(*), Section.CRN
				FROM 	NameAndCourseCode AS N NATURAL JOIN Student_Section AS S
				WHERE 	S.Grade_Mode IS NOT NULL AND S.Grade_MODE = ¡®R¡¯
				ORDER BY 	Section.CRN, Grade
				GROUP BY 	Section.CRN, Grade;";

queryresult3 = mysql_query($sql_query3) or die('error' . mysql_error());

$rowcount = mysql_result($queryresult3);
$myResult;
$i=0;
$NameA = array();
$CodeA = array();
$TitleA = array();
$GradeA = array();
while($i<$rowcount){

		$Name = mysql_result($queryresult3, $i, "Name");
		$Code = mysql_result($queryresult3, $i, "Code");
		$Title = mysql_result($queryresult3, $i, "Title");
		$Grade = mysql_result($queryresult3, $i, "Grade");
		
		$NameA[] = $Name;
		$CodeA[] = $Code;
		$TitleA[] = $Title;
		$GradeA[] = $Grade;
		
		$i++;
}

for($i=0;$i<$rowcount-1;$i++){
	for($j=1;$j<$rowcount;$j++){
		if($TitleA[$i] == $TitleA[$j]){
		    // Combine Course Code and Average the two Grades
			$CodeA[$i] = $CodeA[$i] + '/' + $CodeA[$j];
			$GradeA[$i] = ($GradeA[$i]+$GradeA[$j])/2;
			$unset($NameA[$j]);
			$unset($CodeA[$j]);
			$unset($TitleA[$j]);
			$unset($GradeA[$j]);
		}
	}
}

for($i=0;$i<rowcount;$i++){
	if($NameA[i]!= ''){
		$myResult=$myResult."<tr>
			<td>".$NameA[i]."</td>
			<td>".$CodeA[i]."</td>
			<td>".$TitleA[i]."</td>
			<td>".$GradeA[i]."</td>
		</tr>"
	}
}		

//close connection
mysql_close($link);

echo "succeed";
?>

