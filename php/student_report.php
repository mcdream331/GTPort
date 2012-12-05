<?php
session_start();
?>
<html>
	<body>
		<h1>
			GTPort
		</h1>
		<?php
		//establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");
		
		$string = "<table border='1'>
				<tr>
					<th>Instructor Name</th>
					<th>Course Code</th>
					<th>Course Name</th>
					<th>Average Grade</th>
				</tr>
			";
		//echo $string;

		// $sql_query = "SELECT Name, Instructor_Username
						// FROM Faculty JOIN Regular_User ON Instructor_Username = Username";
		// $result = mysql_query($sql_query) or die('error ' . mysql_error());
		// $rowcount = mysql_num_rows($result);
		// //echo $rowcount;
		// for ($i=0; $i < $rowcount ; $i++) { 
			// $instructor[$i][name] = mysql_result($result, $i,'Name');
			// //echo mysql_result($result, $i,'Name');
			// $instructor[$i][username] = mysql_result($result, $i,'Instructor_Username');
			// // echo $instructor[$i][name];
			// // echo $instructor[$i][username];
// 
		// }

		$sql_query1 = "SELECT *, COUNT(*)
						FROM Section NATURAL JOIN Student_Section
						WHERE Grade_Mode = 'R' AND Grade IS NOT NULL
						GROUP BY Title, Grade";
		$result1 = mysql_query($sql_query1) or die('error' . mysql_error());
		$rowcount1 = mysql_num_rows($result1);
		
		$i = 0;
		$GradeSum = 0;
		$CountSum = 0;
		$CurrentIndex = 0;
		
		while ($i < $rowcount1) {
			$student_report[$CurrentIndex][title] = mysql_result($result1, $i, "Title");
			$student_report[$CurrentIndex][instructor] = mysql_result($result1, $i, "Instructor_Username");
			//echo $Title[CurrentIndex];
			$Grade = mysql_result($result1, $i, "Grade");
			//echo $Grade;
			$Count = mysql_result($result1, $i, "COUNT(*)");
			$CountSum += mysql_result($result1, $i, "COUNT(*)");
			//echo $Count;
			//echo 'count sum:'.$CountSum.'<br>';

			if ($Grade == 'A') {
				$GradeSum = $GradeSum + 4 * mysql_result($result1, $i, "COUNT(*)");
			} else if ($Grade == 'B') {
				$GradeSum = $GradeSum + 3 * mysql_result($result1, $i, "COUNT(*)");
			} else if ($Grade == 'C') {
				$GradeSum = $GradeSum + 2 * mysql_result($result1, $i, "COUNT(*)");
			} else if ($Grade == 'D') {
				$GradeSum = $GradeSum + mysql_result($result1, $i, "COUNT(*)");
			}

			//echo "grade sum:".$GradeSum.'<br>';

			//else Grade = F and GradeSum doesn't change

			if ($student_report[$CurrentIndex][title] != mysql_result($result1, $i + 1, "Title")) {
				$student_report[$CurrentIndex][grade] = round($GradeSum / $CountSum,2);
				//echo 'grade result:' . $GradeResult[$CurrentIndex] . "<br>";
				$GradeSum = 0;
				$CountSum = 0;
				$CurrentIndex += 1;
			}
			$i += 1;
		}
		//echo $CurrentIndex;
		for ($i=0; $i < $CurrentIndex; $i++) {
			//echo $student_report[$i][instructor]; 
			$sql_query2 = "SELECT Name
							FROM Regular_User
							WHERE Username='".$student_report[$i][instructor]."'";
			$result2 = mysql_query($sql_query2) or die("find name error".mysql_error());
			//echo mysql_result($result2, 0,'Name');
			$student_report[$i][instructor] = mysql_result($result2, 0,"Name");
		}
		
		//Get Course Code
		for ($j = 0; $j < $CurrentIndex; $j++) {
			$sql_query3 = "SELECT Code
						FROM Course_Code
						WHERE Title = '".$student_report[$j][title]."'";
			$result3 = mysql_query($sql_query3) or die('query3 error' . mysql_error());
			$rowcount3 = mysql_num_rows($result3);
			if ($rowcount3 > 1) {
				for ($m = 0; $m < $rowcount3; $m++) {
					$student_report[$j][code] .= mysql_result($result3, $m, 'Code');
					//echo $Code[$j];
					if ($m + 1 < $rowcount3) {
						$student_report[$j][code] .= '/';
					}
				}
			} else {
				$student_report[$j][code] = mysql_result($result3, 0, 'Code');
			}
		}
		
		for ($n = 0; $n < $CurrentIndex; $n++) {
			$string .= "<tr>
		<td>" . $student_report[$n][instructor] . "</td>
		<td>" . $student_report[$n][code] . "</td>
		<td>" .$student_report[$n][title] . "</td>
		<td>" .$student_report[$n][grade] . "</td>
		</tr>";
		}

		$string .= "</table>";
		echo $string;
		//close connection
		mysql_close($link);

	?>
	</body>
</html>
