<?
//Add Previous Education
		$sql_query8 = "INSERT INTO Education_History (Student_Username, Name_of_School, Year_Of_Grad, Degree, Major, GPA) VALUES ('$username', '$name_of_school', '$Year_Of_Grade', '$Degree', '$Major', '$GPA')";
		mysql_query($sql_query8) or die(mysql_error());
		
//After Entering Information new information
		$name = $_Get["name"];
		$dob = $_Get["dob"];
		$gender = $_Get["gender"];
		$address = $_Get["address"];
		$permenant_address = $_Get["permenant_address"];
		$contact_number = $_Get["number"];
		$email = $_Get["email"];

		//Update Personal Information
		$sql_query4 = "UPDATE Regular_User	Name = '$name', Gender = '$gender', DOB = '$dob', Email_ID = '$email', Contact_Number = '$contact_number', Address = '$address', Permanent_Address= '$permanent_address' WHERE Username = '$username'";
		mysql_query($sql_query4) or die(mysql_error());

		//Apply for Tutor Course
		$sql_query7 = "INSERT INTO Apply_Tutor (Student_Username, Title) VALUES ('$username', '$Title')";
		mysql_query($sql_query7) or die(mysql_error());

		//Get History Information from Input
		$name_of_school = $_Get["name_of_school"];
		$Year_Of_Grade = $_Get["Year_Of_Grade"];
		$Degree = $_Get["Degree"];
		$major = $_Get["major"];
		$GPA = $_Get["GPA"];
		?>