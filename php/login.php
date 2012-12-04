<!DOCTYPE html>
<html>
	<body>
		<h1>GT Port</h1>

		<form action="login_1.php" method="post">
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
			</table>

			<input type="Submit" value="Login"/>
			<input type="button" value="Create Account" onclick="location.href='create_account.php'" />
		</form>
	</body>
</html>