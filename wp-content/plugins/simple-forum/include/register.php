<?php
if ( !empty( $_POST ) && get_query_var('spf_submit') !== NULL ) {
	
	$this->spf_create_user(
		get_query_var('spf_register_username'), 
		get_query_var('spf_register_password'), 
		get_query_var('spf_register_mail')
	);
}
?>
<form method="POST">
	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" name="spf_register_username" class="form-control" placeholder="Choose your username">
	</div>
	<div class="form-group">
		<label for="email">Email</label>
		<input type="email" class="form-control" name="spf_register_mail" aria-describedby="emailHelp" placeholder="Enter your email">
		<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1">Password</label>
		<input type="password" class="form-control" name="spf_register_password" placeholder="Password">
	</div>
	<div class="form-group">
		<input type="password" class="form-control" placeholder="Repeat password">
	</div>
	<button class="btn btn-lg btn-primary btn-block" name="spf_submit" type="submit">REGISTER</button>
</form>