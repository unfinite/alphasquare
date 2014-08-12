<div class="row" id="profile-page" data-id="<?=$id?>">
  <div class="col-lg-8 col-md-8">

  	<div class="page-header">

      <div id="info">
        <img src="<?=$avatar?>" class="img-circle" />
        <h2>
          <?=$username?>
          <? if($ranger): ?>
          <span class="label label-primary">Ranger</span>
          <? endif; ?>
        </h2>
        <p><?=$tagline?></p>

        <span class="glyphicon glyphicon-map-marker"></span>
        <?=htmlentities($location)?>

        <? if($website): ?>
        <span class="glyphicon glyphicon-link" style="margin-left:10px;display:inline-block;"></span>
        <a href="<?=$website?>"><?=$website?></a>
        <? endif; ?>

      </div>
      <div id="actions">

        <? if(session_get('loggedin') && session_get('userid') !== $id): ?>
          <? if(!$is_following): ?>
          <button class="btn btn-default follow" data-id="<?=$id?>" data-username="<?=$username?>">
            Follow
          </button>
          <? else: ?>
          <button class="btn btn-primary unfollow" data-id="<?=$id?>" data-username="<?=$username?>">
            Following
          </button>
          <? endif; ?>
        <? else: ?>
        <a href="<?=base_url('settings/profile')?>" class="btn btn-default btn-sm">
          <span class="glyphicon glyphicon-pencil"></span>
          Edit Profile
        </a>
        <? endif; ?>

      </div>
      <div class="clearfix"></div>
      <ul id="stats">

        <li<? if($tab==null) echo ' class="active"'?>>
          <a href="<?=profile_url($username)?>">
            <span class="glyphicon glyphicon-bullhorn"></span><br>
            Debates
          </a>
        </li>
        <li<? if($tab=='comments') echo ' class="active"'?>>
          <a href="<?=profile_url($username)?>/comments">
            <span class="glyphicon glyphicon-comment"></span><br>
            Comments
          </a>
        </li>
        <li class="divider<? if($tab=='about') echo ' active'?>">
          <a href="<?=profile_url($username)?>/about">
            <span class="glyphicon glyphicon-info-sign"></span><br>
            About Me
          </a>
        </li>
        <li<? if($tab=='points') echo ' class="active"'?>>
          <a class="no-click" title="<?=$points?> points">
            <span class="count"><?=format_number($points)?></span><br>
            Points
          </a>
        </li>
        <li<? if($tab=='followers') echo ' class="active"'?>>
          <a href="<?=profile_url($username)?>/followers">
            <span class="count followers"><?=format_number($followers)?></span><br>
            Followers
          </a>
        </li>
        <li<? if($tab=='following') echo ' class="active"'?>>
          <a href="<?=profile_url($username)?>/following">
            <span class="count following"><?=format_number($following)?></span><br>
            Following
          </a>
        </li>

      </ul>
      <div class="clearfix"></div>
    </div>

    <div id="tab-content">
      <?=$tab_content?>
    </div>

  </div>
  <div class="col-lg-4 col-md-4" id="sidebar">
  	<?php $this->load->view('sidebar/main') ?>
  </div>
</div>

<script src="<?=base_url('assets/js/dashboard.js')?>"></script>
<script src="<?=base_url('assets/js/profile.js')?>"></script>
<script>
$(function() {
	Profile.init('<?=$id?>');
});
</script>