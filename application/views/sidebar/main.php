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


<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title slab"><span class="glyphicon glyphicon-stats"></span>&nbsp; Popular Topics</h3>
  </div>
  <div class="panel-body">
    <p><em>This is coming soon!</em></p>
  </div>
</div> <!-- /.panel -->