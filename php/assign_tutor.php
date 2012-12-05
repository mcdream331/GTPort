<?php
session_start();
?>
<html>
	<body>
		<h1>
			GTPort
		</h1>
		
		<?php
		
		//establish connection
		$username = $_SESSION['user'];
		//echo $username;
		
		$link = mysql_connect("localhost", "root", "root");
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(cs4400) or die("Unable to select database");

		$sql_query1 = "SELECT DISTINCT Name 
						FROM Section NATURAL JOIN(Regular_User JOIN Apply_Tutor ON Student_Username = Username)
						WHERE Instructor_Username = '$username'";
		$result = mysql_query($sql_query1) or die('select tutor name error' . mysql_error());

		//close connection
		$string="<form action='assign_tutor1.php' method='post'><table>";
		$rowcount = mysql_num_rows($result);
		//echo $rowcount;
		if ($rowcount != 0) {
			$i = 0;
			$string.="<tr><td>Select tutor names here</td></tr><tr>";
			while ($i < $rowcount) {

				$string .= '<td><input type="checkbox" name="tutors[]" value="'.mysql_result($result, $i, 'Name').'"/>' . mysql_result($result, $i, 'Name')."</td>";
				$i+=1;
			}
			$string.="</tr>";
		}
		mysql_close($link);
		
		$string.='<input type="Submit" value="Assign"/><input type="button" value="Back" onclick="location.href=\'faculty_service.php\'"/>';
		echo $string;
		?>
	</body>
</html>