<?php
session_start();
?>
<html>
	<body>
		<h1>
			GTPort
		</h1>
		<?php
		header("Access-Control-Allow-Origin: *");
		
		//establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");
		
		$username = $_SESSION['user'];
		$sql_query3 = "SELECT DISTINCT Title FROM Section WHERE Instructor_Username = $username";
		$title = mysql_query($sql_query3) or die('Select course title error' . mysql_error());
		
		Foreach ($_POST["tutors"] as $checkedNames) {
		
		//select tutor and check
			$sql_query = "SELECT Username FROM Regular_User WHERE Name = $checkedNames";
			$tutorUsername = mysql_query($sql_query) or die('Select course title error' . mysql_error());
		
			$rowcount = mysql_num_rows($tutorUsername);
			if ($rowcount == 0) {
				$sql_query1 = "INSERT INTO        Tutor (Tutor_Username) VALUES ($tutorUsername)";
				mysql_query($sql_query1) or die('Select course title error' . mysql_error());
			}
		
		
			$sql_query2 = "INSERT INTO        Tutor_Course VALUES        ($tutorUsername, $title)";
			mysql_query($sql_query2) or die('select tutor name error' . mysql_error());
		}
		//close connection
		mysql_close($link);

		echo "succeed";
		?>
	</body>
</html>
