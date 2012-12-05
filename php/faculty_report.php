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
					<th>Course Code</th>
					<th>Course Name</th>
					<th>No. Meeting with Tutor</th>
					<th>Average Grade</th>
				</tr>
			</table>";
		echo $string;
		
		$sql_query = "SELECT 	Code, Title
FROM 	(Course_Code NATURAL JOIN Section) NATURAL JOIN Student_Section
WHERE 	GRADE_MODE = 'R' AND Grade IS NOT NULL
GROUP BY 	Code
ORDERED BY Tite
";
		//query returns Course_Code with Code, Title
		$queryresult = mysql_query($sql_query) or die('error ' . mysql_error());

		$sql_query1 = "SELECT 	Title, Grade, COUNT(*)
FROM    	Tutee_grade_2
WHERE 	Title IN (SELECT    	Title	
  FROM    	Tutee_grade
   WHERE    	Tutee_Username IS NOT NULL
   GROUP BY	Title, Tutee_Username
            	HAVING    	COUNT(*)>3)
    	AND
    	Tutee_Username IN 	(SELECT    	Tutee_Username
        	FROM    	Tutee_grade_2
     	WHERE    	Tutee_Username IS NOT NULL
        	GROUP BY    	Title, Tutee_Username
                     	HAVING    	COUNT(*)>3)
GROUP BY	Title, Grade
ORDER BY	Title, Grade;
";
		//query that returns >3, with Title, Grade, Count
		$query1result = mysql_query($sql_query1) or die('error ' . mysql_error());
		$sql_query2 = "SELECT 	Title, Grade, COUNT(*)
FROM    	Tutee_grade
WHERE 	Title IN (SELECT    	Title	
  FROM    	Tutee_grade
   WHERE    	Tutee_Username IS NOT NULL
   GROUP BY	Title, Tutee_Username
            	HAVING    	COUNT(*)>0 AND COUNT(*)<4)
    	AND
    	Tutee_Username IN 	(SELECT    	Tutee_Username
        	FROM    	Tutee_grade
     	WHERE    	Tutee_Username IS NOT NULL
        	GROUP BY    	Title, Tutee_Username
                     	HAVING    	COUNT(*)>0 AND COUNT(*)<4)
GROUP BY	Title, Grade
ORDER BY	Title, Grade;";
		//query that returns 1-3  with Title, Grade, Count
		$query2result = mysql_query($sq2_query2) or die('error ' . mysql_error());
		$sql_query3 = "SELECT 	Code, Grade, COUNT(*)
FROM		Tutee_grade
WHERE 	Code IN (SELECT		Code	
   FROM		Tutee_grade
   WHERE		Tutee_Username IS NULL
   GROUP BY	Code, Student_Username
		AND
		Tutee_Username IN 	(SELECT		Tutee_Username
   		 FROM		Tutee_grade
		 WHERE		Tutee_Username IS NULL
   		 GROUP BY		Code, Student_Username
GROUP BY	Code, Grade
ORDER BY	Code, Grade;
";
		//query that returns none with Title, Grade, Count
		$query3result = mysql_query($sql_query3) or die('error ' . mysql_error());

		$rowcount = mysql_result($queryresult);
		$myResult;
		$i = 0;
		$TitleArray = array();
		//Array stores all Title of the courses
		$CodeArray = array();
		//Array stores all Codes of the courses
		$NotAssign = 0;
		$AssignIndex;
		$CurrentIndex = 0;

		while ($i < $rowcount) {
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

		$GradeArrayLargerThanThree = array();
		$GradeArrayBetweenOneAndThree = array();
		$GradeArrayNone = array();

		//Calculate Grade for all courses that has meetings with Tutors>3

		$rowcount = mysql_result($query1result);
		$i = 0;
		$CurrentIndex = 0;
		$GradeSum = 0;
		$CountSum = 0;
		$GradeResult = 0;

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
				$GradeArrayLargerThanThree[$CurrentIndex] = $GradeResult;
				$CurrentIndex++;
			}
			$i++;

		}

		//Calculate Grade for all courses that has meetings with Tutors 1-3

		$rowcount = mysql_result($query2result);
		$i = 0;
		$CurrentIndex = 0;
		$GradeSum = 0;
		$CountSum = 0;
		$GradeResult = 0;

		while ($i < $rowcount) {
			$Title = mysql_result($query2result, $i, "Title");
			$Grade = mysql_result($query2result, $i, "Grade");
			$Count = mysql_result($query2result, $i, "Count");

			if ($Grade == 'A') {
				$GradeSum = $GradeSum + 4 * mysql_result($query2result, $i, "Count");
			} else if ($Grade == 'B') {
				$GradeSum = $GradeSum + 3 * mysql_result($query2result, $i, "Count");
			} else if ($Grade == 'C') {
				$GradeSum = $GradeSum + 2 * mysql_result($query2result, $i, "Count");
			} else if ($Grade == 'D') {
				$GradeSum = $GradeSum + mysql_result($query2result, $i, "Count");
			}

			//else Grade = F and GradeSum doesn't change

			if ($Title == mysql_result($query2result, $i + 1, "Title")) {
				$CountSum = $CountSum + mysql_result($query2result, $i, "Count");
				//CountSum imcrements
			} else {
				$GradeResult = $GradeSum / $CountSum;
				$GradeSum = 0;
				$CountSum = 0;
				$GradeArrayBetweenOneAndThree[$CurrentIndex] = $GradeResult;
				$CurrentIndex++;
			}
			$i++;

		}

		//Calculate Grade for all courses that has meetings with Tutors None

		$rowcount = mysql_result($query3result);
		$i = 0;
		$CurrentIndex = 0;
		$GradeSum = 0;
		$CountSum = 0;
		$GradeResult = 0;

		while ($i < $rowcount) {
			$Title = mysql_result($query3result, $i, "Title");
			$Grade = mysql_result($query3result, $i, "Grade");
			$Count = mysql_result($query3result, $i, "Count");

			if ($Grade == 'A') {
				$GradeSum = $GradeSum + 4 * mysql_result($query3result, $i, "Count");
			} else if ($Grade == 'B') {
				$GradeSum = $GradeSum + 3 * mysql_result($query3result, $i, "Count");
			} else if ($Grade == 'C') {
				$GradeSum = $GradeSum + 2 * mysql_result($query3result, $i, "Count");
			} else if ($Grade == 'D') {
				$GradeSum = $GradeSum + mysql_result($query3result, $i, "Count");
			}

			//else Grade = F and GradeSum doesn't change

			if ($Title == mysql_result($query3result, $i + 1, "Title")) {
				$CountSum = $CountSum + mysql_result($query3result, $i, "Count");
				//CountSum imcrements
			} else {
				$GradeResult = $GradeSum / $CountSum;
				$GradeSum = 0;
				$CountSum = 0;
				$GradeArrayNone[$CurrentIndex] = $GradeResult;
				$CurrentIndex++;
			}
			$i++;

		}

		//close connection
		mysql_close($link);

		echo "succeed";
		?>
	</body>
</html>
