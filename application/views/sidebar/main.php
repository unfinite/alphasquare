<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><span class="glyphicon glyphicon-flash"></span> Merry Christmas!</h3>
  </div>
  <div class="panel-body">
    <p>Happy holidays from the Alphasquare.us team! Here's a little present for you all!</p>
    <br> <a onclick="showSource()" class="btn btn-lg btn-block btn-success">Check it out!</a>
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
    <h3 class="panel-title"><span class="glyphicon glyphicon-upload"></span> Donate</h3>
  </div>
  <div class="panel-body">
    <p><center>We are really running on a low budget recently. We need money to mantain Alphasquare. If you'd like to donate to help pay for better servers, please donate below. Then, contact Sergio to get a limited edition donator's badge. Thanks for your support! <br><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<table>
<tr><td><input type="hidden" name="on0" value="Packages">Packages</td></tr><tr><td><select name="os0">
	<option value="Package 1">Package 1 $1.00 USD</option>
	<option value="Package 2">Package 2 $2.00 USD</option>
	<option value="Package 3">Package 3 $5.00 USD</option>
	<option value="Package 4">Package 4 $10.00 USD</option>
	<option value="Package 5">Package 5 $20.00 USD</option>
	<option value="Package 6">Package 6 $50.00 USD</option>
	<option value="Package 7">Package 7 $100.00 USD</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></center></p>
  </div>
</div> <!-- /.panel -->


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
