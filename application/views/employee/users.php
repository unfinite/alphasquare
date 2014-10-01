<div class="alert alert-info"><b>Notice:</b> Do not ban unless the person clearly broke an instant ban rule. Any ban must be taken in consideration from Sergio. This also applies to official status, and staff.</div>

<div class="table-responsive">
  <table class="table table-hover table-bordered">
    <tr>
      <th>ID</th>
      <th>Avatar &amp; Info</th>
      <th>Email Address</th>
      <th>Actions</th>
    </tr>

    <? foreach($users as $user): ?>
    <tr data-id="<?=$user['id']?>">
      <td><?=$user['id']?></td>
      <td>
        <a href="<?=profile_url($user['username']);?>">
          <img src="<?= avatar_url($user['avatar'], $user['email'], 40); ?>" class="img-circle pull-left" style="width: 40px; height: 40px; margin-right: 5px;" />
        </a>
        <strong><?=$user['username']?></strong> 
        <?= ($user['employee'] == 1 ? '<span class="label label-primary">Staff</span>' : ''); ?>
        <br /><em><?=$user['name']?></em>
      </td>
      <td><a href="mailto:<?= $user['email']; ?>" target="_blank"><?= $user['email']; ?></a></td>
      <td>
        <button class="btn btn-success btn-sm edit-user"><span class="glyphicon glyphicon-pencil"></span> Edit</button>

        <div class="btn-group">
          <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
            <span class="glyphicon glyphicon-cog"></span>
            <span class="caret"></span>
          </button>

          <ul class="dropdown-menu">
            <li><a href="#" class="ban-user">Suspend / Ban</a></li>
            <li><a href="#" class="delete-user">Delete</a></li>
          </ul>
        </div>

      </td>
    </tr>
    <? endforeach; ?>

  </table>
</div>