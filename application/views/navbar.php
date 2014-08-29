<? if(session_get('loggedin')): ?>

<!-- Navbar logged in -->
<nav class="navbar navbar-fixed-top logged-in" role="navigation">
  <div class="navbar-header pull-left">
    <a class="navbar-brand" href="<?=base_url('dashboard')?>">alphasquare</a>
  </div>
  <div class="hidden-xs">
    <!-- Icon nav -->
    <ul class="nav navbar-nav top-menu">
      
      <li><a href="<?=base_url('dashboard')?>" title="Dashboard"><span class="glyphicon glyphicon-dashboard"></span></a></li>
     
      <li>
        <a href="<?=base_url('alerts')?>" class="alert-link" title="Alerts">
          <span class="glyphicon glyphicon-bell"></span>
          <span class="label label-danger menu-count alerts alert-unread-count"></span>
        </a>
      </li>

      <li>
        <a href="<?=base_url('messages')?>" title="Messages">
          <span class="glyphicon glyphicon-inbox"></span>
          <span class="label label-danger menu-count messages"></span>
        </a>
      </li>

      <li><a href="<?=base_url('people')?>" title="Discover"><span class="glyphicon glyphicon-user"></span></a></li>

      <!-- Search -->
      <li>
        <form class="navbar-form" action="<?=base_url('search')?>" method="GET">
          <input type="text" name="q" class="form-control" autocomplete="off" placeholder="Search" <? if(isset($query)) echo 'value="'.$query.'"'; ?>/>
        </form>
      </li>

    </ul>
  </div>
  <!-- User nav -->
  <ul class="nav navbar-nav nav-user pull-right">
    <li class="dropdown">
      <a href="<?=profile_url()?>" class="dropdown-toggle" data-toggle="dropdown" title="<?=session_get('username')?>">
        <img src="<?=avatar_url()?>" class="img-circle" />
        <span><?=session_get('username')?></span>
        <span class="caret"></span>
      </a>
      <!-- Begin dropdown -->
      <ul class="dropdown-menu">
        <li><a href="<?=profile_url()?>"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
        <li><a href="<?=profile_url()?>/about"><span class="glyphicon glyphicon-pencil"></span> Edit Info</a></li>
        <li><a href="<?=base_url('settings')?>"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
        <li><a href="<?=base_url('logout')?>"><span class="glyphicon glyphicon-log-out"></span> Sign out</a></li>
      </ul>
      <!-- End dropdown -->
    </li>
  </ul>
</nav>

<!-- Bottom nav bar (mobile only) -->
<nav class="navbar navbar-fixed-bottom bottom-menu visible-xs">
  <ul class="nav navbar-nav">
    <li class="<? if($this->uri->uri_string() == 'dashboard') echo 'active'; ?>">
      <a href="<?=base_url('dashboard')?>">
        <span class="glyphicon glyphicon-dashboard"></span>
        <span class="text">Dashboard</span>
      </a>
    </li>
    <li class="<? if($this->uri->rsegment(1) == 'search') echo 'active'; ?> search-trigger">
      <a href="<?=base_url('search')?>">
        <span class="glyphicon glyphicon-search"></span>
        <span class="text">Search</span>
      </a>
    </li>
    <li class="<? if($this->uri->rsegment(1) == 'alerts') echo 'active'; ?>">
      <a href="<?=base_url('alerts')?>" class="alert-link">
        <span class="glyphicon glyphicon-bell">
          <span class="label label-danger menu-count alerts"></span>
        </span>
        <span class="text">Alerts</span>
      </a>
    </li>
    <li class="<? if($this->uri->rsegment(1) == 'messages') echo 'active'; ?>">
      <a href="<?=base_url('messages')?>">
        <span class="glyphicon glyphicon-inbox">
          <span class="label label-danger menu-count messages"></span>
        </span>
        <span class="text">Messages</span>
      </a>
    </li>
    <li class="<? if($this->uri->uri_string() == 'dashboard/mobile_more') echo 'active'; ?>">
      <a href="<?=base_url('dashboard/more')?>">
        <span class="glyphicon glyphicon-align-justify"></span>
        <span class="text">More</span>
      </a>
    </li>
  </ul>
</nav>

<!-- Mobile search bar -->
<div id="mobile-search" class="hide fade">
  <form action="<?=base_url('search')?>" method="get">
    <input type="text" name="q" placeholder="Search" class="form-control" />
  </form>
</div>
<div id="mobile-search-overlay" class="hide fade"></div>

<? else: ?>

<!-- Navbar logged out -->
<nav class="navbar navbar-fixed-top logged-out" role="navigation">
  <a class="navbar-brand" href="<?=base_url()?>" >alphasquare</a>
  <div class="navbar-text pull-right">
    <a href="<?=base_url('login')?>">Have an account? <span>Sign in &raquo;</span></a>
  </div>
</nav>

<? endif; ?>