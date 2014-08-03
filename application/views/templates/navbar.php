<? if(!$this->php_session->get('logged_in')): ?>

<nav class="navbar navbar-fixed-top logged-in" role="navigation">
  <div class="navbar-header">
    <a class="navbar-brand lobster" id="slingshot" href="#" rel="popover" type="button" data-toggle="popover" >alphasquare</a>
  </div>
</nav>

<? else: ?>

<nav class="navbar navbar-fixed-top logged-out" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/" >alphasquare</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse">
    <p class="navbar-text pull-right">
      <a href="login" class="no-decor-link open-sans" style="text-decoration:none;color:white;">Have an account? Sign in &raquo;</a>
    </p>
  </div><!-- /.navbar-collapse -->
</nav>

<? endif; ?>