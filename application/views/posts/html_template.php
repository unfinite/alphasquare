<article class="post" data-id="<?=$id?>">
	<a href="<?=profile_url($username)?>">
		<img class="img-circle profile-picture" src="<?=$avatar?>">
	</a>
	<section>
		<p class="post-text">
			<?=$content?>
		</p>
		<footer>

			<button class="btn btn-success btn-xs rate" data-type="up">
				<span class="glyphicon glyphicon-thumbs-up "></span> <?=$up_votes?>
			</button>
			<button class="btn btn-success btn-xs rate" data-type="down">
				<span class="glyphicon glyphicon-thumbs-down"></span> <?=$down_votes?>
			</button>

			<? if(!isset($debate_page)): ?>
			<a href="debate/<?=$id?>" class="btn btn-xs btn-info">
				<span class="glyphicon glyphicon-comment"></span> Discussion
			</a>
			<? endif; ?>

			<abbr title="<?=date('c', $time)?>" class="timeago"><?=date('F j, Y g:i A', $time)?></abbr>

		</footer>
	</section>
	<div class="clearfix"></div>
</article>