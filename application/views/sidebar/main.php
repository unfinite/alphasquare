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
    <h3 class="panel-title slab"><span class="glyphicon glyphicon-globe"></span> Advertisement</h3>
  </div>
  <div class="panel-body">
   <!--begin The Banner Exchange code --><iframe src="http://www.thebannerexchange.com/display/21538/3//" frameborder="0" vspace="0" hspace="0" width="300" height="250" marginwidth="0" marginheight="0" scrolling="no"></iframe><!-- end The Banner Exchange code -->
   <br>
   <i><a href="dashboard">debate this ad</a></i>
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
