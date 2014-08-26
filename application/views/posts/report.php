<? if($is_owner): ?>
<div class="alert alert-warning">You may not report your own post.</div>
<? else: ?>

<form action="javascript:;" method="post">
  <div class="form-group">
    <label for="reason">Reason</label>
    <select name="reason" id="reason" class="form-control">
      <option value="0">Choose one...</option>
      <? foreach($reasons as $key => $value): ?>
      <option value="<?=$key?>"><?=$value?></option>
      <? endforeach; ?>
    </select>
  </div>

  <div class="form-group">
    <label for="details">Details</label>
    <textarea class="form-control" id="details" placeholder="Explain the problem with this post."></textarea>
  </div>
  <br>
    <em> Our team will review this request and take action accordingly. Spamming or trolling this function will result in a two day ban, second offenders will be permanently banned. </em>
    <br>
</form>

<? endif; ?>