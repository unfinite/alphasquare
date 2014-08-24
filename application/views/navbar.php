<? if(session_get('loggedin')): ?>

<!-- Navbar logged in -->
<nav class="navbar navbar-fixed-top logged-in" role="navigation">
  <div class="navbar-header">
    <a class="navbar-brand popover-trigger" href="<?=base_url('dashboard')?>">alphasquare</a>
  </div>
</nav>

<!-- Slingshot box -->
<div id="slingshot-container">
  <a href="<?=profile_url()?>" class="user">
    <img class="img-circle profile" src="<?=avatar_url(null,null,100)?>" />
    <h3><?=session_get('username')?></h3>
  </a>
  <div class="slingshot-actions">
    <a href="<?=base_url('dashboard')?>" title="Dashboard">
      <span class="glyphicon glyphicon-globe"></span>
    </a>
    <a href="<?=profile_url()?>">
      <span class="glyphicon glyphicon-user" title="My Profile"></span>
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

<!-- Navbar logged out -->
<nav class="navbar navbar-fixed-top logged-out" role="navigation">
  <a class="navbar-brand" href="<?=base_url()?>" >alphasquare</a>
  <div class="navbar-text pull-right">
    <a href="<?=base_url('login')?>">Have an account? <span>Sign in &raquo;</span></a>
  </div>
</nav>

<? endif; ?>