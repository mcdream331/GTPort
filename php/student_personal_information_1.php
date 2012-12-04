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
		
		$major = $_POST["major"];
		$degree = $_POST["degree"];
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
						SET		Major = '$major', Degree = '$degree'
						WHERE	Username = '$username';";
		
		//Add Previous Education
		// $sql_query2 = "	INSERT INTO Education_History (Student_Username, Name_of_School, Year_Of_Grad, Degree, Major, GPA) 
						// VALUES ('$username', '$name_of_school', '$Year_Of_Grade', '$Degree', '$Major', '$GPA')";
		// mysql_query($sql_query2) or die(mysql_error());
// 
		// //Apply for Tutor Course
		// $sql_query7 = "INSERT INTO Apply_Tutor (Student_Username, Title) VALUES ('$username', '$Title')";
		// mysql_query($sql_query7) or die(mysql_error());
// 
		// //POST History Information from Input
		// $name_of_school = $_POST["name_of_school"];
		// $Year_Of_Grade = $_POST["Year_Of_Grade"];
		// $Degree = $_POST["Degree"];
		// $major = $_POST["major"];
		// $GPA = $_POST["GPA"];
		
		//Close Connection
		mysql_close($link);
	?>
</body>
</html>