<?php
session_start();
?>
<html>
	<body>
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
			mysql_close($link);
			echo "User not exist!<br><input type='button' value='Login' onclick='location.href=\"login.php\"'/>";
		} else {
			$row = mysql_fetch_assoc($result);
			if ($row != NIL) {
				if ($row["Password"] != $password) {
					echo "Login failure! Please try again.<br><input type='button' value='Login' onclick='location.href=\"login.php\"'/>";
				}
				//close connection
				mysql_close($link);
			}
		}
		?>
	</body>
</html>