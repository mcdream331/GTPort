<?php
session_start();
?>
<html>
	<body>
		<h1>
			GTPort
		</h1>

		<?php

		$username = $_SESSION['user']
		$code = $_POST["Course Code"];
		$tutee_username = $_POST("Student Name");
		$studentId = $_POST("student ID");

		//establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");

		//insert user
		$dateTime = date("Y-m-d H:i:s");


		$sql_query1 = "SELECT    CRN
		FROM        (Tutor_Course NATURAL JOIN Section) NATURAL JOIN Course_Code
		WHERE    Tutor_Username = $username AND Code=$code";
		$result = mysql_query($sql_query1) or die('select tutor name error' . mysql_error());
		$crn = mysql_result($result, 0, 'CRN')
		
		$sql_query2 = "INSERT     Log_Visit(Date_Time, Tutor_Username, Tutee_Username, CRN)
		VALUES     ($dateTime, $username, $tutee_username, $crn)";
		mysql_query($sql_query2) or die('insertion error' . mysql_error());

		//close connection
		mysql_close($link);

		echo "succeed";
		?>
	</body>
</html>