
<?php foreach($posts as $post): ?>
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

       <?php if($post['userid'] == session_get('userid')): ?>
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
        <?php else: ?>

        <li>
          <a href="#" class="report-post">
            <span class="glyphicon glyphicon-flag"></span>
            Report
          </a>
        </li>

        <?php endif; ?>

        <?php if(session_get('employee') == 1): ?>

        <li>

          <a href="/employee/delete_post/<?=$post['id']?>">
            <span class="glyphicon glyphicon-trash"></span>
            Delete (staff action)
          </a>
        </li>

        <?php endif; ?>

      </ul>
    </div>


    <p class="post-text">
      <?=format_post($post['content'])?>
    </p>
    <footer>

      <button class="btn btn-xs btn-outline <?=$post['vote'] == 1 ? 'btn-primary' : 'btn-success'?> vote" data-type="up" title="Like">
        <span class="glyphicon glyphicon-thumbs-up"></span>
        <span class="count"><?=$post['up_votes']?></span>
      </button>
      <button class="btn btn-xs btn-outline <?=$post['vote'] == -1 ? 'btn-danger' : 'btn-success'?> vote" data-type="down" title="Dislike">
        <span class="glyphicon glyphicon-thumbs-down"></span>
        <span class="count"><?=$post['down_votes']?></span>
      </button>

      <?php if(!isset($post['debate_page'])): ?>
      &nbsp;
      <a href="<?=base_url('debate/'.strtolower($post['username']).'/'.$post['time'])?>" class="btn btn-xs btn-info btn-outline">
        <span class="glyphicon glyphicon-comment"></span>
        <strong><?=$post['comments_count']?></strong>
      </a>
      <?php endif; ?>

      <abbr title="<?=date('c', $post['time'])?>" class="timeago"><?=date('F j, Y g:i A', $post['time'])?></abbr>

    </footer>
  </section>
  <div class="clearfix"></div>
</article>
<?php endforeach; ?>