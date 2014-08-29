<? if(session_get('loggedin')): ?>
<div class="panel panel-default" id="sidebar-menu">
  <div class="panel-body">
    <ul class="nav nav-pills nav-stacked slab">
      <li class="<?=isset($dashboard)?'active':''?>">
        <a href="<?=base_url('dashboard')?>">
          <span class="glyphicon glyphicon-globe"></span> Dashboard
        </a>
      </li>
      <li>
        <a href="#" id="alert-link">
          <span class="glyphicon glyphicon-bell"></span> Alerts
           <span class="label label-danger alert-unread-count"></span>
        </a>
      </li>
      <li class="<?=isset($people)?'active':''?>">
        <a href="<?=base_url('people')?>">
          <span class="glyphicon glyphicon-cloud"></span> Discover
        </a>
      </li>
      <? if(session_get('employee') == 1): ?>
      <li>
        <a href="<?=profile_url()?>">
          <span class="glyphicon glyphicon-flash"></span> Employee Central
        </a>
      </li>
    <? endif; ?>
    </ul>
  </div>
</div> <!-- /.panel -->
<? endif; ?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title slab"><span class="glyphicon glyphicon-music"></span> Radio</h3>
  </div>
  <div class="panel-body">
   Wanna hear some really awesome beats? Tune in to the Alphasquare PlayParty! <a class="btn btn-xs btn-success" href="http://socialmelder.com/playparty/channel/alphasquare">Go &raquo;</a>
  </div>
</div> <!-- /.panel -->

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title slab"><span class="glyphicon glyphicon-search"></span> Search</h3>
  </div>
  <div class="panel-body">
    <form action="<?=base_url('search')?>" method="get">
      <input type="text" name="q" class="form-control input-md" placeholder="Search Alphasquare..." />
    </form>
  </div>
</div> <!-- /.panel -->

<? if(session_get('loggedin')): ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title slab"><span class="glyphicon glyphicon-flash"></span> Broadcast</h3>
  </div>
  <div class="panel-body">
    <p>Updates:</p>
    <ul>
      <? /* Edit broadcast in config/constants.php */ ?>
      <? global $broadcast; ?>
      <? foreach($broadcast as $text): ?>
      <li><?=$text?></li>
      <? endforeach; ?>
    </ul>
  </div>
</div> <!-- /.panel -->
<? endif; ?>



