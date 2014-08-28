<div class="row" id="profile-page" data-id="<?=$id?>">
  <div class="col-lg-8 col-md-8">

  	<div class="page-header">

      <div id="header-top">
        <div id="info">
          <img src="<?=$avatar?>" class="img-circle" />
          <div class="clearfix visible-xs"></div>
          
          <div>
            <h2>

              <?=htmlspecialchars($name)?>

              <? if( $birthday && date('m-d') == date('m-d', strtotime($birthday)) ): ?>
              <span class="label label-info" title="Born on <?=$birthday_formatted?>" data-toggle="tooltip">Happy Birthday!</span>
              <? endif; ?>

              <? if($employee): ?>
              <span class="label label-primary">Staff</span>
              <? endif; ?>

            </h2>

            <? if($name): ?>
            <span class="text-muted" style="font-size:17px;">@<?=username?></span>
            <? endif; ?>

            <p><?=htmlspecialchars($tagline)?></p>

            <span class="glyphicon glyphicon-map-marker"></span>
            <?=htmlspecialchars($location)?>
              

            <? if($website_url): ?>
            <br class="visible-xs" />
            <span class="glyphicon glyphicon-link"></span>
            <a href="<?=$website_url?>" target="_blank"><?= $website_title ? htmlspecialchars($website_title) : $website_url ?></a>
            <? endif; ?>
          </div>

        </div>
        <div id="actions">

          <? if(!$is_owner): ?>

            <? if(!$is_following): ?>
            <button class="btn btn-default follow" data-id="<?=$id?>" data-username="<?=$username?>">
              Follow
            </button>
            <? else: ?>
            <button class="btn btn-primary unfollow" data-id="<?=$id?>" data-username="<?=$username?>">
              Following
            </button>
            <? endif; ?>

          <? elseif($is_owner && $tab !== 'about'): ?>
          <a href="<?=profile_url($username)?>/about" class="btn btn-default btn-sm">
            <span class="glyphicon glyphicon-pencil"></span>
            Edit Profile
          </a>
          <? endif; ?>

        </div>
        <div class="clearfix"></div>

      </div>

      <ul id="profile-menu">

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
          <a class="no-click" title="<?=$username?> has <?=number_format($points)?> points" data-toggle="tooltip">
            <span class="count"><?=short_number($points)?></span><br>
            Points
          </a>
        </li>
        <li<? if($tab=='followers') echo ' class="active"'?>>
          <a href="<?=profile_url($username)?>/followers" title="<?=$username?> has <?=number_format($followers)?> followers" data-toggle="tooltip">
            <span class="count followers" data-id="<?=$id?>"><?=short_number($followers)?></span><br>
            Followers
          </a>
        </li>
        <li<? if($tab=='following') echo ' class="active"'?>>
          <a href="<?=profile_url($username)?>/following" title="<?=$username?> is following <?=number_format($following)?> <?=$following==1 ? 'person': 'people'?>" data-toggle="tooltip">
            <span class="count following"><?=short_number($following)?></span><br>
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
	Profile.init({
    id: '<?=$id?>',
    username: '<?=$username?>',
    baseUrl: '<?=profile_url($username)?>'
  });
});
</script>