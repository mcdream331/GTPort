<!DOCTYPE html>
<html>
	<body>
		<h1>GT Port</h1>

		<form action="create_account_1.php" method="post">
			<table>
				<tr>
					<td>Username</td>
					<td><input type="text" name="username"/></td>
				</tr>
				<tr>
					<td>Password</td>
					<td>
					<input type="text" name="password"/>
					</td>
				</tr>
				<tr>
					<td>Confirm Password</td>
					<td>
					<input type="text" name="confirm_password"/>
					</td>
				</tr>
				<tr>
					<td>Usertype</td>
					<td>
					<select name="user_type">
						<option value="student">Student</option>
						<option value="faculty">Faculty</option>
					</select>
					</td>
				</tr>
			</table>

			<input type="Submit" value="Register"/>
		</form>

	</body>
</html>
