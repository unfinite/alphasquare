<div class="row">
  <div class="col-lg-6 col-md-8 col-sm-12 col-centered">
    <div class="page-header">
      <h1>Sign in</h1>
    </div>
    <form action="" method="post">
      <input type="hidden" name="next" value="<?=$this->input->get('next')?>" />
      <div class="form-group">
        <input type="text"
               name="username"
               id="username"
               placeholder="Username"
               class="form-control"
               autofocus
               value="<?=$this->input->get('username')?>" />
      </div>
      <div class="form-group">
        <input type="password"
               name="password"
               id="password"
               placeholder="Password"
               class="form-control" />
      </div>
      <button name="submit" class="btn btn-primary" value="true">Sign in</button>
      &nbsp;
      <a href="<?=base_url('account/forgot_password')?>" class="text-small">Forgot your password?</a>
    </form>
    <br />
    <div class="well text-center">
      Don't have an account? <a href="<?=base_url('register')?>">Create one &raquo;</a>
    </div>
  </div>
</div>