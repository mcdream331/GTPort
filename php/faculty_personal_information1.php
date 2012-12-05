<?php
session_start();
?>
<html>
	<body>
		<h1> GTPORT </h1>
		<?php
		//Get username
		$username = $_SESSION["user"];

		//echo $username;
		$string = '';
		//View Personal Information
		$name = $_POST["name"];
		$dob = $_POST["dob"];
		$gender = $_POST["gender"];
		$address = $_POST["address"];
		$permenant_address = $_POST["permenant_address"];
		$contact_number = $_POST["contact_number"];
		$email = $_POST["email"];
		$position = $_POST["position"];
		$department = $_POST["department"];
		$research_interest = $_POST['research_interest'];

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
		
		$string .= "<form action='faculty_personal_information2.php' method = 'post'><table>";
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

		if ($department == "AE") {
			$string .= "<tr><td>Department</td>
				<td><select name='department'>
				<option value='AE'>Aerospace Engineering</option>
				<option value='BIO'>Biology</option>
				<option value='BME'>Biomedical Engineering</option>
				<option value='CS'>Computer Science</option>
				<option value='ECE'>Electrical & Computer Engineering</option>
				</select></td><td><input type='button' value='Back to department select' onclick='location.href=\"faculty_personal_information.php\"'/></td></tr>";
		} elseif ($department == "BIO") {
			$string .= "<tr><td>Department</td>
				<td><select name='department'>
				<option value='BIO'>Biology</option>
				<option value='AE'>Aerospace Engineering</option>
				<option value='BME'>Biomedical Engineering</option>
				<option value='CS'>Computer Science</option>
				<option value='ECE'>Electrical & Computer Engineering</option>
				</select></td><td><input type='button' value='Back to department select' onclick='location.href=\"faculty_personal_information.php\"'/></td></tr>";
		} elseif ($department == "BME") {
			$string .= "<tr><td>Department</td>
				<td><select name='department'>
				<option value='BME'>Biomedical Engineering</option>
				<option value='BIO'>Biology</option>
				<option value='AE'>Aerospace Engineering</option>
				<option value='CS'>Computer Science</option>
				<option value='ECE'>Electrical & Computer Engineering</option>
				</select></td><td><input type='button' value='Back to department select' onclick='location.href=\"faculty_personal_information.php\"'/></td></tr>";
		} elseif ($department == "CS") {
			$string .= "<tr><td>Department</td>
				<td><select name='department'>
				<option value='CS'>Computer Science</option>
				<option value='BIO'>Biology</option>
				<option value='AE'>Aerospace Engineering</option>
				<option value='BME'>Biomedical Engineering</option>
				<option value='ECE'>Electrical & Computer Engineering</option>
				</select></td><td><input type='button' value='Back to department select' onclick='location.href=\"faculty_personal_information.php\"'/></td></tr>";
		} elseif ($department == "ECE") {
			$string .= "<tr><td>Department</td>
				<td><select name='department'>
				<option value='ECE'>Electrical & Computer Engineering</option>
				<option value='BIO'>Biology</option>
				<option value='AE'>Aerospace Engineering</option>
				<option value='BME'>Biomedical Engineering</option>
				<option value='CS'>Computer Science</option>
				</select></td><td><input type='button' value='Back to department select' onclick='location.href=\"faculty_personal_information.php\"'/></td></tr>";
		}

		if ($position == "Assistant Professor") {
			$string .= "<tr><td>Position</td>
				<td><select name='Position'>
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
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('could not connect; ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");
		
		$sql_query2 = "	SELECT Code 
						FROM Department_Course NATURAL JOIN Department
						WHERE Name = '$department'";
		$result2 = mysql_query($sql_query2) or die(mysql_error());
		$string .= "<tr><td>Course</td>
		<td><select name = 'course'>";
		while ($row2 = mysql_fetch_array($result2)) {
			//echo $row2['Code'];
			$string .= "<option value='".$row2['Code']."'>".$row2['Code']."</option>";
		}
		$string .= "</select></td><td><input type='Submit' value='Confirm Course'/></td></tr>";
		
		$string .= "<tr><td>Section</td>
		<td><select name = 'section'></td></tr>";

		//View Research Interest
		$string .= "<tr><td>Research Interests</td>
					<td><input type='text' name='research_interest' value='$research_interest'/></td></tr>";
		
		$string.="</table><input type='button' value='Homepage' onclick='location.href=\"faculty_homepage.php\"'/>";
		echo $string;

		mysql_close($link);
		?>
	</body>
</html>