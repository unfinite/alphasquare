<p>You can sign in to your Alphasquare account with any social account that you are connected to. </p>
<br />
<div id="oauth-accounts">
  <div id="facebook">
    <span class="fa fa-facebook"></span>
    <span class="provider">Facebook</span>
    <span class="actions">
      
      <? if(in_array('Facebook', $connected)): ?>
      <span class="fa fa-check text-success"></span>
      <a href="<?=base_url('oauth/disconnect/Facebook')?>" class="btn btn-default">Disconnect</a>
      <? else: ?>
      <a href="<?=base_url('login/oauth/Facebook')?>" class="btn btn-social btn-facebook">
        Connect
      </a>
      <? endif; ?>

    </span>
    <div class="clearfix"></div>
  </div>

  <div id="google">
    <span class="fa fa-google-plus"></span>
    <span class="provider">Google+</span>
    <span class="actions">
      
      <? if(in_array('Google', $connected)): ?>
      <span class="fa fa-check text-success"></span>
      <a href="<?=base_url('oauth/disconnect/Google')?>" class="btn btn-default">Disconnect</a>
      <? else: ?>
      <a href="<?=base_url('login/oauth/Google')?>" class="btn btn-social btn-google-plus">
        Connect
      </a>
      <? endif; ?>

    </span>
    <div class="clearfix"></div>
  </div>
</div>