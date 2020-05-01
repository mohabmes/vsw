<?php $header = "Login"; require('inc/header.php');?>
<div class="wrapper content">
	<form action="login.php" method="POST" class="form">
		<table>
			<tr>
				<th>Username</th>
				<td><input type="text" name="username"></td>
			</tr>
			<tr>
				<th>Password</th>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" value="Login"></td>
			</tr>
		</table>
	</form>
</div>
<br><br><br><br><br>
<?php require('inc/footer.php'); ?>
