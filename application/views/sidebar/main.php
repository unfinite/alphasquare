
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
