<div class="alert alert-info"><b>Notice:</b> Do not ban unless the person clearly broke an instant ban rule. Any ban must be taken in consideration from Sergio. This also applies to official status, and staff.</div>

<div class="panel panel-primary">
  
  <div class="panel-heading">
    <h3 class="panel-title">Users</h3>
  </div>

  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <tr>
          <th>Avatar</th>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>

        <? foreach($users as $user): ?>
        <tr data-id="<?=$user['id']?>">
          <td><img src="<?= avatar_url($user['avatar'], $user['email']); ?>" class="img-circle" style="width: 30px; height: 30px;"></td>
          <td><?= $user['id']; ?></td>
          <td><?= $user['username']; ?></td>
          <td><?= $user['email']; ?></td>
          <td><?= ($user['employee'] == 1 ? '<span class="label label-primary">Staff</span>' : '<span class="label label-success">User</span>'); ?></td>
          <td>
            <button class="btn btn-success edit-user">Edit</button>
            <button class="btn btn-warning ban-user">Ban</button>
            <button class="btn btn-danger delete-user">Delete</button>
          </td>
        </tr>
        <? endforeach; ?>

      </table>
    </div>
  </div>
        
</div>