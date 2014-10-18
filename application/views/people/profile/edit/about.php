<!-- About -->
<form id="edit-profile-form" data-type="about">
	<div class="form-group">
		<label for="tagline">Tagline <small>(100 characters or less)</small></label>
		<textarea name="tagline" id="tagline" class="form-control autosize" placeholder="Write something short..." maxlength="100"><?=htmlspecialchars($tagline)?></textarea>
	</div>
	<div class="form-group">
		<label for="bio">Bio</label>
		<textarea name="bio" id="bio" class="form-control autosize" placeholder="Write something about yourself..." maxlength="1500"><?=htmlspecialchars($bio)?></textarea>
	</div>
	<div class="form-group">
		<label for="birthday">Birthday</label>
		<input type="text" name="birthday" id="birthday" class="form-control" placeholder="When were you born?" value="<?=$birthday?>" />
	</div>
	<div class="form-group">
		<label for="location">Location</label>
		<input type="text" name="location" id="location" class="form-control" placeholder="Earth" value="<?=htmlspecialchars($location)?>" maxlength="50" />
	</div>
</form>

<script>

</script>