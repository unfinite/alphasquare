<? if(session_get('loggedin')): ?>

<!-- Navbar logged in -->
<nav class="navbar navbar-fixed-top logged-in" role="navigation">
  <div class="navbar-header">
    <a class="navbar-brand popover-trigger" href="<?=base_url('dashboard')?>">alphasquare</a>
  </div>
  <div>
    <!-- Icon nav -->
    <ul class="nav navbar-nav">
      <li><a href="<?=base_url('dashboard')?>" title="Dashboard"><span class="glyphicon glyphicon-globe"></span></a></li>
      <li><a href="<?=base_url('alerts')?>"><span class="glyphicon glyphicon-bell" title="Alerts"></span></a></li>
      <li><a href="<?=base_url('messages')?>"><span class="glyphicon glyphicon-inbox" title="Messages"></span></a></li>
    </ul>
  </div>
  <!-- User nav -->
  <ul class="nav navbar-nav pull-right">
    <li>
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?=session_get('username')?>">
        <img src="<?=avatar_url()?>" class="img-circle" />
        <span class="hidden-xs"><?=session_get('username')?></span>
        <span class="caret"></span>
      </a>
      <!-- Begin dropdown -->
      <ul class="dropdown-menu">
        <li><a href="<?=profile_url()?>"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
        <li><a href="<?=base_url('settings')?>"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
        <li><a href="<?=base_url('logout')?>"><span class="glyphicon glyphicon-log-out"></span> Sign out</a></li>
      </ul>
      <!-- End dropdown -->
    </li>
  </ul>
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