<form method="POST">
	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" name="username" class="form-control" placeholder="Choose your username">
	</div>
	<div class="form-group">
		<label for="">Password</label>
		<input type="password" class="form-control" name="password" placeholder="Password">
	</div>
	<button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">LOGIN</button>
</form>
<?php if (!empty($data['error_message'])): ?>
	<div class="alert alert-danger">
	<?php echo $data['error_message']; ?>
	</div>
<?php endif; ?>
<?php if (!empty($data['success_message'])): ?>
	<div class="alert alert-success">
	<?php echo $data['success_message']; ?>
	</div>
<?php endif; ?>
