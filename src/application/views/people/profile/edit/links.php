<!-- Links -->
<form id="edit-profile-form" data-type="basic">
	<div class="form-group">
		<label for="website[title]">Website</label>
		<input type="text" name="website[text]" id="website" class="form-control" value="<?=htmlspecialchars($website_title)?>" placeholder="Text" />
		<input type="url" name="website[url]" id="website_url" class="form-control" style="margin-top: 8px;" value="<?=htmlspecialchars($website_url)?>" placeholder="URL" />
	</div>
	<div class="form-group">
		<label>Other Links <small>(max. 5)</small></label>
		<br />

		<?php if(count($links) < 1): ?>
		<div class="text-muted" id="no-links">No links.</div>
		<?php endif; ?>

		<div id="edit-links" data-total="<?=count($links)?>">

			<?php $increment = 0; ?>
			<?php foreach($links as $row): ?>
			<div class="link">

				<div class="link-info">
					<span class="text"><?=htmlspecialchars($row['text'])?></span>
					<a href="<?=htmlspecialchars($row['url'])?>" target="_blank"><?=htmlspecialchars($row['url'])?></a>
				</div>

				<div class="link-edit">
					<input type="hidden" class="form-control" name="links[<?=$increment?>][id]" value="<?=$row['id']?>" />
					<input type="text" class="form-control" name="links[<?=$increment?>][text]" placeholder="Text" value="<?=htmlspecialchars($row['text'])?>" maxlength="35" />
					<input type="text" class="form-control" name="links[<?=$increment?>][url]" placeholder="URL" value="<?=htmlspecialchars($row['url'])?>" />
				</div>

				<span class="glyphicon glyphicon-pencil edit" title="Edit link"></span>
				<span class="glyphicon glyphicon-trash delete" title="Delete link"></span>

			</div>
			<?php $increment++; ?>
			<?php endforeach; ?>

			<script type="text/template" id="new-link-template">
				<div class="new-link">
					<input type="text" class="form-control" name="links[][text]" placeholder="Text" maxlength="35" />
					<input type="text" class="form-control" name="links[][url]" placeholder="URL" />
					<a href="javascript:;" class="text-small cancel">cancel link</a>
				</div>
			</script>
			<button type="button" class="btn btn-sm btn-default" id="new-link-btn">+ Add Link</button>

		</div>

	</div>
</form>

<script>
// used 50 to prevent number from running in with numbers above
var newId = 50;
var total = $('#edit-links').data('total');
$('#new-link-btn').click(function() {
	var stop = false;
	$('.new-link input').each(function() {
		if($(this).val() === '') {
			stop = true;
		}
	});
	if(!stop) {
		var html = $('#new-link-template').html();
		html = $(html);
		html.find('input[name="links[][text]"]').attr('name', 'links['+newId+'][text]');
		html.find('input[name="links[][url]"]').attr('name', 'links['+newId+'][url]');
		html.insertBefore(this);
		newId++;
	}
});
$('#edit-links').on('click', '.new-link a.cancel', function() {
	$(this).closest('.new-link').remove();
});
$('#edit-links .link .edit').click(function() {
	var parent = $(this).closest('.link');
	$(this).hide();
	$('.link-info', parent).hide();
	$('.link-edit', parent).show();
})
$('#edit-links .link .delete').click(function() {
	if(!confirm('Really remove that link? It will not be permanently removed until you click Save.')) return false;
	$(this).closest('.link').remove();
});
</script>