<?php
session_start();
?>
<html>
	<body>

		<?php
		$username = $_SESSION['user'];
		
		$name = $_POST["name"];
		$dob = $_POST["dob"];
		$gender = $_POST["gender"];
		$address = $_POST["address"];
		$permenant_address = $_POST["permenant_address"];
		$contact_number = $_POST["contact_number"];
		$email = $_POST["email"];
		$position = $_POST["position"];
		$department = $_POST["department"];
		$course = $_POST['course'];
		$research_interest = $_POST['research_interest'];
		$section = $_POST['section'];

		//for debug
		// echo 'name:'.$name.'<br>';
		// echo 'dob:'.$dob.'<br>';
		// echo 'gender:'.$gender.'<br>';
		// echo 'address:'.$address.'<br>';
		// echo 'permenant_address:'.$permenant_address.'<br>';
		// echo 'contact_number:'.$contact_number.'<br>';
		// echo 'email:'.$email.'<br>';
		// echo 'position:'.$position.'<br>';
		// echo 'department:'.$department.'<br>';
		// echo 'course:'.$course.'<br>';
		
		//Establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");
		
		//Update Personal Information
		$sql_query = 	"UPDATE Regular_User	
						SET Name = '$name', Gender = '$gender', DOB = '$dob', Email_id = '$email', Contact_Number = '$contact_number', Address = '$address', Permanent_Address= '$permenant_address'
						WHERE Username = '$username'";
		mysql_query($sql_query) or die(mysql_error());
		
		//Update Department Information
		$sql_query6 = 	"UPDATE Faculty 
						SET Position = '$position'
						WHERE Instructor_Username = '$username'";
		mysql_query($sql_query6) or die(mysql_error());

		//Modify Course and Section
		$sql_query1 = "SELECT Title
						FROM Course_Code
						WHERE Code = '$course'";
		$result1 = mysql_query($sql_query1) or die(mysql_error());
		$Title = mysql_result($result1, 0,'Title');
		
		$sql_query7 = 	"UPDATE Section 
						SET Instructor_Username = '$username'
						WHERE Letter = '$section' AND Title = '$Title'";
		mysql_query($sql_query7) or die(mysql_error());

		//Update Research Interest
		$sql_query8 = 	"DELETE FROM Faculty_Research_Interest 
						WHERE Instructor_Username = '$username'";
		$sql_query9 = 	"INSERT INTO Faculty_Research_Interest (Instructor_Username, Research_Interest) 
						VALUES ('$username', '$research_interest')";
		mysql_query($sql_query8);
		mysql_query($sql_query9) or die(mysql_error());		//Close Connection
		mysql_close($link);
		
		echo "Personal Information updated!Click to go back to faculty homepage. <br><input type='button' value='Homepage' onclick='location.href=\"faculty_homepage.php\"'/>";
	?>
</body>
</html>