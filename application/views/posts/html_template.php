
<? foreach($posts as $post): ?>
<article class="post" data-id="<?=$post['id']?>">
  <a href="<?=profile_url($post['username'])?>">
    <img src="<?=avatar_url($post['avatar'], $post['email'], 55)?>" title="<?=$post['username']?>" class="img-circle profile-picture" data-toggle="tooltip" data-placement="right" />
  </a>
  <section>
    <div class="actions">
      <a href="#" data-toggle="dropdown" class="post-actions">
        <span class="glyphicon glyphicon-cog"></span>
        <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu" aria-labelledby="postActions">

       <? if($post['userid'] == session_get('userid')): ?>
        <li>
          <a href="#" class="promote-post">
            <span class="glyphicon glyphicon-share-alt"></span>
            Promote
          </a>
        </li>

        <li>
          <a href="#" class="delete-post">
            <span class="glyphicon glyphicon-trash"></span>
            Delete
          </a>
        </li>
        <? else: ?>

        <li>
          <a href="#" class="report-post">
            <span class="glyphicon glyphicon-flag"></span>
            Report
          </a>
        </li>

        <? endif; ?>

        <? if(session_get('employee') == 1): ?>

          <a href="/employee/delete_post/<?=$post['id']?>" class="delete-post">
            <span class="glyphicon glyphicon-trash"></span>
            Delete (staff action)
          </a>
        </li>

        <? endif; ?>

      </ul>
    </div>


    <p class="post-text">
      <?=format_post($post['content'])?>
    </p>
    <footer>

      <button class="btn btn-xs <?=$post['vote'] == 1 ? 'btn-primary' : 'btn-success'?> vote" data-type="up" title="Like">
        <span class="glyphicon glyphicon-thumbs-up"></span>
        <span class="count"><?=$post['up_votes']?></span>
      </button>
      <button class="btn btn-xs <?=$post['vote'] == -1 ? 'btn-danger' : 'btn-success'?> vote" data-type="down" title="Dislike">
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