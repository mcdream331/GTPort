<?php
session_start();
?>
<html>
	<body>

		<?php

		$username = $_SESSION['user'];
		$CRN = $_POST['crn'];
		$gradingMode = $_POST['gradingMode'];
		
		//establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");

		//insert user
		$sql_query = "INSERT INTO        Student_Section(Student_Username, CRN, Grade_Mode) 
						VALUES        ('$username', '$CRN', '$gradingMode')";
		mysql_query($sql_query) or die('insert user table error: ' . mysql_error());
		echo "Register Successed!!";

		$sql_query1 = "SELECT    Code, Title, Letter, Grade_Mode
						FROM        (Course_Code NATURAL JOIN Section) NATURAL JOIN Student_Section
						WHERE    Term = FALL 2012 AND Student_Username = '$username'";
		$result1 = mysql_query($sql_query1) or die('select registered course error: ' . mysql_error());
		$rowcount1 = mysql_num_rows($result1);
		$string = '<table><tr>
					<th>Course Code<th>
					<th>Title<th>
					<th>Section<th>
					<th>Mode of Grading<th>
					</tr>';
		if($rowcount1!=0){
			for ($i=0; $i < $rowcount1; $i++) { 
				$title = mysql_result($result1, $i,"Title");
				$code = mysql_result($result1, $i,"Code");
				$letter = mysql_result($result1, $i,"Letter");
				$grade_mode = mysql_result($result1, $i,"Grade_Mode");
				
				//echo "crn:".$crn;
				
				//add to table
				$string.='<tr>
					<td>'.$code.'</td>
					<td>'.$title.'</td>
					<td>'.$letter.'</td>
					<td>'.$grade_mode.'</td>
				</tr></table>';
			}
		}

		//close connection
		mysql_close($link);
		echo "done";
	?>
	</body>
</html>