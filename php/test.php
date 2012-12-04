<?php
$string = "<form action='student_personal_information_1.php' method='post'><table>";
$string .= "<tr><td>Major</td>
				<td><select name='major'>
				<option value='AE'>Aerospace Engineering</option>
				<option value='BIO'>Biology</option>
				<option value='BE'>Biological Engineering</option>
				<option value='CS'>Computer Science</option>
				<option value='ECE'>Electrical & Computer Engineering</option>
				</select></td></tr>";
$string .= "</table><input type='Submit' value='Update'/>";

echo $string;
?>