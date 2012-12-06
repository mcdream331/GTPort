<html>
	<body>
		<h1> GTPort </h1>
		<?php
		//establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");

		$string = "<table border='1'>
				<tr>
					<th>Course Code</th>
					<th>Course Name</th>
					<th>No. Meeting with Tutor</th>
					<th>Average Grade</th>
				</tr>
			";
		//echo $string;

		//Get course titles with grade
		$sql_query = "SELECT DISTINCT Title
						FROM Student_Section NATURAL JOIN Section
						WHERE Grade_Mode = 'R' AND Grade IS NOT NULL";
		$result = mysql_query($sql_query);
		$title_count = mysql_num_rows($result);
		$faculty_report;
		for ($i = 0; $i < $title_count; $i++) {
			$faculty_report[$i][title] = mysql_result($result, $i);
			//echo $faculty_report[$i][title];
		}
		//echo"<br>";

		//Get course code
		for ($j = 0; $j < $title_count; $j++) {
			$sql_query1 = "SELECT Code
						FROM Course_Code
						WHERE Title = '" . $faculty_report[$j][title] . "'";
			$result1 = mysql_query($sql_query1) or die('query1 error' . mysql_error());
			$rowcount1 = mysql_num_rows($result1);
			if ($rowcount1 > 1) {
				for ($m = 0; $m < $rowcount1; $m++) {
					$faculty_report[$j][code] .= mysql_result($result1, $m, 'Code');
					//echo $Code[$j];
					if ($m + 1 < $rowcount1) {
						$faculty_report[$j][code] .= '/';
					}
				}
			} else {
				$faculty_report[$j][code] = mysql_result($result1, 0, 'Code');
			}
			//echo $faculty_report[$j][code];
		}

		for ($i = 0; $i < $title_count; $i++) {

			//Get average grade for meeting >= 3
			$sql_query2 = "SELECT Grade,COUNT(*)
						FROM Student_Section natural join Section
						WHERE Title = '" . $faculty_report[$i][title] . "' and Grade_Mode = 'R'and Grade is not null and Student_Username IN
						(SELECT Tutee_Username
						FROM Log_Visit
						NATURAL JOIN Section
						WHERE Title =  '" . $faculty_report[$i][title] . "'
						GROUP BY Tutee_Username
						HAVING COUNT(*)>2)
						GROUP BY Grade
						ORDER BY Grade";
			$result2 = mysql_query($sql_query2);
			$rowcount2 = mysql_num_rows($result2);
			$j = 0;
			$CountSum = 0;
			$GradeSum = 0;

			while ($j < $rowcount2) {
				$Grade = mysql_result($result2, $j, "Grade");
				//echo $Grade;
				$CountSum += mysql_result($result2, $j, "COUNT(*)");
				//echo $Count;
				//echo 'count sum:'.$CountSum.'<br>';

				if ($Grade == 'A') {
					$GradeSum = $GradeSum + 4 * mysql_result($result2, $j, "COUNT(*)");
				} else if ($Grade == 'B') {
					$GradeSum = $GradeSum + 3 * mysql_result($result2, $j, "COUNT(*)");
				} else if ($Grade == 'C') {
					$GradeSum = $GradeSum + 2 * mysql_result($result2, $j, "COUNT(*)");
				} else if ($Grade == 'D') {
					$GradeSum = $GradeSum + mysql_result($result2, $j, "COUNT(*)");
				}

				//echo "grade sum:".$GradeSum.'<br>';
				//else Grade = F and GradeSum doesn't change
				$j++;
			}
			if (mysql_result($result2, 0,'Grade') == '') {
				$faculty_report[$i][grade3] = 0;
			} else {$faculty_report[$i][grade3] = round($GradeSum / $CountSum, 2);
			}

			//Get average grade for meeting 1-3
			$sql_query3 = "SELECT Grade,COUNT(*)
						FROM Student_Section natural join Section
						WHERE Title = '" . $faculty_report[$i][title] . "' and Grade_Mode = 'R'and Grade is not null and Student_Username IN
						(SELECT Tutee_Username
						FROM Log_Visit
						NATURAL JOIN Section
						WHERE Title =  '" . $faculty_report[$i][title] . "'
						GROUP BY Tutee_Username
						HAVING COUNT(*)>0 AND COUNT(*)<3)
						GROUP BY Grade
						ORDER BY Grade";
			$result3 = mysql_query($sql_query3) or die("meeting 1-3 error".mysql_error);
			$rowcount3 = mysql_num_rows($result3);
			//echo 'meeting 1-3:'.$rowcount3.'<br>';
			$j = 0;
			$CountSum = 0;
			$GradeSum = 0;

			while ($j < $rowcount3) {
				$Grade = mysql_result($result3, $j, "Grade");
				//echo $Grade;
				$CountSum += mysql_result($result3, $j, "COUNT(*)");
				//echo $Count;
				//echo 'count sum:'.$CountSum.'<br>';

				if ($Grade == 'A') {
					$GradeSum = $GradeSum + 4 * mysql_result($result3, $j, "COUNT(*)");
				} else if ($Grade == 'B') {
					$GradeSum = $GradeSum + 3 * mysql_result($result3, $j, "COUNT(*)");
				} else if ($Grade == 'C') {
					$GradeSum = $GradeSum + 2 * mysql_result($result3, $j, "COUNT(*)");
				} else if ($Grade == 'D') {
					$GradeSum = $GradeSum + mysql_result($result3, $j, "COUNT(*)");
				}

				//echo "grade sum:".$GradeSum.'<br>';
				//else Grade = F and GradeSum doesn't change
				$j++;
			}
			//echo 'meeting 1-3:'.$rowcount3.'<br>';
			if ($rowcount3 == 0) {
				$faculty_report[$i][grade2] = 0;
				//echo "should be 0:".$faculty_report[$j - 1][grade2].'<br>';
			} else {
				$faculty_report[$i][grade2] = round($GradeSum / $CountSum, 2);
			}
			//echo 'grade result:' . $GradeResult[$CurrentIndex] . "<br>";

			//Get average grade for no meeting
			$sql_query4 = "SELECT Grade, Count(*)
							FROM (Student_Section NATURAL JOIN Section)
							WHERE Student_Username NOT IN 
							(SELECT Tutee_Username 
							FROM Log_Visit) AND Grade_Mode = 'R' AND Title = '" . $faculty_report[$i][title] . "'
							Group BY Grade";
			$result4 = mysql_query($sql_query4);
			$rowcount4 = mysql_num_rows($result4);
			$j = 0;
			$CountSum = 0;
			$GradeSum = 0;

			while ($j < $rowcount4) {
				$Grade = mysql_result($result4, $j, "Grade");
				//echo $Grade;
				$CountSum += mysql_result($result4, $j, "COUNT(*)");
				//echo $Count;
				//echo 'count sum:'.$CountSum.'<br>';

				if ($Grade == 'A') {
					$GradeSum = $GradeSum + 4 * mysql_result($result4, $j, "COUNT(*)");
				} else if ($Grade == 'B') {
					$GradeSum = $GradeSum + 3 * mysql_result($result4, $j, "COUNT(*)");
				} else if ($Grade == 'C') {
					$GradeSum = $GradeSum + 2 * mysql_result($result4, $j, "COUNT(*)");
				} else if ($Grade == 'D') {
					$GradeSum = $GradeSum + mysql_result($result4, $j, "COUNT(*)");
				}

				//echo "grade sum:".$GradeSum.'<br>';
				//else Grade = F and GradeSum doesn't change
				$j++;
			}
			if (mysql_result($result4, 0,'Grade') == '') {
				$faculty_report[$i][grade1] = 0;
			} else {
				$faculty_report[$i][grade1] = round($GradeSum / $CountSum, 2);
			}
		}

		for ($n = 0; $n < $title_count; $n++) {
			$string .= "<tr>
		<td>" . $faculty_report[$n][code] . "</td>
		<td>" . $faculty_report[$n][title] . "</td>";
			$string .= "<td><table><tr><td> >3 </td></tr><tr><td> 1-3 </td></tr><tr><td> None </td></tr></table></td>";
			$string .= "<td><table><tr><td>" . $faculty_report[$n][grade3] . "</td></tr>
						<tr><td>" . $faculty_report[$n][grade2] . "</td></tr>
						<tr><td>" . $faculty_report[$n][grade1] . "</td></tr></table>
						</td></tr>";
			// echo "meeting >3:".$faculty_report[$n][grade3]."<br>";
			// echo "meeting 1-3:".$faculty_report[$n][grade2]."<br>";
			// echo "meeting 0:".$faculty_report[$n][grade1]."<br>";
		}

		echo $string;
		//close connection
		mysql_close($link);
		?>
	</body>
</html>
