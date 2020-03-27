<?php $header = "Register Now"; require('inc/header.php');?>
<div class="wrapper content">
	<form action="register.php" method="POST" class="form">
		<table>
			<tr>
				<th>Fullname</th>
				<td><input type="text" name="fullname"></td>
			</tr>
			<tr>
				<th>Username</th>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<th>Email</th>
				<td><input type="email" name="email"></td>
			</tr>
			<tr>
				<th>Password</th>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<th>Password</th>
				<td><input type="password" name="password_again"></td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" value="Register"></td>
			</tr>
		</table>
	</form>
</div>
<?php require('inc/footer.php');?>
