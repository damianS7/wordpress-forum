<div class="row">
	<div class="col-sm-12">
		<form method="POST">
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" name="username" class="form-control" value="<?php echo $_SESSION['account']->username; ?>">
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" name="email" aria-describedby="emailHelp" value="<?php echo $_SESSION['account']->email; ?>">
            </div>
            <div class="form-group">
				<label for="exampleInputPassword1">Old Password</label>
				<input type="password" class="form-control" name="password1" placeholder="Old password">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">New password</label>
				<input type="password" class="form-control" name="password2" placeholder="Password">
			</div>
			<div class="form-group">
                <label for="exampleInputPassword1">Repeat password</label>
				<input type="password" class="form-control" name="password3" placeholder="Repeat password">
			</div>
			<div class="form-group">
				<button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">UPDATE</button>
			</div>
		</form>
	</div>
</div>

