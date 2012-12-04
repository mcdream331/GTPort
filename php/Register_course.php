<?php
session_start();
?>
<html>
	<body>
		<h1>
			GTPort
		</h1>

		<?php
		//header("Access-Control-Allow-Origin: *");

		//establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");

		$Students = $_GET['students'];
		$
		//insert user
		$sql_query = "SELECT    Dept_Id FROM        Department WHERE    Name = $departmentName";
		$departmentId = mysql_query($sql_query) or die('insert user table error: ' . mysql_error());

		$sql_query1 = "SELECT    CRN, Title, Code, Letter, Name, Day, Start_Time, End_Time, Location FROM     (Section NATURAL JOIN (Department_Course NATURAL JOIN Course_Code))         JOIN Regular_User ON Instructor_Username = UsernameWHERE    Dept_Id = $departmentId AND Term = $term";
		$result = mysql_query($sql_query1) or die('insert regular user table error: ' . mysql_error());

		//close connection
		mysql_close($link);
		echo $result;
		?>