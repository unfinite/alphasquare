<div class="row" id="about">

	<div class="col-lg-6">

		<div class="panel panel-default">

			<h3>Basic Information</h3>

			<? if($is_owner): ?>
			<button class="btn btn-sm btn-default edit" data-edit="basic">
				<span class="glyphicon glyphicon-pencil"></span>
				Edit
			</button>
			<? endif; ?>

			<? if($name): ?>
			<div class="block">
				<strong>Name</strong>
				<span><?=htmlspecialchars($name)?></span>
			</div>
			<? endif; ?>

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

			<? if($is_owner): ?>
			<button class="btn btn-sm btn-default edit" data-edit="about">
				<span class="glyphicon glyphicon-pencil"></span>
				Edit
			</button>
			<? endif; ?>

			<div class="block">
				<strong>Tagline</strong>
				<? if($tagline): ?>
				<span><?=htmlspecialchars($tagline)?></span>
				<? else: ?>
				<span class="text-muted">No tagline.</span>
				<? endif; ?>
			</div>

			<div class="block">
				<strong>Bio</strong>
				<? if($bio): ?>
				<span class="readmore"><?=nl2br(htmlspecialchars($bio))?></span>
				<? else: ?>
				<span class="text-muted">No bio.</span>
				<? endif; ?>
			</div>

			<? if($birthday): ?>
			<div class="block">
				<strong>Birthday</strong>
				<span><?=$birthday_formatted?> - <?=$age?> years old</span>
			</div>
			<? endif; ?>

			<div class="block">
				<strong>Location</strong>
				<span><?=htmlspecialchars($location)?></span>
			</div>

		</div>

	</div>

	<div class="col-lg-6">

		<div class="panel panel-default">
			<h3>Links</h3>

			<? if($is_owner): ?>
			<button class="btn btn-sm btn-default edit" data-edit="links">
				<span class="glyphicon glyphicon-pencil"></span>
				Edit
			</button>
			<? endif; ?>

			<div class="block">
				<strong>Website</strong>
				<? if($website_url): ?>
				<span>
					<a href="<?=$website_url?>" target="_blank"><?= $website_title ? htmlspecialchars($website_title) : $website_url ?></a>
				</span>
				<? else: ?>
				<span class="text-muted">N/A</span>
				<? endif; ?>
			</div>

			<div class="block">

				<strong>Other Links</strong>

				<? if(count($links) < 1): ?>
				<span class="text-muted">No links.</span>
				<? endif; ?>

				<? foreach($links as $row): ?>
				<span><a href="<?=$row['url']?>" target="_blank"><?=htmlspecialchars($row['text'])?></a></span>
				<? endforeach; ?>

			</div>

		</div>

		<div class="panel panel-default">
			<h3>Favorites</h3>

			<? if($is_owner): ?>
			<button class="btn btn-sm btn-default edit" data-edit="favorites">
				<span class="glyphicon glyphicon-pencil"></span>
				Edit
			</button>
			<? endif; ?>

			<div class="block">
				<strong>Movies</strong>
				<? if($favorite_movies): ?>
				<span class="readmore"><?=htmlspecialchars($favorite_movies)?></span>
				<? else: ?>
				<span class="text-muted">N/A</span>
				<? endif; ?>
			</div>

			<div class="block">
				<strong>TV Shows</strong>
				<? if($favorite_tv): ?>
				<span class="readmore"><?=htmlspecialchars($favorite_tv)?></span>
				<? else: ?>
				<span class="text-muted">N/A</span>
				<? endif; ?>
			</div>

			<div class="block">
				<strong>Music</strong>
				<? if($favorite_music): ?>
				<span class="readmore"><?=htmlspecialchars($favorite_music)?></span>
				<? else: ?>
				<span class="text-muted">N/A</span>
				<? endif; ?>
			</div>

			<div class="block">
				<strong>Quotes</strong>
				<? if($favorite_quotes): ?>
				<span class="readmore"><?=nl2br(htmlspecialchars($favorite_quotes))?></span>
				<? else: ?>
				<span class="text-muted">N/A</span>
				<? endif; ?>
			</div>

		</div>

	</div>

</div>