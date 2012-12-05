<?php
session_start();
?>
<html>
	<body>
		<h1> GTPORT </h1>
		<?php
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('could not connect; ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");

		//Get username
		$username = $_SESSION["user"];

		//echo $username;
		$string = '';
		//View Personal Information
		$sql_query = "	SELECT Name, DOB, Gender, Address, Permanent_Address, Contact_Number, Email_Id 
						FROM Regular_User 
						WHERE Username = '$username'";
		$result = mysql_query($sql_query) or die(mysql_error());
		while ($row = mysql_fetch_array($result)) {
			$name = $row["Name"];
			$dob = $row["DOB"];
			$gender = $row["Gender"];
			$address = $row["Address"];
			$permenant_address = $row["Permanent_Address"];
			$contact_number = $row["Contact_Number"];
			$email = $row["Email_Id"];
		}
		$string .= "<form action='faculty_personal_information1.php' method = 'post'><table>";
		$string .= "<tr><td>Name</td>
					<td><input type='text' name='name' value=\"$name\"/></td></tr>";
		$string .= "<tr><td>DOB</td>
					<td><input type='text' name='dob' value='$dob'/></td></tr>";
		$string .= "<tr><td>Gender</td>
					<td><input type='text' name='gender' value='$gender'/></td></tr>";
		$string .= "<tr><td>Address</td>
					<td><input type='text' name='address' value=\"$address\"/></td></tr>";
		$string .= "<tr><td>Permenant Address</td>
					<td><input type='text' name='permenant_address' value=\"$permenant_address\"/></td></tr>";
		$string .= "<tr><td>Contact Number</td>
					<td><input type='text' name='contact_number' value='$contact_number'/></td></tr>";
		$string .= "<tr><td>Email</td>
					<td><input type='text' name='email' value='$email'/></td></tr>";

		//View Department Information
		$sql_query1 = "	SELECT Position, Name 
						FROM Faculty NATURAL JOIN Department 
						WHERE Instructor_Username = '$username'";
		$result1 = mysql_query($sql_query1) or die(mysql_error());
		while ($row1 = mysql_fetch_array($result1)) {
			$position = $row1["Position"];
			$department = $row1["Name"];
		}
		// echo $position;
		// echo $department;
		if ($department == "AE") {
			$string .= "<tr><td>Department</td>
				<td><select name='department'>
				<option value='AE'>Aerospace Engineering</option>
				<option value='BIO'>Biology</option>
				<option value='BME'>Biomedical Engineering</option>
				<option value='CS'>Computer Science</option>
				<option value='ECE'>Electrical & Computer Engineering</option>
				</select></td>
				<td><input type='Submit' value='Confirm Department'/></td></tr>";
		} elseif ($department == "BIO") {
			$string .= "<tr><td>Department</td>
				<td><select name='department'>
				<option value='BIO'>Biology</option>
				<option value='AE'>Aerospace Engineering</option>
				<option value='BME'>Biomedical Engineering</option>
				<option value='CS'>Computer Science</option>
				<option value='ECE'>Electrical & Computer Engineering</option>
				</select></td><td><input type='Submit' value='Confirm Department'/></td></tr>";
		} elseif ($department == "BME") {
			$string .= "<tr><td>Department</td>
				<td><select name='department'>
				<option value='BME'>Biomedical Engineering</option>
				<option value='BIO'>Biology</option>
				<option value='AE'>Aerospace Engineering</option>
				<option value='CS'>Computer Science</option>
				<option value='ECE'>Electrical & Computer Engineering</option>
				</select></td><td><input type='Submit' value='Confirm Department'/></td></tr>";
		} elseif ($department == "CS") {
			$string .= "<tr><td>Department</td>
				<td><select name='department'>
				<option value='CS'>Computer Science</option>
				<option value='BIO'>Biology</option>
				<option value='AE'>Aerospace Engineering</option>
				<option value='BME'>Biomedical Engineering</option>
				<option value='ECE'>Electrical & Computer Engineering</option>
				</select></td><td><input type='Submit' value='Confirm Department'/></td></tr>";
		} elseif ($department == "ECE") {
			$string .= "<tr><td>Department</td>
				<td><select name='department'>
				<option value='ECE'>Electrical & Computer Engineering</option>
				<option value='BIO'>Biology</option>
				<option value='AE'>Aerospace Engineering</option>
				<option value='BME'>Biomedical Engineering</option>
				<option value='CS'>Computer Science</option>
				</select></td><td><input type='Submit' value='Confirm Department'/></td></tr>";
		}

		if ($position == "Assistant Professor") {
			$string .= "<tr><td>Position</td>
				<td><select name='position'>
				<option value='Assistant Professor'>Assistant Professor</option>
				<option value='Associate Professor'>Associate Professor</option>
				<option value='Professor'>Professor</option>
				</select></td></tr>";
		} else if ($position == "Associate Professor") {
			$string .= "<tr><td>Position</td>
				<td><select name='position'>
				<option value='Associate Professor'>Associate Professor</option>
				<option value='Professor'>Professor</option>
				<option value='Assistant Professor'>Assistant Professor</option>
				</select></td></tr>";
		} else {
			$string .= "<tr><td>Position</td>
				<td><select name='position'>
				<option value='Professor'>Professor</option>
				<option value='Associate Professor'>Associate Professor</option>
				<option value='Assistant Professor'>Assistant Professor</option>
				</select></td></tr>";
		}

		//Populate Drop Down for Course and Section
		$string .= "<tr><td>Course</td>
		<td><select name = 'course'></td></tr>";
		
		$string .= "<tr><td>Section</td>
		<td><select name = 'section'></td></tr>";

		
		//View Research Interest
		$string.="<tr><td>Research Interests</td>
				<td><input type='text' name='research_interest' value=\"";
		
		$sql_query4 = "	SELECT Research_Interest
						FROM Faculty_Research_Interest
						WHERE Instructor_Username = '$username'";
		$result4 = mysql_query($sql_query4) or die(mysql_error());
		$rowcount4 = mysql_num_rows($result4);
		if($rowcount4!=0){
			while ($row = mysql_fetch_array($result4)) {
				$string.=$row['Research_Interest'];
			}
		}
		$string .= "\"/></td></tr><table>";
		
		$string.="<input type='button' value='Homepage' onclick='location.href=\"faculty_homepage.php\"'/>";		echo $string;
		mysql_close($link);
		?>
	</body>
</html>