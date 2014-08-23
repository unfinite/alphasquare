<div class="page-header">
  <h1><?=$provider?> Account</h1>
</div>

<p>There is already an Alphasquare account using the email address <b><?=$email?></b> (from your <?=$provider?> account).</p>

<p>What would you like to do?</p>

<br />
<a href="connect_account" class="btn btn-success">
Connect <?=$provider?> with the account
</a>
<p style="max-width:500px;margin-top:10px">
This option will allow you to sign in to your existing Alphasquare account 
with your Alphasquare credentials and your <?=$provider?> account.
</p>

<br />
<a href="new_account?clear=1" class="btn btn-default">Create a new account</a>
&nbsp;
<a href="cancel" class="btn btn-default">Go back to sign in page</a>