<? show_form_errors($errors); ?>

<div class="row">
	<div class="col-lg-6 col-md-8 col-sm-10 col-centered">
		<div class="page-header">
			<h1>Register</h1>
		</div>

		<? $this->load->view('account/oauth_buttons'); ?>
		
		<form action="" method="post">
			<div class="form-group">
				<input type="text" name="username" id="username" placeholder="Username" class="form-control" value="<?=set_value('username')?>" />
			</div>
			<div class="form-group">
				<input type="email" name="email" id="email" placeholder="Email" class="form-control" value="<?=set_value('email')?>" />
			</div>
			<div class="form-group">
				<input type="password" name="password" id="password" placeholder="Password" class="form-control" />
			</div>
			<div class="form-group">
				<input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="form-control" />
			</div>
			<p>By using Alphasquare, you agree with the
				<a href="about/terms" target="_blank">terms of service</a>
				and <a href="about/privacy" target="_blank">privacy policy</a>.</p>
				<br>
				 <?php echo $recaptcha_html; ?>
				 <br>
			<button name="submit" class="btn btn-primary" value="true">Register</button>
		</form>
		<br />
		<div class="well text-center">
			Already have an account? <a href="<?=base_url('login')?>">Sign in &raquo;</a>
		</div>
	</div>
</div>