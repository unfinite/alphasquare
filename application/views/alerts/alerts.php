<section class="alerts">
    <p id="alerts-controls" class="text-right <? if(count($alerts) == 0) echo 'hidden'; ?>">
        <span class="glyphicon glyphicon-ok mark-all-read" data-toggle="tooltip" data-placement="left" data-animation="false"></span><span class="control-text mark-all-read">Mark All As Read</span>
        <span class="glyphicon glyphicon-trash delete-all" data-toggle="tooltip" data-placement="left" data-animation="false"></span><span class="control-text delete-all">Delete All</span>
    </p>

  <p id="no-alerts" class="text-center text-muted <? if(count($alerts) > 0) echo 'hidden'; ?>">
    <span class="glyphicon glyphicon-bell" style="font-size:60px;"></span>
    <br /><br />
    You don't have any alerts right now.
  </p>

  <? foreach($alerts as $alert): ?>
  <article data-id="<?=$alert['id']?>" class="alert-container <?= $alert['clicked'] ? 'clicked' : 'not-clicked'?>">
    <div class="alert-options">
      <? if(!$alert['clicked']): ?>
      <span class="glyphicon glyphicon-ok mark-read" title="Mark as read" data-toggle="tooltip" data-placement="left" data-animation="false"></span>
      <? endif; ?>
      <span class="glyphicon glyphicon-trash delete" title="Delete" data-toggle="tooltip" data-placement="left" data-animation="false"></span>
    </div>
    <a href="<?=profile_url($alert['username'])?>">
      <img src="<?=avatar_url($alert['avatar'], $alert['email'], 50)?>" class="img-circle" />
    </a>
    <div class="alert-content">
      <p>

        <? if($alert['show_user_link']): ?>
        <a href="<?=profile_url($alert['username'])?>"><?=$alert['username']?></a>
        <? endif; ?>

        <span class="text"><?=$alert['text']?></span>

        <? if($alert['url']): ?>
        <a href="<?=$alert['url']?>"><?=$alert['object']?></a>.
        <? endif; ?>
        
      </p>
      <footer>
        <span class="timeago" title="<?=$alert['time_iso']?>"><?=$alert['time_formatted']?></span>
      </footer>
    </div>
    <div class="clearfix"></div>

  </article>
  <? endforeach; ?>

</section>
