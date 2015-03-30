<?php if(session_get('loggedin')): ?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title slab">Following</h3>
  </div>
  <div class="panel-body" id="my-following-list">
    <?php $following = $this->people_model->get_follows('following', null, 12); ?>

    <?php foreach($following as $user): ?>
      <a href="<?=profile_url($user['username'])?>">
        <img src="<?=avatar_url($user['avatar'], $user['email'], 50)?>" class="img-circle" style="width:50px;height:50px;" title="<?=$user['username']?>" data-toggle="tooltip" />
      </a>
    <?php endforeach;?>

    <?php if(count($following) > 0): ?>
    <br>
    <a href="<?=profile_url()?>/following" class="btn btn-xs btn-success">View all &raquo;</a>
    <?php else: ?>
    <p class="no-margin">You aren't following anyone yet.</p>
    <?php endif; ?>

  </div>
</div> <!-- /.panel -->

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title slab">Followers</h3>
  </div>
  <div class="panel-body" id="my-follower-list">
    <?php $followers = $this->people_model->get_follows('followers', null, 10); ?>

    <?php foreach($followers as $user): ?>
      <a href="<?=profile_url($user['username'])?>">
        <img src="<?=gravatar_url($user['email'], 50)?>" class="img-circle" title="<?=$user['username']?>" style="width:50px;height:50px;" data-toggle="tooltip" />
      </a>
    <?php endforeach;?>

    <?php if(count($followers) > 0): ?>
    <br>
    <a href="<?=profile_url()?>/followers" class="btn btn-xs btn-success">View all &raquo;</a>
    <?php else: ?>
    <p class="no-margin">No one is following you yet.</p>
    <?php endif; ?>

  </div>
</div> <!-- /.panel -->

<?php endif; ?>