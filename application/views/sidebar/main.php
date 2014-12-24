<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><span class="glyphicon glyphicon-flash"></span> Merry Christmas!</h3>
  </div>
  <div class="panel-body">
    <p>Happy holidays from the Alphasquare.us team! Here's a little present for you all!</p>
    <br> <a href="http://alphasquare.us/labs/tree.txt" class="btn btn-lg btn-block btn-success">Check it out!</a>
  </div>
</div> <!-- /.panel -->


<? if(!session_get('loggedin')): ?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><span class="glyphicon glyphicon-flash"></span> Hello, welcome to Alphasquare!</h3>
  </div>
  <div class="panel-body">
    <p>Oh noes! Seems like you aren't <b>signed in</b>. To post debates, discuss, and lead the <b>evolution</b> of the web, <b>sign in</b> or <b>register</b>. </p>
    <br> <a href="http://alphasquare.us/register" class="btn btn-lg btn-block btn-success">Register &raquo;</a>
    <center><div class="hr" style="width:15%;">
  		<span>or</span>
	</div> 
    <a href="http://alphasquare.us/login" class="btn btn-lg btn-block btn-default">Sign in &raquo;</a>
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
