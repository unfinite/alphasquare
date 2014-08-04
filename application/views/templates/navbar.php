<? if($this->php_session->get('logged_in')): ?>

<nav class="navbar navbar-fixed-top logged-in" role="navigation">
  <div class="navbar-header">
    <a class="navbar-brand" href="#">alphasquare</a>
  </div>
</nav>

<div id="slingshot-container">
  <a href="<?=profile_url()?>" class="user">
    <img class="img-circle" src="https://www.twii.me/data/user/avatar/big/2/17-1358911661-4977.jpg" >
    <h3>Nathan Johnson</h3>
  </a>
  <div class="slingshot-actions">
    <a href="<?=base_url('dashboard')?>" title="Dashboard">
      <span class="glyphicon glyphicon-globe"></span>
    </a>
    <!--<a href="<?=profile_url()?>">
      <span class="glyphicon glyphicon-user" title="My Profile"></span>
    </a>-->
    <a href="<?=base_url('find')?>">
      <span class="glyphicon glyphicon-search" title="Find"></span>
    </a>
    <a href="<?=base_url('settings')?>">
      <span class="glyphicon glyphicon-cog" title="Settings"></span>
    </a>
    <a href="<?=base_url('logout')?>">
      <span class="glyphicon glyphicon-log-out" title="Sign out"></span>
    </a>
  </div>
</div>

<? else: ?>

<nav class="navbar navbar-fixed-top logged-out" role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?=base_url()?>" >alphasquare</a>
  </div>
  <div class="collapse navbar-collapse">
    <p class="navbar-text pull-right">
      <a href="login">Have an account? <span>Sign in &raquo;</span></a>
    </p>
  </div><!-- /.navbar-collapse -->
</nav>

<? endif; ?>