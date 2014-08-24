<? if(session_get('loggedin')): ?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title slab">Following</h3>
  </div>
  <div class="panel-body" id="my-following-list">
    <? $following = $this->people_model->get_follows('following', null, 10); ?>

    <? foreach($following as $user): ?>
      <a href="<?=profile_url($user['username'])?>">
        <img src="<?=avatar_url($user['avatar'], $user['email'], 50)?>" class="img-circle" title="<?=$user['username']?>" data-toggle="tooltip" />
      </a>
    <? endforeach;?>

    <? if(count($following) > 0): ?>
    <a href="<?=profile_url()?>/following">View all &raquo;</a>
    <? else: ?>
    <p class="no-margin">You aren't following anyone yet.</p>
    <? endif; ?>

  </div>
</div> <!-- /.panel -->

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title slab">Followers</h3>
  </div>
  <div class="panel-body" id="my-follower-list">
    <? $followers = $this->people_model->get_follows('followers', null, 10); ?>

    <? foreach($followers as $user): ?>
      <a href="<?=profile_url($user['username'])?>">
        <img src="<?=gravatar_url($user['email'], 50)?>" class="img-circle" title="<?=$user['username']?>" data-toggle="tooltip" />
      </a>
    <? endforeach;?>

    <? if(count($followers) > 0): ?>
    <a href="<?=profile_url()?>/followers">View all &raquo;</a>
    <? else: ?>
    <p class="no-margin">No one is following you yet.</p>
    <? endif; ?>

  </div>
</div> <!-- /.panel -->

<? endif; ?>