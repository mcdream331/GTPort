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
		if (mysql_result($result, 0,'Name') == '') {
			echo "Please enter information before using service!<br><input type='button' value='Personal Information' onclick='location.href=\"Faculty_personal_information.php\"'/>";
		} else {
			echo "<input type='button' value='Personal Information' onclick='location.href=\"Faculty_personal_information.php\"'/><br><input type='button' value='Faculty Service' onclick='location.href=\"faculty_service.php\"'/>";
		}
		//close connection
		mysql_close($link);
		?>
	</body>
</html>