<h4>Connected accounts</h4>
<p>Simplify the sign in process by connecting social accounts to your Alphasquare account.</p>
<div id="oauth-accounts">

  <?php foreach($providers as $provider): ?>
  <div id="<?=$provider['name']?>" class="provider">
    <div class="provider-info">
      <span class="fa fa-<?=$provider['class']?>"></span>
      <span class="provider-name"><?=$provider['name']?></span>
    </div>
    <div class="actions">
      
      <?php if(in_array($provider['name'], $connected)): ?>
      <span class="fa fa-check text-success" title="Connected!"></span>
      <a href="<?=base_url('oauth/disconnect/'.$provider['name'])?>" class="btn btn-default">Disconnect</a>
      <?php else: ?>
      <a href="<?=base_url('login/oauth/'.$provider['name'])?>" class="btn btn-social btn-<?=$provider['class']?>">
        Connect
      </a>
      <?php endif; ?>

    </div>
    <div class="clearfix"></div>
  </div>
  <?php endforeach; ?>

</div>