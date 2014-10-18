<? if(session_get('loggedin')): ?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><span class="glyphicon glyphicon-flash"></span> Broadcast</h3>
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
    <h3 class="panel-title slab"><span class="glyphicon glyphicon-music"></span> Radio</h3>
  </div>
  <div class="panel-body">
   Wanna hear some really awesome beats?
   Tune in to our PlayParty channel! 
   <a href="http://socialmelder.com/playparty/channel/alphasquare" class="text-bold" target="_blank">Alphasquare on PlayParty &raquo;</a> 
  </div>
</div> <!-- /.panel -->

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><span class="glyphicon glyphicon-upload"></span> Popular Topics</h3>
  </div>
  <div class="panel-body">
    <p><em>This is coming soon!</em></p>
  </div>
</div> <!-- /.panel -->
