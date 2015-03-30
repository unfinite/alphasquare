<?php if(session_get('loggedin')): ?>

<!-- Navbar logged in -->
<nav class="navbar navbar-fixed-top logged-in" role="navigation">
<div class="bs-container">
  <div class="navbar-header pull-left">
    <a class="navbar-brand" href="<?=base_url('dashboard')?>">alphasquare</a>
  </div>
  <div class="hidden-xs">
    <!-- Icon nav -->
    <ul class="nav navbar-nav top-menu">
      <li><a href="<?=base_url('dashboard')?>" title="Dashboard"><span class="glyphicon glyphicon-globe glyph-action"></span></a></li>
      <li>
        <a href="<?=base_url('alerts')?>" class="alert-link" title="Alerts">
          <span class="glyphicon glyphicon-bell glyph-action"></span>
          <span class="label label-danger menu-count alerts alert-unread-count"></span>
        </a>
      </li>
      <li>
        <a href="<?=base_url('about/soon')?>" title="Messages">
          <span class="glyphicon glyphicon-inbox glyph-action"></span>
          <span class="label label-danger menu-count messages"></span>
        </a>
      </li>
      <li><a href="<?=base_url('people')?>" title="Discover"><span class="glyphicon glyphicon-user glyph-action"></span></a></li>
      <!-- Search -->
    </ul>
  </div>

  <!-- User nav -->
  <ul class="nav navbar-nav nav-user pull-right">
    <li>
    <div class="hidden-xs">
        <form class="navbar-form navform" action="<?=base_url('search')?>" method="GET">
          <input type="text" name="q" class="form-control" autocomplete="off" placeholder="Find..." <?php if(isset($query)) echo 'value="'.$query.'"'; ?>/>
        </form>
        </div>
    </li>
    <li class="dropdown">
      <a href="<?=profile_url()?>" class="dropdown-toggle" data-toggle="dropdown" title="<?=session_get('username')?>">
        <img src="<?=avatar_url()?>" class="img-circle" />
        <span class="caret"></span>
      </a>
      <!-- Begin dropdown -->
      <ul class="dropdown-menu">
        <?php if(session_get('employee') == 1): ?>
        <li><a href="<?=base_url('employee')?>"><span class="glyphicon glyphicon-flash"></span> Employee Central</a></li>
        <li class="divider"></li>
        <?php endif; ?>
        <li><a href="<?=profile_url()?>"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
        <li><a href="<?=profile_url()?>/about"><span class="glyphicon glyphicon-pencil"></span> Edit Info</a></li>
        <li><a href="<?=base_url('settings')?>"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
        <li><a href="<?=base_url('logout')?>"><span class="glyphicon glyphicon-log-out"></span> Sign out</a></li>
      </ul>
      <!-- End dropdown -->
    </li>
  </ul>
  </div>

</nav>
  <div class="bs-container">

<?php else: ?>

<!-- Navbar logged out -->
    <nav class="navbar navbar-fixed-top logged-out" role="navigation">
      <div class="bs-container">
      <a class="navbar-brand" href="/">alphasquare</a>
      <div class="navbar-text pull-right">
        <a href="<?=base_url('login')?>"><strong>Already a user? </strong><span>Sign in &raquo;</span></a>
      </div>
    </div>
    </nav>

<?php endif; ?>


<?php 
/* If not on homepage, show the mobile bar */
if($this->uri->rsegment(1) !== 'main'): 
?>

<!-- Bottom nav bar (mobile only) -->
<nav class="navbar navbar-fixed-bottom bottom-menu visible-xs">
  <ul class="nav navbar-nav">
    
    <?php if(session_get('loggedin')): ?>
    <li class="<?php if($this->uri->uri_string() == 'dashboard') echo 'active'; ?>">
      <a href="<?=base_url('dashboard')?>">
        <span class="glyphicon glyphicon-globe"></span>
        <span class="text">Dashboard</span>
      </a>
    </li>
    <?php else: ?>
    <li>
      <a href="<?=base_url()?>">
        <span class="glyphicon glyphicon-home"></span>
        <span class="text">Home</span>
      </a>
    </li>
    <?php endif; ?>

    <li class="<?php if($this->uri->rsegment(1) == 'search') echo 'active'; ?> search-trigger">
      <a href="<?=base_url('search')?>">
        <span class="glyphicon glyphicon-search"></span>
        <span class="text">Search</span>
      </a>
    </li>

    <?php if(session_get('loggedin')): ?>
    <li class="<?php if($this->uri->rsegment(1) == 'alerts') echo 'active'; ?>">
      <a href="<?=base_url('alerts')?>" class="alert-link">
        <span class="glyphicon glyphicon-bell">
          <span class="label label-danger menu-count alerts"></span>
        </span>
        <span class="text">Alerts</span>
      </a>
    </li>
    <li class="<?php if($this->uri->rsegment(1) == 'messages') echo 'active'; ?>">
      <a href="<?=base_url('messages')?>">
        <span class="glyphicon glyphicon-inbox">
          <span class="label label-danger menu-count messages"></span>
        </span>
        <span class="text">Messages</span>
      </a>
    </li>

    <?php else: ?>

    <li class="text-bold <?php if($this->uri->segment(1) == 'register') echo 'active'; ?>">
      <a href="<?=base_url('register')?>">
        <span class="glyphicon glyphicon-flash"></span>
        <span class="text">Register</span>
      </a>
    </li>
    <li class="<?php if($this->uri->segment(1) == 'login') echo 'active'; ?>">
      <a href="<?=base_url('login')?>">
        <span class="glyphicon glyphicon-log-in"></span>
        <span class="text">Sign in</span>
      </a>
    </li>
    <?php endif; ?>

    <li class="<?php if($this->uri->uri_string() == 'dashboard/mobile_more') echo 'active'; ?>">
      <a href="<?=base_url('dashboard/mobile_more')?>">
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

<?php endif; ?>
