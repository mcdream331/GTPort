<?php
session_start();
?>
<html>
	<body>
		<h1>
			GTPort
		</h1>

		<?php
		$department = $_POST['department'];
		$username = $_SESSION['user'];
		//echo $department;
		//echo $username;
		
		$string='';
		$string.="<table><tr><td>Term:</td><td>Fall 2012</td></tr>
				<tr><td>Department:</td><td>$department</td></tr></table>";
		echo $string;
		//establish connection
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");

		$string2='<form action="Register_course2.php" method="post">';
		$string2.='<table><tr>
					<th>Select</th>
					<th>CRN</th>
					<th>Title</th>
					<th>Course Code</th>
					<th>Section</th>
					<th>Instructor</th>
					<th>Days</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Location</th>
					<th>Mode of Grading</th>
				</tr>';
		//insert user
		$sql_query = "SELECT    Dept_Id 
					FROM        Department 
					WHERE    Name = '$department'";
		$result = mysql_query($sql_query) or die('insert user table error: ' . mysql_error());
		$departmentId = mysql_result($result, 0,"Dept_Id");
		
		$sql_query1 = "SELECT    CRN, Title, Code, Letter, Name, Day, Start_Time, End_Time, Location 
					FROM     (Section NATURAL JOIN (Department_Course NATURAL JOIN Course_Code)) JOIN Regular_User ON Instructor_Username = Username
					WHERE    Dept_Id = '$departmentId' AND Term = 'Fall 2012'";
		$result1 = mysql_query($sql_query1) or die('insert regular user table error: ' . mysql_error());
		$rowcount1 = mysql_num_rows($result1);
		if($rowcount1!=0){
			for ($i=0; $i < $rowcount1; $i++) { 
				$crn = mysql_result($result1, $i,"CRN");
				$title = mysql_result($result1, $i,"Title");
				$code = mysql_result($result1, $i,"Code");
				$letter = mysql_result($result1, $i,"Letter");
				$name = mysql_result($result1, $i,"Name");
				$day = mysql_result($result1, $i,"Day");
				$start_time = mysql_result($result1, $i,"Start_Time");
				$end_time = mysql_result($result1, $i,"End_Time");
				$location = mysql_result($result1, $i,"Location");
				
				//add to table
				$string2.='<tr>
					<td><input type="checkbox" name="crn"value="'.$crn.'"></td>
					<td>$crn</td>
					<td>$title</td>
					<td>$code</td>
					<td>$letter</td>
					<td>$name</td>
					<td>$day</td>
					<td>$start_time</td>
					<td>$end_time</td>
					<td>$location/td>
					<td><select name="">
						<option value="R">Register</option>
						<option value="A">Audit</option>
						<option value="P">Pass/Fail</option>
					</select></td>
				</tr>';
			}
		}

		$string2.="</table>";
		//close connection
		mysql_close($link);
		?>