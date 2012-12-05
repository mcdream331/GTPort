<?php
session_start();
?>
<html>
	<body>
		<h1> GTPort </h1>
		<?php
		$username = $_SESSION['user'];
		//echo $username;

		//establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");

		$sql_query3 = "SELECT DISTINCT Title 
						FROM Section 
						WHERE Instructor_Username = '$username'";
		$result = mysql_query($sql_query3) or die('Select course title error' . mysql_error());
		$title = mysql_result($result, 0, 'Title');
		//echo $title;

		foreach ($_POST["tutors"] as $checkedNames) {

			//select tutor and check
			$sql_query = "SELECT Username 
						FROM Regular_User 
						WHERE Name = '$checkedNames'";
			$result2 = mysql_query($sql_query) or die('Select course title error' . mysql_error());
			$tutorUsername = mysql_result($result2, 0, 'Username');
			//echo $tutorUsername;

			$sql_query1 = "INSERT INTO        Tutor (Tutor_Username) VALUES ('$tutorUsername')";
			mysql_query($sql_query1);

			$sql_query2 = "INSERT INTO        Tutor_Course(Tutor_Username, Title) VALUES ('$tutorUsername', '$title')";
			mysql_query($sql_query2);
			
			$sql_query4 = "DELETE FROM Apply_Tutor
							WHERE Student_Username='$tutorUsername' AND Title='$title'";
			mysql_query($sql_query4)or die('Delete error' . mysql_error());
		}		//close connection
		mysql_close($link);
		?>
		Assign tutor succeed! Click link below return to homepage.<br>
		<input type="button" value="Back" onclick="location.href='faculty_service.php'"/>
	</body>
</html>
