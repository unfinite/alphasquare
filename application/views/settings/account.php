<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title text-bold">Name</h3>
  </div>
  <div class="panel-body">
    <span style="font-size:15px;"><?= $name ? $name : 'No name provided.'; ?></span>
    <br />
    <em>You can edit this on your <a href="<?=profile_url()?>/about">about page</a>.</em>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title text-bold">Change Email</h3>
  </div>
  <div class="panel-body">
    <form action="javascript:;" id="email-change">
      <input type="email" value="<?=$email?>" class="form-control" />
      <br />
      <button class="btn btn-primary btn-sm">Change</button>
    </form>
  </div>
</div>