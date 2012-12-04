<?php
session_start();
?>
<html>
	<body>
		<h1>GTPort</h1>
		<?php
		$username = $_SESSION['user'];
		//establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");
		//SELECT PASSWORD
		$sql_query = "SELECT	Name
				FROM		Regular_User
				WHERE   Username = '$username';";

		$result = mysql_query($sql_query) or die('error: ' . mysql_error());
		$nRow = mysql_num_rows($result);
		if ($nRow == 0) {
			echo "Please enter information before using service!<br><input type='button' value='Personal Information' onclick='location.href=\"faculty_personal_information.php\"'/>";
		} else {
			echo "<input type='button' value='Personal Information' onclick='location.href=\"student_personal_information.php\"'/><br><input type='button' value='Student Service' onclick='location.href=\"faculty_service.php\"'/>";
		}
		//close connection
		mysql_close($link);
		?>
	</body>
</html>