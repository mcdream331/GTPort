<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<body>
		<h1>GT Port</h1>

		<form action="find_tutor_1.php" method="post">
			<table>
				<tr>
					<td>Course Code:</td>
					<td>
					<input type="text" name="course_code"/>
					</td>
					<td>OR	Keyword:</td>
					<td>
					<input type="text" name="keyword"/>
					</td>
				</tr>
			</table>

			<input type="Submit" value="Search"/>
			<input type='button' value='Back' onclick='location.href="student_service.php"'/>
		</form>
	</body>
</html>