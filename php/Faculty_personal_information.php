<?php
session_start();
?>
<html>
	<body>
		<h1>
			GTPORT
		<h1>
		<?php
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('could not connect; ' .mysql_error());
		}
		mysql_select_db (cs4400) or die ("Unable to select database");
		
		//Get username
		$username = $_SESSION["user"];
		
		echo $username;
		$string = '';
		//View Personal Information
		$sql_query = "	SELECT Name, DOB, Gender, Address, Permanent_Address, Contact_Number, Email_Id 
						FROM Regular_User 
						WHERE Username = '$username'";
		$result = mysql_query($sql_query) or die(mysql_error());
		while ($row = mysql_fetch_array($result)) {
			$name = $row["Name"];
			$dob = $row["DOB"];
			$gender = $row["gender"];
			$address = $row["Address"];
			$permenant_address = $row["Permanent_Address"];
			$contact_number = $row["Contact_Number"];
			$email = $row["Email_Id"];
		}
		$string.="<form action='faculty_personal_information_1.php' method = 'post'><table>";
		$string.="<tr><td>Name</td>
					<td><input type='text' name='name' value=\"$name\"/></td></tr>";
		$string.="<tr><td>DOB</td>
					<td><input type='text' name='dob' value='$dob'/></td></tr>";
		$string.="<tr><td>Gender</td>
					<td><input type='text' name='gender' value='$gender'/></td></tr>";
		$string.="<tr><td>Address</td>
					<td><input type='text' name='address' value=\"$address\"/></td></tr>";
		$string.="<tr><td>Permenant Address</td>
					<td><input type='text' name='permenant_address' value=\"$permenant_address\"/></td></tr>";
		$string.="<tr><td>Contact Number</td>
					<td><input type='text' name='contact_number' value='$contact_number'/></td></tr>";
		$string.="<tr><td>Email</td>
					<td><input type='text' name='email' value='$email'/></td></tr>";		
		
		//View Department Information
		$sql_query1 = "	SELECT Position, Name 
						FROM Faculty NATURAL JOIN Department 
						WHERE Instructor_Username = '$username'";
		$result1 = mysql_query($sql_query1) or die(mysql_error());
		while ($row1 = mysql_fetch_array($result1)) {
			$positon = $row1["Position"];
			$department = $row1["Name"];
		}
		
		if($department=="AE"){
		$string.="<tr><td>Department</td>
				<td><select name='department'>
				<option value='AE'>Aerospace Engineering</option>
				<option value='BIO'>Biology</option>
				<option value='BE'>Biological Engineering</option>
				<option value='CS'>Computer Science</option>
				<option value='ECE'>Electrical & Computer Engineering</option>
				</select></td></tr>";
		}
		elseif ($department=="BIO") {
			$string.="<tr><td>Department</td>
				<td><select name='department'>
				<option value='BIO'>Biology</option>
				<option value='AE'>Aerospace Engineering</option>
				<option value='BE'>Biological Engineering</option>
				<option value='CS'>Computer Science</option>
				<option value='ECE'>Electrical & Computer Engineering</option>
				</select></td></tr>";
		}
		elseif ($department=="BE") {
			$string.="<tr><td>Department</td>
				<td><select name='department'>
				<option value='BE'>Biological Engineering</option>
				<option value='BIO'>Biology</option>
				<option value='AE'>Aerospace Engineering</option>
				<option value='CS'>Computer Science</option>
				<option value='ECE'>Electrical & Computer Engineering</option>
				</select></td></tr>";
		}
		elseif ($department=="CS") {
			$string.="<tr><td>Department</td>
				<td><select name='department'>
				<option value='CS'>Computer Science</option>
				<option value='BIO'>Biology</option>
				<option value='AE'>Aerospace Engineering</option>
				<option value='BE'>Biological Engineering</option>
				<option value='ECE'>Electrical & Computer Engineering</option>
				</select></td></tr>";
		}
		elseif ($department=="ECE") {
			$string.="<tr><td>Department</td>
				<td><select name='department'>
				<option value='ECE'>Electrical & Computer Engineering</option>
				<option value='BIO'>Biology</option>
				<option value='AE'>Aerospace Engineering</option>
				<option value='BE'>Biological Engineering</option>
				<option value='CS'>Computer Science</option>
				</select></td></tr>";
		}
		
				
		if($position=="Professor"){
			$string.="<tr><td>Position</td>
				<td><select name='position'>
				<option value='Professor'";if($position=="Professor"){$string.=" selected";}$string.=">Professor.</option>
				<option value='Associate Professor'";if($position=="Associate Professor"){$string.=" selected";}$string.=">Associate Professor.</option>
				<option value='Assistant Professor'";if($position=="Assistant Professor"){$string.=" selected";}$string.=">Assistant Professor</option>
				</select></td></tr>";
		}
		if($position=="Associate Professor"){
			$string.="<tr><td>Position</td>
				<td><select name='position'>
				<option value='Associate Professor'";if($position=="Associate Professor"){$string.=" selected";}$string.=">Associate Professor.</option>
				<option value='Professor'";if($position=="Professor"){$string.=" selected";}$string.=">Professor</option>
				<option value='Assistant Professor'";if($position=="Assistant Professor"){$string.=" selected";}$string.=">Assistant Professor</option>
				</select></td></tr>";
		}
		if($position=="Assistant Professor"){
			$string.="<tr><td>Position</td>
				<td><select name='Position'>
				<option value='Assistant Professor'";if($position=="Assistant Professor"){$string.=" selected";}$string.=">Assistant Professor</option>
				<option value='Associate Professor'";if($position=="Associate Professor"){$string.=" selected";}$string.=">Associate Professor.</option>
				<option value='Professor'";if($position=="Professor"){$string.=" selected";}$string.=">Professor</option>
				</select></td></tr>";
		}
		echo $string;
		//Populate Drop Down for Course and Section
		$sql_query2 = "	SELECT Title 
						FROM Department_Course as C, Department as D 
						WHERE D.Name = '$department' AND D.Dept_Id = 'C.Dept_Id'";
		$result2 = $mysql_query($sql_query2) or die(mysql_error());
		// while($row2 = mysql_fetch_array($result2)){
		// $title = $row2['Title'];
		// $sql_query3 = "SELECT Letter FROM Section WHERE Title = '$title'";
		// $result3 = $mysql_query($sql_query3) or die(mysql_error());
		// $string.="";
			// while($row3 = mysql_fetch_arrary($result3)){
			// $section = $row3['Section'];
			// $string.="	<tr><td>Section</td>
						// <tr><select name = 'Section'>";}
		// };
		
		//View Research Interest
		$sql_query4 = "	SELECT Research_Interests
						FROM Faculty_Research_Interest
						WHERE Instructor_Username = '$username'";
		$result4 = $mysql_query($sql_query4) or die (mysql_error());
		$research_interest = $mysql_fetch_array($result4);
		$string.="<tr><td>Research Interests</td>
						<td><input type='text' name='research_interest' value=\"$research_interest\"/></td></tr>";
		
		
		
		mysql_close ($link);
		?>
	</body>
</html>