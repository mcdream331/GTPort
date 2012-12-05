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
		
		//get tutor name
		$string.="<form action='tutor_log1.php' method='post'><table>";
		
		$sql_query = "SELECT     Name FROM     Regular_User Where         Username = '$username'";
		$result = mysql_query($sql_query) or die('Select course title error' . mysql_error());
		$tutorname =  mysql_result($result, 0, 'Name');
		//echo $tutorname;
		$string.="<tr><td>Tutor Name</td>
				<td><input type='text' name='tutor_name' value=\"$tutorname\"/></td></tr>";
		
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
				<td><input type='int' name='student_id'/></td><td><input type='Submit' value='Get Student Name'/></td></tr>";
		
		$string.="<tr><td>Student Name</td><td><input type='text' name='student_name'/></td></tr>";
		//close connection
		mysql_close($link);
		$string.='</table>';
		$string.="<input type='button' value='Home' onclick='location.href=\"student_homepage.php\"' /></form>";
		
		echo $string;
		?>
	</body>
</html>