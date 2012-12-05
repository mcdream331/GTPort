<?php
session_start();
?>
<html>
	<body>
		<h1>
			GTPort
		</h1>

		<?php

		$username = $_SESSION['user'];
		$tutor_name = $_POST['tutor_name'];
		$student_id = $_POST['student_id'];
		$course_code = $_POST['course_code'];

		//establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");

		//insert user
		$dateTime = date("Y-m-d H:i:s");
		//echo $dateTime;

		$sql_query1 = "SELECT    CRN
		FROM        (Tutor_Course NATURAL JOIN Section) NATURAL JOIN Course_Code
		WHERE    Tutor_Username = '$username' AND Code='$course_code'";
		$result = mysql_query($sql_query1) or die('select tutor name error' . mysql_error());
		$crn = mysql_result($result, 0, 'CRN');
		//echo $crn;
		
		$sql_query3 = "SELECT Student_Username
						FROM Student
						WHERE Student_Id = '$student_id'";
		$result3 = mysql_query($sql_query3) or die('select tutee name error' . mysql_error());
		$tutee_name = mysql_result($result3, 0,'Student_Username');		//echo $tutee_name;
		
		$sql_query2 = "INSERT     Log_Visit(Date_Time, Tutor_Username, Tutee_Username, CRN)
		VALUES     ('$dateTime', '$username', '$tutee_name', '$crn')";
		mysql_query($sql_query2) or die('insertion error' . mysql_error());

		//close connection
		mysql_close($link);
		
		echo "Log Visit Insert Succeed!<br><input type='button' value='Service Page' onclick='location.href=\"student_service.php\"' />";
		?>
	</body>
</html>