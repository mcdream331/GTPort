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
		$username = $_SESSION("user");
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
						WHERE Username = '$username'";
		$result1 = mysql_query($sql_query1) or die(mysql_error());
		while ($row1 = mysql_fetch_array($result1)) {
			$positon = $row1["Position"];
			$department = $row1["Name"];
		}
		$string.="<tr><td>Department</td>
				<td><select name="Department">
				<td><select name='major'>
				<option value='AE'";if($major=="AE"){$string.=" selected";}$string.=">Aerospace Engineering</option>
				<option value='BIO'";if($major=="BIO"){$string.=" selected";}$string.=">Biology</option>
				<option value='BE'";if($major=="BE"){$string.=" selected";}$string.=">Biological Engineering</option>
				<option value='CS'";if($major=="CS"){$string.=" selected";}$string.=">Computer Science</option>
				<option value='ECE'";if($major=="ECE"){$string.=" selected";}$string.=">Electrical & Computer Engineering</option>
				</select></td></tr>";
		$string.="<tr><td>Degree</td>
				<td><select name='degree'>
				<option value='profession'";if($position=="professor"){$string.=" selected";}$string.=">professor</option>
				<option value='associate_professor'";if($postion=="associate_professor"){$string.=" selected";}$string.=">associate_professor</option>
				<option value='assistant_professor'";if($potision=="assistant_professor"){$string.=" selected";}$string.=">assistant_professor</option>
				</select></td></tr>";
		
		//Populate Drop Down for Course and Section
		$sql_query2 = "	SELECT Title 
						FROM Department_Course as C, Department as D 
						WHERE D.Name = '$department' AND D.Dept_Id = 'C.Dept_Id'";
		$result2 = $mysql_query($sql_query2) or die(mysql_error());
		while($row2 = mysql_fetch_array($result2){
		$title = $row2['Title'];
		$sql_query3 = "SELECT Letter FROM Section WHERE Title = '$title'";
		$result3 = $mysql_query($sql_query3) or die(mysql_error());
		};

		echo $string;
		
		mysql_close ($link);
		?>
	</body>
</html>
