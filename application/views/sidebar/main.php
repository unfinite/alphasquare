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
  <center>
   		<script type="text/javascript">
		/* Alphasquare | Large Rectangle | Alphasquare */
		var bamAdspace = '5443fccc5356a';
		var bamWidth = 336;
		var bamHeight = 280;
		</script>
		<script type="text/javascript" src="http://www.bamifyads.com/ads.js"></script>		
   <br>
   <i><a href="dashboard">debate this ad &raquo;</a></i>
   </center>
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
