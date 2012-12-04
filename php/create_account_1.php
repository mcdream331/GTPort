<html>
	<body>
		<?php
		$username = $_POST['username'];
		//echo $username.'<br>';
		$password = $_POST['password'];
		//echo $password.'<br>';
		$confirm_username = $_POST['confirm_password'];
		//echo $confirm_username.'<br>';
		$user_type = $_POST['user_type'];
		//echo $user_type.'<br>';
		//check
		if ($username == "") {
			echo "Please enter username.<br> <input type='button' value='Create Account' onclick='location.href=\"create_account.php\"'/>";
		} elseif ($password == "" || $confirm_username == "") {
			echo "Please enter password.<br> <input type='button' value='Create Account' onclick='location.href=\"create_account.php\"'/>";
		} elseif ($password != $confirm_username) {
			echo "Please make sure password matches.<br> <input type='button' value='Create Account' onclick='location.href=\"create_account.php\"'/>";
		} else {

			//establish connection
			$link = mysql_connect("localhost", "root", "root");
			if (!$link) {
				die('Could not connect: ' . mysql_error());
			}
			mysql_select_db(cs4400) or die("Unable to select database");

			//insert user
			$sql_query = "INSERT INTO User (Username, Password) VALUES ('$username', '$password')";
			$sql_query1 = "INSERT INTO Regular_User (Username) VALUES ('$username')";

			mysql_query($sql_query) or die('insert user table error: ' . mysql_error());
			mysql_query($sql_query1) or die('insert regular user table error: ' . mysql_error());

			if ($usertype == "student") {
				$sql_query2 = "INSERT INTO Student (Student_Username) VALUES ('$username')";
			} elseif ($usertype == "faculty") {
				$sql_query2 = "INSERT INTO Faculty (Instructor_Username, Dept_Id) VALUES ('$username','1')";
			}

			mysql_query($sql_query2) or die('insert student/faculty table error:' . mysql_error());
			//close connection
			mysql_close($link);
			
			echo "Register Succeed! Please click login below. <br> <input type='button' value='Login' onclick='location.href=\"login.php\"'/>";
		}
	?>
</body>
</html>