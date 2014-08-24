<p>To change your password, type in your current password and then create a new password and re-type it to confirm.</p>

<br />
<div class="row">
  <div class="col-lg-8">

    <form action="password_submit" method="post">
      <div class="form-group">
        <label>Current Password</label>
        <input type="password" name="old" class="form-control" />
      </div>
      <div class="form-group">
        <label>New Password</label>
        <input type="password" name="new" class="form-control" />
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="confirm" class="form-control" />
      </div>
      <input type="submit" name="submit" value="Change" class="btn btn-primary" />
    </form>

  </div>
</div>