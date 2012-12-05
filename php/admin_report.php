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
			";

		$sql_query = "SELECT Title, Grade, COUNT(*)
						FROM   	(SELECT *
        						FROM (Course_Code NATURAL JOIN Section) NATURAL JOIN Student_Section
        						WHERE Grade_Mode = 'R' AND Grade IS NOT NULL
        						GROUP BY Title, Student_Username) as T
						GROUP BY T.Title, T.Grade";

		$queryresult = mysql_query($sql_query) or die('error ' . mysql_error());
		$rowcount = mysql_num_rows($queryresult);
		//echo $rowcount;
		$i = 0;
		$GradeSum = 0;
		$CountSum = 0;
		$CurrentIndex = 0;

		while ($i < $rowcount) {
			$Title[$CurrentIndex] = mysql_result($queryresult, $i, "Title");
			//echo $Title[CurrentIndex];
			$Grade = mysql_result($queryresult, $i, "Grade");
			//echo $Grade;
			$Count = mysql_result($queryresult, $i, "COUNT(*)");
			$CountSum += mysql_result($queryresult, $i, "COUNT(*)");
			//echo $Count;
			//echo 'count sum:'.$CountSum.'<br>';

			if ($Grade == 'A') {
				$GradeSum = $GradeSum + 4 * mysql_result($queryresult, $i, "COUNT(*)");
			} else if ($Grade == 'B') {
				$GradeSum = $GradeSum + 3 * mysql_result($queryresult, $i, "COUNT(*)");
			} else if ($Grade == 'C') {
				$GradeSum = $GradeSum + 2 * mysql_result($queryresult, $i, "COUNT(*)");
			} else if ($Grade == 'D') {
				$GradeSum = $GradeSum + mysql_result($queryresult, $i, "COUNT(*)");
			}

			//echo "grade sum:".$GradeSum.'<br>';

			//else Grade = F and GradeSum doesn't change

			if ($Title[$CurrentIndex] != mysql_result($queryresult, $i + 1, "Title")) {
				$GradeResult[$CurrentIndex] = round($GradeSum / $CountSum,2);
				//echo 'grade result:' . $GradeResult[$CurrentIndex] . "<br>";
				$GradeSum = 0;
				$CountSum = 0;
				$CurrentIndex += 1;
			}
			$i += 1;
		}
		//Get Course Code
		for ($j = 0; $j < $CurrentIndex; $j++) {
			$sql_query1 = "SELECT Code
						FROM Course_Code
						WHERE Title = '$Title[$j]'";
			$result1 = mysql_query($sql_query1) or die('query1 error' . mysql_error());
			$rowcount1 = mysql_num_rows($result1);
			if ($rowcount1 > 1) {
				for ($m = 0; $m < $rowcount1; $m++) {
					$Code[$j] .= mysql_result($result1, $m, 'Code');
					//echo $Code[$j];
					if ($m + 1 < $rowcount1) {
						$Code[$j] .= '/';
					}
				}
			} else {
				$Code[$j] = mysql_result($result1, 0, 'Code');
			}
		}

		//display
		for ($n = 0; $n < $CurrentIndex; $n++) {
			$string .= "<tr>
		<td>" . $Code[$n] . "</td>
		<td>" . $Title[$n] . "</td>
		<td>" . $GradeResult[$n] . "</td>
		</tr>";
		}

		$string .= "</table>";
		//close connection
		mysql_close($link);

		echo $string;
		?>
	</body>
</html>
