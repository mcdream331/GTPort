<?php
session_start();
?>
<html>
	<body>
		<?php
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");

		//Get username
		$username = $_SESSION['user'];
		//echo $username;
		$string = '';
		//View Personal Information
		$sql_query = "	SELECT Name, DOB, Gender, Address, Permanent_Address, Contact_Number, Email_Id 
						FROM Regular_User 
						WHERE Username = '$username'";
		$result = mysql_query($sql_query) or die(mysql_error());
		while ($row = mysql_fetch_array($result)) {
			$name = $row["Name"];
			//echo "name:".$name."<br>";
			$dob = $row["DOB"];
			//echo "dob:".$dob."<br>";
			$gender = $row["Gender"];
			//echo "g:".$gender."<br>";
			$address = $row["Address"];
			//echo "add:".$address."<br>";
			$permenant_address = $row["Permanent_Address"];
			//echo "padd:".$permenant_address."<br>";
			$contact_number = $row["Contact_Number"];
			//echo "c#:".$contact_number."<br>";
			$email = $row["Email_Id"];
			//echo "email:".$email."<br>";
		}
		$string.="<form action='login_1.php' method='post'><table>";
		$string.="<tr><td>Name</td>
					<td><input type='text' name='username' value=\"$name\"/></td></tr>";
		$string.="<tr><td>DOB</td>
					<td><input type='text' name='username' value='$dob'/></td></tr>";
		$string.="<tr><td>Gender</td>
					<td><input type='text' name='username' value='$gender'/></td></tr>";
		$string.="<tr><td>Address</td>
					<td><input type='text' name='username' value=\"$address\"/></td></tr>";
		$string.="<tr><td>Permenant Address</td>
					<td><input type='text' name='username' value=\"$permenant_address\"/></td></tr>";
		$string.="<tr><td>Contact Number</td>
					<td><input type='text' name='username' value='$contact_number'/></td></tr>";
		$string.="<tr><td>Email</td>
					<td><input type='text' name='username' value='$email'/></td></tr>";
		//View Available Tutor Course
		//Populate Drop Down for tutor course
		$sql_query1 = "	SELECT Code 
						FROM (Student_Section NATURAL JOIN Section) NATURAL JOIN Course_Code 
						WHERE Grade_Mode = 'R' AND (Grade = 'A' OR Grade = 'B') AND Student_Username = '$username'";
		$result1 = mysql_query($sql_query1);
		$rowcount = mysql_num_rows($result1);
		//echo $rowcount;
		if ($rowcount != 0) {
			$i = 0;
			$string.="<tr><td>Willing to tutor these course?</td></tr><tr>";
			while ($i < $rowcount) {

				$string .= '<td><input type="checkbox" name="tutor_course" value="'.mysql_result($result1, $i, 'Code').'"/>' . mysql_result($result1, $i, 'Code')."</td>";
				$i+=1;
			}
			$string.="</tr>";
		}
		//Degree and Major
		$sql_query2 = "	SELECT 	Degree, Major
						FROM	Student
						WHERE	Student_Username = '$username';";
		$result2 = mysql_query($sql_query2);
		$rowcount2 = mysql_num_rows($result2);
		if($rowcount2!=0){
			$row2 = mysql_fetch_array($result2);
			$degree = $row2["Degree"];
			//echo "Degree:".$degree;
			$major = $row2["Major"];
			//echo "Major:".$major;
		}
		$string.="<tr><td>Major</td>
				<td><select name='major'>
				<option value='AE'";if($major=="AE"){$string.=" selected=selected";}$string.=">Aerospace Engineering</option>
				<option value='BIO'";if($major=="BIO"){$string.=" selected=selected";}$string.=">Biology</option>
				<option value='BE'";if($major=="BE"){$string.=" selected=selected";}$string.=">Biological Engineering</option>
				<option value='CS'";if($major=="CS"){$string.=" selected=selected";}$string.=">Computer Science</option>
				<option value='ECE'";if($major=="ECE"){$string.=" selected=selected";}$string.=">Electrical & Computer Engineering</option>
				</select></td></tr>";
		$string.="<tr><td>Degree</td>
				<td><select name='degree'>
				<option value='BS'";if($degree=="BS"){$string.=" selected=selected";}$string.=">B.S.</option>
				<option value='MS'";if($degree=="MS"){$string.=" selected=selected";}$string.=">M.S.</option>
				<option value='PHD'";if($degree=="PHD"){$string.=" selected=selected";}$string.=">PhD</option>
				</select></td></tr>";
		//Previous Education History
		$string.="<tr><td>Previous Education<td><tr>";
		$sql_query3 = "	SELECT * 
						FROM Education_History 
						WHERE Student_Username='$username'";
		$result3 = mysql_query($sql_query3);
		$rowcount3 = mysql_num_rows($result3);
		//echo $rowcount3;
		$i = 0;
		if ($rowcount3 != 0) {
			
			while ($i < $rowcount3) {
				$j = $i+1;
				$string.="<tr><td>	Histroy$j</td></tr><tr>";
				$string.="<tr><td>Institute Name</td>
					<td><input type='text' name='institute_name$i' value=\"".mysql_result($result3, $i, 'Name_of_School')."\"/></td></tr>";
				$string.="<tr><td>Major</td>
					<td><input type='text' name='major$i' value=\"".mysql_result($result3, $i, 'Major')."\"/></td></tr>";
				$string.="<tr><td>Degree</td>
					<td><input type='text' name='degree$i' value=\"".mysql_result($result3, $i, 'Degree')."\"/></td></tr>";
				$string.="<tr><td>Year of Graduation</td>
					<td><input type='text' name='year_of_graduation$i' value=\"".mysql_result($result3, $i, 'Year_of_Grad')."\"/></td></tr>";
				$string.="<tr><td>GPA</td>
					<td><input type='text' name='gpa$i' value=\"".mysql_result($result3, $i, 'GPA')."\"/></td></tr>";
				$i+=1;
			}
			$string.="<tr>";
		}
		while($i<3){
			$j = $i+1;
			$string.="<tr><td>	Histroy$j</td></tr><tr>";
			$string.="<tr><td>Institute Name</td>
					<td><input type='text' name='institute_name$i'/></td></tr>";
			$string.="<tr><td>Major</td>
					<td><input type='text' name='major$i'/></td></tr>";
			$string.="<tr><td>Degree</td>
					<td><input type='text' name='degree$i'/></td></tr>";
			$string.="<tr><td>Year of Graduation</td>
					<td><input type='text' name='year_of_graduation$i'/></td></tr>";
			$string.="<tr><td>GPA</td>
					<td><input type='text' name='gpa$i'/></td></tr>";
			$i+=1;
		}
		
		$string.="</table><input type='Submit' value='Update'/><input type='button' value='Cancel' onclick='location.href=\"student_homepage.php\"' />";
		
		echo $string;

		mysql_close($link);
		?>
	</body>
</html>