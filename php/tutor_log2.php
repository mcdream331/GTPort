<?php
session_start();
?>
<html>
	<body>
		<h1>
			GTPort
		</h1

		<?php
		header("Access-Control-Allow-Origin: *");
		
		$code = $_POST["Course Code"];
		$tutee_name = $_POST("Student Name");
		$studentId = $_POST("student ID");

		//establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");

		//insert user
		$sql_query = "SELECT     Name, Regular_User.Username
		FROM     Student JOIN Regular_User ON Student_Username = tutee_Username
		WHERE     $studentId IN ( SELECT Student_Id
							 FROM Student NATURAL JOIN Student_Section
							 WHERE CRN IN (    SELECT CRN
									FROM Section NATURAL JOIN Course_Code
									WHERE Code = $code))";
		$names = mysql_query($sql_query) or die('Select course title error' . mysql_error());
		$username = $names[1];


		$sql_query1 = "SELECT    CRN
		FROM        (Tutor_Course NATURAL JOIN Section) NATURAL JOIN Course_Code
		WHERE    Tutor_Username = $username AND Code=$code";
		$crn = mysql_query($sql_query1) or die('select tutor name error' . mysql_error());

		$sql_query2 = "INSERT     Log_Visit(Date_Time, Tutor_Username, Tutee_Username, CRN)
		VALUES     ($dateTime, $username, $tutee_username, $crn)";
		mysql_query($sql_query2) or die('insertion error' . mysql_error());

		//close connection
		mysql_close($link);

		echo "succeed";
		?>
	</body>
</html>