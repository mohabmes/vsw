<?php $header = "Upload"; require('inc/header.php'); ?>
<div class="wrapper content">
	<form action="upload.php" method="POST" enctype="multipart/form-data" class="form">
		<table>
			<tr>
				<th>Title *</th>
				<td><input type="text" name="title"  maxlength="70"></td>
			</tr>
			<tr>
				<th>Video *</th>
				<td><input type="file" name="video" accept="video/*"></td>
			</tr>
			<tr>
				<th>Thumbnail *</th>
				<td><input type="file" name="thumbnail" accept="image/*"></td>
			</tr>
			<tr>
				<th>Description</th>
				<td><textarea rows="4" cols="50" name="description" maxlength="250"></textarea></td>
			</tr>
			<tr>
				<th></th>
				<td><input type="submit" value="Upload"></td>
			</tr>
		</table>
	</form>
</div>
<?php require('inc/footer.php');?>
