<? foreach($comments as $comment): ?>

<article class="comment" data-id="<?=$comment['id']?>">
  <a href="<?=profile_url($comment['username'])?>" title="<?=$comment['username']?>">
    <img src="<?=gravatar_url($comment['email'])?>" class="profile img-circle" />
  </a>
  <p class="readmore"><?=format_post($comment['content'])?></p>
  <footer>
    <a href="#" class="reply" data-username="<?=$comment['username']?>">Reply</a>
    <abbr class="pull-right timeago" title="<?=date('c', $comment['time'])?>"><?=date('F j, Y g:i A', $comment['time'])?></abbr>
  </footer>
</article>

<? endforeach; ?>