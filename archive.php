<!--create account  -->
<?php
header("Access-Control-Allow-Origin: *");

$username = $_GET['un'];
$password = $_GET['pw'];
$usertype = $_GET['ut'];
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
	$sql_query2 = "INSERT INTO Student (Student_Username) VALUES ('$username');";
} elseif ($usertype == "faculty") {
	$sql_query2 = "INSERT INTO Faculty (Instructor_Username, Dept_Id) VALUES ('$username','1');";
}

mysql_query($sql_query2) or die('insert student/faculty table error:' . mysql_error());
//close connection
mysql_close($link);

echo "succeed";
?>

<!-- login1  -->
<?php
header("Access-Control-Allow-Origin: *");

$username = $_GET['un'];
$password = $_GET['pw'];

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
$row = mysql_fetch_assoc($result);
if ($row != NIL) {
	if ($row["Password"] != $password) {
		echo "false";
	} else {
		session_start();
		$_SESSION['user']=$username;
		
		echo $_SESSION['user'];
	}
}
else {
	echo "false";
}

//close connection
mysql_close($link);
?>
<!--login2  -->
<?php
header("Access-Control-Allow-Origin: *");

session_start();
$username = $_SESSION['user'];
echo $username;

if ($username != NIL) {
	
	//establish connection
	$link = mysql_connect("localhost", "root", "root");
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db(cs4400) or die("Unable to select database");

	//see if it's admin user
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
		if ($row2 == NIL) {
			echo "student";
		} else {
			echo "faculty";
		}
	} else {
		echo "admin";
	}
	mysql_close($link);
}
?>