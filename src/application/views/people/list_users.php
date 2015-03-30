
<div id="people-list">

	<?php foreach($users as $user): ?>
	<div class="user">
		<a href="<?=profile_url($user['username'])?>">
			<img src="<?=avatar_url($user['avatar'], $user['email'])?>" class="img-circle" />
		</a>
		<a href="<?=profile_url($user['username'])?>">
			<span class="name"><?=$user['username']?></span>
		</a>
		<br />
		<small class="total-followers">
			<span class="count followers" data-id="<?=$user['id']?>"><?=$user['followers']?></span>
			followers
			</small>
		<br />

		<?php if(session_get('userid') != $user['id']): ?>
			<?php if($user['is_following']): ?>
				<button class="btn btn-primary btn-sm unfollow" data-id="<?=$user['id']?>" data-username="<?=$user['username']?>">Following</button>
			<?php else: ?>
				<button class="btn btn-default btn-sm follow" data-id="<?=$user['id']?>" data-username="<?=$user['username']?>">Follow</button>
			<?php endif; ?>
		<?php endif; ?>

	</div>
	<?php endforeach; ?>

	<div class="clearfix"></div>

</div>