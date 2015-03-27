<p>
<?php if($existing_password): ?>
To change your password, type in your current password and 
then create a new password and confirm it.
<?php else: ?>
Because you registered with an OAuth account (Facebook or 
Google) and use it to sign in, your Alphasquare account does 
<em>not</em> have a password set. 
</p>
<p>
If you would like to sign in to Alphasquare with your 
username and a password, please create a password below. 
<b>You will still be able to sign in with any connected (OAuth) accounts.</b>
<?php endif; ?>
</p>

<br />
<div class="row">
  <div class="col-lg-8">

    <form action="password_submit" method="post">
      
      <?php if($existing_password): ?>
      <div class="form-group">
        <label>Current Password</label>
        <input type="password" name="current" class="form-control" />
      </div>
      <?php endif; ?>

      <div class="form-group">
        <label>New Password</label>
        <input type="password" name="new" class="form-control" />
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="confirm" class="form-control" />
      </div>
      <input type="submit" name="submit" value="Submit" class="btn btn-primary" />
    </form>

  </div>
</div>