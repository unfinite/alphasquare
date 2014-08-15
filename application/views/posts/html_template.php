
<? foreach($posts as $post): ?>
<article class="post" data-id="<?=$post['id']?>">
  <a href="<?=profile_url($post['username'])?>">
    <img class="img-circle profile-picture" data-toggle="tooltip" data-placement="right" src="<?=gravatar_url($post['email'], 55)?>" title="<?=$post['username']?>">
  </a>
  <section>
    <p class="post-text">
      <?=format_post($post['content'])?>
    </p>
    <footer>

      <button class="btn btn-xs <?=$post['vote'] == 1 ? 'btn-primary' : 'btn-success'?> vote" data-type="up" title="Vote Up">
        <span class="glyphicon glyphicon-thumbs-up"></span>
        <span class="count"><?=$post['up_votes']?></span>
      </button>
      <button class="btn btn-xs <?=$post['vote'] == -1 ? 'btn-danger' : 'btn-success'?> vote" data-type="down" title="Vote Down">
        <span class="glyphicon glyphicon-thumbs-down"></span>
        <span class="count"><?=$post['down_votes']?></span>
      </button>

      <? if(!isset($post['debate_page'])): ?>
      &nbsp;
      <a href="<?=base_url('debate/'.strtolower($post['username']).'/'.$post['time'])?>" class="btn btn-xs btn-info">
        <span class="glyphicon glyphicon-comment"></span>
        <span class="hidden-xs">Discussion</span>
        <? if($post['comments_count'] > 0): ?>
        <strong><?=$post['comments_count']?></strong>
        <? endif; ?>
      </a>
      <? endif; ?>

      <abbr title="<?=date('c', $post['time'])?>" class="timeago"><?=date('F j, Y g:i A', $post['time'])?></abbr>

    </footer>
  </section>
  <div class="clearfix"></div>
</article>
<? endforeach; ?>