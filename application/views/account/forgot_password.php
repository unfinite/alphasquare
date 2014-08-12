<div class="row">
	<div class="col-lg-6 col-md-8 col-sm-12 col-centered">
		<div class="page-header">
			<h1>Forgot Password</h1>
		</div>
		<p>Just enter your email address below and we'll send you a link to reset your password.</p>
		<form action="forgot_password_submit" method="post">
			<div class="form-group">
				<input type="email" name="email" id="email" placeholder="Email" class="form-control" autofocus />
			</div>
			<button name="submit" class="btn btn-primary" value="true">Submit</button>
			&nbsp; <a href="login">Cancel</a>
		</form>
		<br />
		<div class="well text-center">
			Don't have an account? <a href="<?=base_url('register')?>">Create one &raquo;</a>
		</div>
	</div>
</div>