<nav class="navbar navbar-logged navbar-fixed-top" role="navigation" style="border-top:2px solid #3498db;">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand lobster" href="/" >alphasquare&nbsp;&nbsp;&nbsp;</a>
  </div>


  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
       <li><a href="dashboard.php" class="action-bar"><span class="glyphicon glyphicon-globe animated bounceIn"></span></a></li>
      <li><a class="action-bar" ><span class="glyphicon glyphicon-user animated bounceIn"></span></a></li>
      <li><a href="find.php" class="action-bar"><span class="glyphicon glyphicon-search  animated bounceIn"></span></a></li>

      <li><a href="settings.php" class="action-bar"><span class="glyphicon glyphicon-cog  animated bounceIn"></span></a></li>
    </ul>
      <ul class="nav navbar-nav navbar-right">
 
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="margin-right:100px;padding-top:19px;">Howdy, <?php getUsername(); ?>! <b class="caret"></b></a>
          <ul class="dropdown-menu" style="margin-right:100px;">
                                <li><a href="/s">Code Storage</a></li>
                      
            <li><a href="login.php">Logout</a></li>

          </ul>
  </div><!-- /.navbar-collapse -->
</nav>