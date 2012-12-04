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
<!-- spi  -->
<?php
$link = mysql_connect("localhost", "root", "root");
if (!$link) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db(cs4400) or die("Unable to select database");;
//Get username
$username = $_GET("username");

//View Personal Information
$sql_query = "SELECT Name, DOB, Gender, Address, Permanent_Address, Contact_Number, Email_Id FROM Regular_User WHERE Username = '$username'";
$result = mysql_query ($sql_query) or die (mysql_error());
while($row = mysql_fetch_array($result)){
$name = $row["Name"];
$dob = $row["DOB"];
$gender = $row["gender"];
$address = $row["Address"];
$permenant_address = $row["Permanent_Address"];
$contact_number = $row["Contact_Number"];
$email = $row["Email_Id"];
}

//View Available Tutor Course
//Populate Drop Down for tutor course
$sql_quer1 = "SELECT Code FROM (Student_Section NATURAL JOIN Section) NATURAL JOIN Course_Code WHERE Grade_Mode = 'R' AND (Grade = 'A' OR Grade = 'B') AND Student_Username = '$username'";
$result1 = $mysql_query ($sql_query1) or die (mysql_error());
$rowcount = mysql_numrows($result);
$i=0;
$string = '';
while ($i< $rowcount) {

$string = $string.'<input type="checkbox" id="'.mysql_result($result1,$i,"Code").'" />'.'<label for="'.mysql_result($result1,$i,'Code').'">'.mysql_result($result1,$i,'Code').'</label>';

}
echo $string

 //After Entering Information new information
 $name = $_Get["name"];
 $dob =  $_Get["dob"];
 $gender = $_Get["gender"];
 $address = $_Get["address"];
 $permenant_address = $_Get["permenant_address"];
 $contact_number = $_Get["number"];
 $email =$_Get["email"];

 
 //Update Personal Information
 $sql_query4 = "UPDATE Regular_User	Name = '$name', Gender = '$gender', DOB = '$dob', Email_ID = '$email', Contact_Number = '$contact_number', Address = '$address', Permanent_Address= '$permanent_address' WHERE Username = '$username'"
 mysql_query($sql_query4)or die (mysql_error());
 
 
 //Apply for Tutor Course
 $sql_query7 = "INSERT INTO Apply_Tutor (Student_Username, Title) VALUES ('$username', '$Title')";
 mysql_query ($sql_query7) or die (mysql_error());
 
 //Get History Information from Input
 $name_of_school = $_Get["name_of_school"];
 $Year_Of_Grade = $_Get["Year_Of_Grade"];
 $Degree = $_Get["Degree"];
 $major = $_Get["major"];
 $GPA = $_Get["GPA"];
 
 //Add Previous Education
 $sql_query8 = "INSERT INTO Education_History (Student_Username, Name_of_School, Year_Of_Grad, Degree, Major, GPA) VALUES ('$username', '$name_of_school', '$Year_Of_Grade', '$Degree', '$Major', '$GPA')";
 mysql_query ($sql_query8) or die (mysql_error());
 
 mysql_close($link)
 echo "succeed";
 ?>