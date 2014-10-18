<? if($msg['exists']): ?>
<div class="alert alert-<?=$msg['type']?> alert-dismissable" style="<?=$msg['style']?>">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?=$msg['text']?>

</div>
<? endif; ?>