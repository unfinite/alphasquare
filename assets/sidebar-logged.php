
<div class="alert alert-info"> <b>We have a new bug tracker!</b> We encourage you all to post any bugs or proposals in it. <a href="https://snowy-evening.com/alphasquare/alphasquare/">Click here to check it out!</a></div>
<br>
  <div class="panel panel-default" style="width:100%">
  <div class="panel-body">
    <ul class="nav nav-pills nav-stacked slab">

  <li>
    <a href="#">
      
      Dashboard
    </a>
    
  </li>
  <li>
   <a onclick="markread()"   data-toggle="modal"
   data-target="#alerts" href="#">
 <span class="badge badge-danger pull-right" id="alerts2"></span>
      Alerts
    </a>
    </li>
  <li>
  <a href="#">
      People
    </a>
    </li>
    <li>
    <a href="#">
      Me
    </a>
    </li>
</ul>

  </div>
</div>
<br>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title slab">People</h3>
  </div>
  <div class="panel-body">
    <?php

$users = show_users($_SESSION['userid']);

if (count($users)){
?>

<?php
foreach ($users as $key => $value){
?> <img src="<?php profilePicture($value) ?>" class="img-circle" style="width:40px;height:40px;">
<?php
}
?>
<?php
}else{
?>
<b>You're not following anyone yet. </b>
<?php
}
?>
  </div>
</div>
<br>
<!-- TOOLKIT START -->
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title slab">Development Toolkit</h3>
  </div>
  <div class="panel-body">
<a href="https://snowy-evening.com/alphasquare/alphasquare/" class="btn btn-lg btn-info btn-block">Report a bug</a>
<br>
  <button onclick="manual()" class="btn btn-lg btn-info btn-block">Manual AJAX request (override)</button>
  <br>  <button onclick="notify()" class="btn btn-lg btn-info btn-block">Trigger test notification</button>
<br>
    <button onclick="document.location.reload(true)" class="btn btn-lg btn-info btn-block">Refresh site (update HTML and JS)</button>

  </div>
</div>
<!-- TOOLKIT END -->
</div>
</div>