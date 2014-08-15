<!-- Favorites -->
<form id="edit-profile-form" data-type="favorites">
	<div class="form-group">
		<label for="movies">Movies</label>
		<textarea name="movies" id="movies" class="form-control autosize" placeholder="What movies do you like?" maxlength="500"><?=htmlspecialchars($favorite_movies)?></textarea>
	</div>
	<div class="form-group">
		<label for="tv">TV shows</label>
		<textarea name="tv" id="tv" class="form-control autosize" placeholder="What TV shows do you like?" maxlength="500"><?=htmlspecialchars($favorite_tv)?></textarea>
	</div>
	<div class="form-group">
		<label for="music">Music</label>
		<textarea name="music" id="music" class="form-control autosize" placeholder="What songs/artists do you like?" maxlength="500"><?=htmlspecialchars($favorite_music)?></textarea>
	</div>
</form>