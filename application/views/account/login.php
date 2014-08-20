<div class="row">
  <div class="col-lg-6 col-md-8 col-sm-12 col-centered">
    <div class="page-header">
      <h1>Sign in</h1>
    </div>
    
    <div class="text-center">
      <h5>Sign in with a social account</h5>
      <a href="login/facebook" class="btn btn-social btn-facebook">Facebook</a>
      <a href="login/twitter" class="btn btn-social btn-twitter">Twitter</a>
      <a href="login/google" class="btn btn-social btn-google-plus">Google+</a>
    </div>
    
    <hr />

    <h5 class="text-center">Sign in with an Alphasquare account</h5>
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
      Don't have an account? <a href="<?=base_url('register')?>">Create one!</a>
    </div>
  </div>
</div>