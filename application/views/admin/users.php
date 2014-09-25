<div class="alert alert-info"><b>Notice:</b> Do not ban unless the person clearly broke an instant ban rule. Any ban must be taken in consideration from Sergio. This also applies to official status, and staff.</div>

<div class="panel panel-primary">
  
  <div class="panel-heading">
    <h3 class="panel-title">Users</h3>
  </div>

  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <tr>
          <th>Information</th>
          <th>Email</th>
          <th>Actions</th>
        </tr>

        <? foreach($users as $user): ?>
        <tr data-id="<?=$user['id']?>">
          <td>
            <img src="<?= avatar_url($user['avatar'], $user['email'], 50); ?>" class="img-circle pull-left" style="width: 50px; height: 50px;" />
            <strong><?=$user['username']?></strong> 
            (# <?=$user['id'];?>)
            <?= ($user['employee'] == 1 ? '<span class="label label-primary">Staff</span>' : '<span class="label label-success">User</span>'); ?>
          </td>
          <td><?= $user['email']; ?></td>
          <td>
            <button class="btn btn-success btn-sm edit-user">Edit</button>
            <button class="btn btn-warning btn-sm ban-user">Ban</button>
            <button class="btn btn-danger btn-sm delete-user">Delete</button>
          </td>
        </tr>
        <? endforeach; ?>

      </table>
    </div>
  </div>
        
</div>