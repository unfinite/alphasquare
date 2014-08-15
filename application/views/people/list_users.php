
<div id="people-list">

	<? foreach($users as $user): ?>
	<div class="user">
		<a href="<?=profile_url($user['username'])?>">
			<img src="<?=gravatar_url($user['email'])?>" class="img-circle" />
		</a>
		<a href="<?=profile_url($user['username'])?>">
			<span><?=$user['username']?></span>
		</a>
		<br />
		<small class="total-followers"><?=$user['followers']?> followers</small>
		<br />

		<? if(session_get('userid') != $user['id']): ?>
			<? if($user['is_following']): ?>
				<button class="btn btn-primary btn-sm unfollow" data-id="<?=$user['id']?>" data-username="<?=$user['username']?>">Following</button>
			<? else: ?>
				<button class="btn btn-default btn-sm follow" data-id="<?=$user['id']?>" data-username="<?=$user['username']?>">Follow</button>
			<? endif; ?>
		<? endif; ?>

	</div>
	<? endforeach; ?>

	<div class="clearfix"></div>

</div>