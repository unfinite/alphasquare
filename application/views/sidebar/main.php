
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
          &nbsp;<span class="label label-danger alert-unread-count"></span>
        </a>
      </li>
      <li class="<?=isset($people)?'active':''?>">
        <a href="<?=base_url('people')?>">
          <span class="glyphicon glyphicon-cloud"></span> People
        </a>
      </li>
      <? if(session_get('loggedin')): ?>
      <li>
        <a href="<?=profile_url()?>">
          <span class="glyphicon glyphicon-user"></span> Me
        </a>
      </li>
      <? endif; ?>
    </ul>
  </div>
</div> <!-- /.panel -->