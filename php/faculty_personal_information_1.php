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
		//echo "name:".$name."<br>";
		//echo "dob:".$dob."<br>";
		//echo "g:".$gender."<br>";
		//echo "add:".$address."<br>";
		//echo "padd:".$permenant_address."<br>";
		//echo "c#:".$contact_number."<br>";
		//echo "email:".$email."<br>";
		
		$department = $_POST["department"];
		$postition = $_POST["position"];
		echo "major:".$major;
		echo "degree:".$degree;
		
		//Establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");
		
		//Update Personal Information
		$sql_query = "UPDATE Regular_User	
					SET Name = '$name', Gender = '$gender', DOB = '$dob', Email_ID = '$email', Contact_Number = '$contact_number', Address = \"$address\", Permanent_Address= \"$permenant_address\" 
					WHERE Username = '$username'";
		mysql_query($sql_query) or die(mysql_error());
		
		//Update Student Information
		$sql_query1 = "UPDATE	Student
						SET		Major = $major, Degree = $degree
						WHERE	Username = $Username;";
		
		//Add Previous Education
		$sql_query2 = "	INSERT INTO Education_History (Student_Username, Name_of_School, Year_Of_Grad, Degree, Major, GPA) 
						VALUES ('$username', '$name_of_school', '$Year_Of_Grade', '$Degree', '$Major', '$GPA')";
		mysql_query($sql_query2) or die(mysql_error());

		//Apply for Tutor Course
		$sql_query7 = "INSERT INTO Apply_Tutor (Student_Username, Title) VALUES ('$username', '$Title')";
		mysql_query($sql_query7) or die(mysql_error());

		//POST History Information from Input
		$name_of_school = $_POST["name_of_school"];
		$Year_Of_Grade = $_POST["Year_Of_Grade"];
		$Degree = $_POST["Degree"];
		$major = $_POST["major"];
		$GPA = $_POST["GPA"];
		
		//Close Connection
		mysql_close($link);
	?>
</body>
</html>




//After Entering Information new information
		$name = $_Get["name"];
		$dob = $_Get["dob"];
		$gender = $_Get["gender"];
		$address = $_Get["address"];
		$permenant_address = $_Get["permenant_address"];
		$contact_number = $_Get["number"];
		$email = $_Get["email"];
		$department = $_Get["department"];
		$position = $_Get["position"];
		$course = $_Get["course"];
		$section = $_Get["section"];
		$research_interest = $_Get["research_interests"];

		//Update Personal Information
		$sql_query4 = "UPDATE Regular_User	Name = '$name', Gender = '$gender', DOB = '$dob', Email_ID = '$email', Contact_Number = '$contact_number', Address = '$address', Permanent_Address = '$permanent_address' WHERE Username = '$username'"
		 mysql_query($sql_query4)or die (mysql_error());

		//Update Department Information
		$sql_query5 = "SELECT	DeptId FROM Department WHERE Department.Name = '$department'";
		$sql_query6 = "UPDATE Faculty SET Position = '$position', Dept_Id = '$Dept_Id' WHERE Instructor_Username = '$username'";
		mysql_query($sql_query5) or die(mysql_error());
		mysql_query($sql_query6) or die(mysql_error());

		//Modify Course and Section
		$sql_query7 = "UPDATE Section SET Instructor_Username = '$Username' WHERE Letter = '$Letter' And Title = '$Title'";
		mysql_query($sql_query7) or die(mysql_error());

		//Update Research Interest
		$sql_query8 = "DELETE FROM Faculty_Research_Interest WHERE Instructor_Username = '$username'";
		$sql_query9 = "INSERT INTO Faculty_Research_Interest (Instructor_Username, Research_Interest) VALUES Instructor_Username = '$Username', Rearch_Interests = '$Research_Interests'";
		mysql_query($sql_query8) or die(mysql_error());
		mysql_query($sql_query9) or die(mysql_error());