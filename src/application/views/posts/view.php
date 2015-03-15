<!-- Post View Page -->

<div class="row" id="post-page" data-id="<?=$info['id']?>">
  <div class="col-lg-8 col-md-8">
    <?=$post_html?>

    <div id="comments">

      <? if($info['comments_count'] > COMMENT_DISPLAY_LIMIT): ?>
      <a href="#" id="load-all-comments">
        View all <span><?=$info['comments_count']?></span> comments...
        <img src="<?=base_url('assets/img/spinner.gif')?>" />
      </a>
      <? endif; ?>

      <div id="comments-container">
        <?= $comments ?>
      </div>

      <form action="javascript:;" id="post-comment">
        <textarea class="form-control autosize" name="comment" placeholder="Write a comment..." rows="1"></textarea>
      </form>

    </div>

  </div>

  <div class="col-lg-4 col-md-4" id="sidebar">
    <?php $this->load->view('sidebar/main') ?>
    <?php $this->load->view('sidebar/follows') ?>
  </div>

</div>

<script src="<?=base_url('assets/js/dashboard.js')?>"></script>
<script> Dashboard.comment.poll.begin(); </script>