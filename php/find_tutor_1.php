<?php
session_start();
?>
<html>
	<body>

		<?php
		$courseCode = $_POST['course_code'];
		$keyword = $_POST['keyword'];
		//echo "cc:".$courseCode;
		//echo "kw:".$keyword;

		//establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");
		
		echo "Search Result:<br>";
		$myResult='<table><tr>
					<th>Course Code</th>
					<th>Course Name</th>
					<th>Tutor Name</th>
					<th>Tutor Email</th>
					</tr>';
		
		if ($courseCode != '') {
			$sql_query = "SELECT	Title, Code, Name, Email_Id
					FROM		(Course_Code NATURAL JOIN Tutor_Course) JOIN Regular_User ON
					Tutor_Username = Username
					WHERE	Code ='$courseCode';";

			$queryresult = mysql_query($sql_query) or die('error ' . mysql_error());
			$rowcount = mysql_num_rows($queryresult);
			
			$i = 0;
			while ($i < $rowcount) {
				$Title = mysql_result($queryresult, $i, "Title");
				//$Code = mysql_result($queryresult, $i, "Code");
				$Name = mysql_result($queryresult, $i, "Name");
				$Email_Id = mysql_result($queryresult, $i, "Email_Id");
				
				// echo "title:".$Title;
				// echo "code:".$courseCode;
				// echo "name:".$Name;
				// echo "email:".$Email_Id;
				$myResult .= "<tr>
			<td>" . $courseCode . "</td>
			<td>" . $Title . "</td>
			<td>" . $Name . "</td>
			<td>" . $Email_Id . "</td>
		</tr>";

				$i += 1;
			}
		} 
		else {
			$sql_query = "SELECT	Title, Code, Name, Email_Id
					FROM		(Course_Code NATURAL JOIN Tutor_Course) JOIN Regular_User ON
					Tutor_Username = Username
					WHERE	Title LIKE CONCAT('%','$keyword','%');";

			$queryresult = mysql_query($sql_query) or die('error ' . mysql_error());
			$rowcount = mysql_num_rows($queryresult);
			$i = 0;
			while ($i < $rowcount) {
				$Title = mysql_result($queryresult, $i, "Title");
				$Code = mysql_result($queryresult, $i, "Code");
				$Name = mysql_result($queryresult, $i, "Name");
				$Email_Id = mysql_result($queryresult, $i, "Email_Id");

				$myResult .= "<tr>
			<td>" . $Code . "</td>
			<td>" . $Title . "</td>
			<td>" . $Name . "</td>
			<td>" . $Email_Id . "</td>
		</tr>";

				$i += 1;
			}

		}
		
		$myResult .= "</table>
		<br>Click button below to return to search page.<br>
		<input type='button' value='Back' onclick='location.href=\"find_tutor.php\"'/>";
		
		echo $myResult;
		//close connection
		mysql_close($link);

	?>
	</body>
</html>
