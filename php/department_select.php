<!DOCTYPE html>
<html>
	<body>
		<h1>GT Port</h1>

		<form action="Register_course.php" method="post">
			<table>
				<tr>
					<td>Major</td>
					<td>
					<select name='department'>
						<option value='AE'>Aerospace Engineering</option>
						<option value='BIO'>Biology</option>
						<option value='BE'>Biological Engineering</option>
						<option value='CS'>Computer Science</option>
						<option value='ECE'>Electrical & Computer Engineering</option>
					</select></td>
				</tr>
			</table>

			<input type="Submit" value="Next"/>
			<input type="button" value="Back" onclick="location.href='student_service.php'" />
		</form>
	</body>
</html>