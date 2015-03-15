<!-- Basic Info -->
<form id="edit-profile-form" data-type="basic">
	<div class="form-group">
		<label for="name">Name</label>
		<input type="text" name="name" id="name" class="form-control" value="<?=htmlspecialchars($name)?>" placeholder="Enter your name..." />
	</div>
	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" class="form-control" value="<?=$username?>" placeholder="Enter a username..." />
	</div>
</form>