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
		
		//insert user
		$sql_query = "SELECT     Name FROM     Regular_User Where         Username = $username";
		$tutorname = mysql_query($sql_query) or die('Select course title error' . mysql_error());

		$sql_query1 = "SELECT     Code FROM     Tutor_Course NATURAL JOIN Course_Code Where         Tutor_Username = $username";
		$code = mysql_query($sql_query1) or die('select tutor name error' . mysql_error());

		$result = array($tutorname, $code);

		$string.="<tr><td>Name</td>
				<td><input type='int' name='student ID:' value=\"$id\"/></td></tr>";
		$string.="<tr><td>DOB</td>
				<td><input type='text' name='Student Name' value='$tuteename'/></td></tr>";
		$string.="<tr><td>Gender</td>";
		//close connection
		mysql_close($link);

		echo $result;
		?>
	</body>
</html>