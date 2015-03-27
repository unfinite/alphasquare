<div class="page-header">
  <h1>Register with <?=$provider?></h1>
  <p>You're almost done! Confirm your information to finish creating an Alphasquare account.</p>
</div>

<form action="new_account_submit" method="post">
  <div class="form-group">
    <label for="name">Name</label>
    <input class="form-control" name="name" id="name" value="<?=$name?>" />
  </div>
  <div class="form-group">
    <label for="username">Username</label>
    <input class="form-control" name="username" id="username" value="<?=$username?>" />
  </div>
  <div class="form-group">
    <label for="name">Email Address</label>
    <input class="form-control" name="email" id="email" <?= isset($_GET['clear']) ? '' : 'value="'.$email.'"'; ?> placeholder="Enter your email address" />
    <?php if(isset($_GET['clear'])): ?>
    <span class="help-block text-bold text-danger">
      Please enter an email address different from the one that is on the existing account.
    </span>
    <?php endif; ?>
  </div>
  <p>
  Once you click <b>Create Account</b>, an account will be created and 
  linked with your <?=$provider?> account. To sign in to Alphasquare in 
  the future, all you'll need to do is click "<?=$provider?>" on the sign in page.
  </p>
  <div class="alert alert-warning">
  By creating an Alphasquare account, you agree with the
  <a href="<?=base_url('about/terms')?>" target="_blank" class="alert-link">terms of service</a>
  and <a href="<?=base_url('about/privacy')?>" target="_blank" class="alert-link">privacy policy</a>.
  </div>
  <input type="submit" name="submit" class="btn btn-primary" value="Create Account" />
  <a href="cancel" class="btn btn-default">Cancel</a>
</form>