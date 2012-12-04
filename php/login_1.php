<?php session_start(); ?>
<html>
	<body>
		<?php
		$username = $_POST['username'];
		$password = $_POST['password'];

		//establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");

		//SELECT PASSWORD
		$sql_query = "SELECT Password  
				FROM  User  
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
				} else {
					$_SESSION['user'] = $username;
					//check user type
					$sql_query1 = "SELECT 	Username
					FROM 	Administrator
					WHERE	Username = '$username';";
					$result1 = mysql_query($sql_query1) or die('error1: ' . mysql_error());
					$row1 = mysql_fetch_assoc($result1);
					if ($row1 == NIL) {

						$sql_query2 = "SELECT	Instructor_Username
						FROM		Faculty
						WHERE	Instructor_Username = '$username';";

						$result2 = mysql_query($sql_query2) or die('error2: ' . mysql_error());
						$row2 = mysql_fetch_assoc($result2);
						//redirect
						if ($row2 == NIL) {
							$usertype = "student";
							echo $_SESSION['user'] . " login succeed! <br> <input type='button' value='Go to student homepage' onclick='location.href=\"student_homepage.php\"'/>";
						} else {
							$usertype = "faculty";
							echo $_SESSION['user'] . " login succeed! <br> <input type='button' value='Go to faculty homepage' onclick='location.href=\"faculty_homepage.php\"'/>";
						}
					} else {
						echo $_SESSION['user'] . " login succeed! <br> <input type='button' value='Go to admin homepage' onclick='location.href=\"admin_homepage.php\"'/>";
					}
				}
			} else {
				echo "Something wrong! Please try again.<br><input type='button' value='Login' onclick='location.href=\"login.php\"'/>";
			}

			//close connection
			mysql_close($link);
		}
		?>
	</body>
</html>