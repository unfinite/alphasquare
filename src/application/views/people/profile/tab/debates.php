	<div id="posts" data-type="profile">
    <?=$posts?>
    <?php if($posts_count < 1): ?>
    <div class="panel panel-default">
    	<p class="text-center no-margin" style="font-size:18px;"><?=$username?> hasn't posted any debates yet.</p>
    </div>
    <?php endif;?>
	</div>
  <?php $this->load->view('posts/loading') ?>