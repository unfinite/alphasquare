<div class="row" id="about">

	<div class="col-lg-6">

		<div class="panel panel-default">

			<h3>Basic Information</h3>

			<?php if($is_owner): ?>
			<button class="btn btn-sm btn-default edit" data-edit="basic">
				<span class="glyphicon glyphicon-pencil"></span>
				Edit
			</button>
			<?php endif; ?>

			<?php if($name): ?>
			<div class="block">
				<strong>Name</strong>
				<span><?=htmlspecialchars($name)?></span>
			</div>
			<?php endif; ?>

			<div class="block">
				<strong>Username</strong>
				<span><?=$username?></span>
			</div>

			<div class="block">
				<strong>Joined</strong>
				<span><?=date('F jS, Y', $joined)?></span>
			</div>

		</div>

		<div class="panel panel-default">
			<h3>About</h3>

			<?php if($is_owner): ?>
			<button class="btn btn-sm btn-default edit" data-edit="about">
				<span class="glyphicon glyphicon-pencil"></span>
				Edit
			</button>
			<?php endif; ?>

			<div class="block">
				<strong>Tagline</strong>
				<?php if($tagline): ?>
				<span><?=htmlspecialchars($tagline)?></span>
				<?php else: ?>
				<span class="text-muted">No tagline.</span>
				<?php endif; ?>
			</div>

			<div class="block">
				<strong>Bio</strong>
				<?php if($bio): ?>
				<span class="readmore"><?=nl2br(htmlspecialchars($bio))?></span>
				<?php else: ?>
				<span class="text-muted">No bio.</span>
				<?php endif; ?>
			</div>

			<?php if($birthday): ?>
			<div class="block">
				<strong>Birthday</strong>
				<span><?=$birthday_formatted?> - <?=$age?> years old</span>
			</div>
			<?php endif; ?>

			<div class="block">
				<strong>Location</strong>
				<span><?=htmlspecialchars($location)?></span>
			</div>

		</div>

	</div>

	<div class="col-lg-6">

		<div class="panel panel-default">
			<h3>Links</h3>

			<?php if($is_owner): ?>
			<button class="btn btn-sm btn-default edit" data-edit="links">
				<span class="glyphicon glyphicon-pencil"></span>
				Edit
			</button>
			<?php endif; ?>

			<div class="block">
				<strong>Website</strong>
				<?php if($website_url): ?>
				<span>
					<a href="<?=$website_url?>" target="_blank"><?= $website_title ? htmlspecialchars($website_title) : $website_url ?></a>
				</span>
				<?php else: ?>
				<span class="text-muted">N/A</span>
				<?php endif; ?>
			</div>

			<div class="block">

				<strong>Other Links</strong>

				<?php if(count($links) < 1): ?>
				<span class="text-muted">No links.</span>
				<?php endif; ?>

				<?php foreach($links as $row): ?>
				<span><a href="<?=$row['url']?>" target="_blank"><?=htmlspecialchars($row['text'])?></a></span>
				<?php endforeach; ?>

			</div>

		</div>

		<div class="panel panel-default">
			<h3>Favorites</h3>

			<?php if($is_owner): ?>
			<button class="btn btn-sm btn-default edit" data-edit="favorites">
				<span class="glyphicon glyphicon-pencil"></span>
				Edit
			</button>
			<?php endif; ?>

			<div class="block">
				<strong>Movies</strong>
				<?php if($favorite_movies): ?>
				<span class="readmore"><?=htmlspecialchars($favorite_movies)?></span>
				<?php else: ?>
				<span class="text-muted">N/A</span>
				<?php endif; ?>
			</div>

			<div class="block">
				<strong>TV Shows</strong>
				<?php if($favorite_tv): ?>
				<span class="readmore"><?=htmlspecialchars($favorite_tv)?></span>
				<?php else: ?>
				<span class="text-muted">N/A</span>
				<?php endif; ?>
			</div>

			<div class="block">
				<strong>Music</strong>
				<?php if($favorite_music): ?>
				<span class="readmore"><?=htmlspecialchars($favorite_music)?></span>
				<?php else: ?>
				<span class="text-muted">N/A</span>
				<?php endif; ?>
			</div>

			<div class="block">
				<strong>Quotes</strong>
				<?php if($favorite_quotes): ?>
				<span class="readmore"><?=nl2br(htmlspecialchars($favorite_quotes))?></span>
				<?php else: ?>
				<span class="text-muted">N/A</span>
				<?php endif; ?>
			</div>

		</div>

	</div>

</div>