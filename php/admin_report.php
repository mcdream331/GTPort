<html>
	<body>
		<h1>GTPort</h1>
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
					<th>Average Grade</th>
				</tr>
			</table>";
		
		echo $string;
		
		$sql_query = "SELECT	DISTINCT Code, Title
						FROM		(Course_Code NATURAL JOIN Section) NATURAL JOIN Student_Section
						WHERE	Grade_Mode = ‘R’ AND Grade IS NOT NULL
						GROUP BY 	Code;";

		$sql_query1 = "SELECT Title, Grade, COUNT(*)
						FROM   	(SELECT *
        						FROM (Course_Code NATURAL JOIN Section) NATURAL JOIN Student_Section
        						WHERE Grade_Mode = 'R' AND Grade IS NOT NULL
        				GROUP BY Title, Student_Username) as T
						GROUP BY T.Title, T.Grade";

		$queryresult = mysql_query($sql_query) or die('error ' . mysql_error());

		$query1result = mysql_query($sql_query1) or die('error ' . mysql_error());

		$rowcount = mysql_result($queryresult);
		$myResult;
		$i = 0;
		$TitleArray = array();
		$CodeArray = array();
		$NotAssign = 0;
		$AssignIndex;
		$CurrentIndex = 0;
		$GradeArray = array();

		while ($i < $roucount) {
			if ($i != 0) {
				for ($j = 0; $j < i; $j++) {
					if (mysql_result($queryresult, $i, "Title") == mysql_result($queryresult, $j, "Title")) {
						$AssignIndex = $j;
						$j = $i;
						$NotAssign = 1;
					}
				}
			}
			if ($NotAssign == 1) {
				$CodeArray[$AssignIndex] = $CodeArray[$AssignIndex] + '/' + mysql_result($queryresult, $i, "Code");
				$CurrentIndex = $CurrentIndex - 1;
			} else {
				$TitleArray[$CurrentIndex] = mysql_result($queryresult, $i, "Title");
				$CodeArray[$CurrentIndex] = mysql_result($queryresult, $i, "Code");
			}

			$NotAssign = 0;
			$i++;
			$CurrentIndex++;
		}
		$rowcount = mysql_result($query1result);
		$i = 0;
		$GradeSum = 0;
		$CountSum = 0;
		$GradeResult;
		$CurrentIndex = 0;

		while ($i < $rowcount) {
			$Title = mysql_result($query1result, $i, "Title");
			$Grade = mysql_result($query1result, $i, "Grade");
			$Count = mysql_result($query1result, $i, "Count");

			if ($Grade == 'A') {
				$GradeSum = $GradeSum + 4 * mysql_result($query1result, $i, "Count");
			} else if ($Grade == 'B') {
				$GradeSum = $GradeSum + 3 * mysql_result($query1result, $i, "Count");
			} else if ($Grade == 'C') {
				$GradeSum = $GradeSum + 2 * mysql_result($query1result, $i, "Count");
			} else if ($Grade == 'D') {
				$GradeSum = $GradeSum + mysql_result($query1result, $i, "Count");
			}

			//else Grade = F and GradeSum doesn't change

			if ($Title == mysql_result($query1result, $i + 1, "Title")) {
				$CountSum = $CountSum + mysql_result($query1result, $i, "Count");
				//CountSum imcrements
			} else {
				$GradeResult = $GradeSum / $CountSum;
				$GradeSum = 0;
				$CountSum = 0;
				$GradeArray[$CurrentIndex] = $GradeResult;
				$CurrentIndex++;
			}
			$i++;

		}

		for ($i = 0; $i < $CurrentIndex; $i++) {
			$myResult = "<tr>
		<td>" . $Code[$i] . "</td>
		<td>" . $Title[$i] . "</td>
		<td>" . $Grade[$i] . "</td>
	</tr>";
		}

		//close connection
		mysql_close($link);

	?>
	</body>
</html>
