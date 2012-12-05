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
		
		$username = $_SESSION['user'];
		$tutor_name = $_POST['tutor_name'];
		$student_id = $_POST['student_id'];
		
		//get tutor name
		$string.="<form action='tutor_log2.php' method='post'><table>";
		$string.="<tr><td>Tutor Name</td>
				<td><input type='text' name='tutor_name' value=\"$tutor_name\"/></td></tr>";
		
		//get course code
		$string.="<tr><td>Course Code</td><td><select name='course_code'>";
		$sql_query1 = "SELECT     Code FROM     Tutor_Course NATURAL JOIN Course_Code Where         Tutor_Username = '$username'";
		$result1 = mysql_query($sql_query1) or die('select tutor name error' . mysql_error());
		while ($row1 = mysql_fetch_array($result1)) {
			$string.="<option value='".$row1['Code']."'>".$row1['Code']."</option>";
		}
		$string.="</select></td></tr>";
		
		//enter student id
		$string.="<tr><td>Student ID</td>
				<td><input type='int' name='student_id' value=\"$student_id\"/></td></tr>";
		
		//enter student name
		$sql_query2 = "SELECT DISTINCT Name
						FROM Student JOIN Regular_User ON Student_Username = Username
						WHERE Student_Id = '$student_id'";
		$result2 = mysql_query($sql_query2) or die('student name error' . mysql_error());
		$student_name = mysql_result($result2, 0, 'Name');
		//echo $student_name;
		$string.="<tr><td>Student Name</td><td><input type='text' name='student_name' value='$student_name'/></td></tr>";
		//close connection
		mysql_close($link);
		$string.='</table>';
		$string.="<input type='button' value='Home' onclick='location.href=\"student_homepage.php\"' /><input type='Submit' value='Log Visit'/></form>";
		
		echo $string;
		?>
	</body>
</html>