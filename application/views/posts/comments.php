<? foreach($comments as $comment): ?>

<article class="comment" data-id="<?=$comment['id']?>">
  <a href="<?=profile_url($comment['username'])?>" title="<?=$comment['username']?>">
    <img src="<?=gravatar_url($comment['email'])?>" class="profile img-circle" />
  </a>
  <p><?=format_post($comment['content'])?></p>
  <footer>
    <abbr title="<?=date('c', $comment['time'])?>" class="timeago"><?=date('F j, Y g:i A', $comment['time'])?></abbr>
  </footer>
</article>

<? endforeach; ?>