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
		
		$department = $_POST["department"];
		$postition = $_POST["position"];
		
		$research_interest = $_POST["research_interest"];
		
		//Establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");
		
		//Update Personal Information
		$sql_query = 	"UPDATE Regular_User	
						SET Name = '$name', Gender = '$gender', DOB = '$dob', Email_ID = '$email', Contact_Number = '$contact_number', Address = '$address', Permanent_Address= '$permenant_address'
						WHERE Username = '$username'";
		mysql_query($sql_query) or die(mysql_error());
		
		//Update Department Information
		$sql_query5 = 	"SELECT	DeptId 
						FROM Department 
						WHERE Department.Name = '$department'";
		$sql_query6 = 	"UPDATE Faculty 
						SET Position = '$position', Dept_Id = '$Dept_Id' 
						WHERE Instructor_Username = '$username'";
		mysql_query($sql_query5) or die(mysql_error());
		mysql_query($sql_query6) or die(mysql_error());

		//Modify Course and Section
		$sql_query7 = 	"UPDATE Section 
						SET Instructor_Username = '$Username'
						WHERE Letter = '$Letter' And Title = '$Title'";
		mysql_query($sql_query7) or die(mysql_error());

		//Update Research Interest
		$sql_query8 = 	"DELETE FROM Faculty_Research_Interest 
						WHERE Instructor_Username = '$username'";
		$sql_query9 = 	"INSERT INTO Faculty_Research_Interest (Instructor_Username, Research_Interest) 
						VALUES Instructor_Username = '$username', Rearch_Interests = '$research_interests'";
		mysql_query($sql_query8);
		mysql_query($sql_query9) or die(mysql_error());
		
		//Close Connection
		mysql_close($link);
	?>
</body>
</html>