
<div class="container ">
<h2>Welcome to the employee panel</h2>
<hr>
<ul class="nav nav-pills">
  <li class="active"><a href="<?=base_url('employee')?>">Welcome</a></li>
  <li><a href="<?=base_url('employee/ban')?>">Ban user</a></li>
  <li><a href="<?=base_url('employee/notes')?>">Notes</a></li>
  <li><a href="<?=base_url('employee/official')?>">Add official</a></li>
  <li><a href="<?=base_url('employee/addstaff')?>">Add staff</a></li>
</ul>

<br>

<div class="alert alert-info"><b>Notice:</b> Do not ban unless the person clearly broke an instant ban rule. Any ban must be taken in consideration from Sergio. This also applies to official status, and staff.</div>
<br>
      				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Users</h3>

					</div>
					<div class="panel-body">
					</div>
					<table class="table table-hover" id="dev-table">
						<thead>
							<tr>
								<th>Avatar</th>
								<th>ID</th>
								<th>Username</th>
								<th>Email</th>
								<th>Role</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>

								<? foreach($users as $user): ?>
								<td><img src="<?=$avatar?>" class="img-circle" style="width: 30px; height: 30px;"></td>
								<td><?=$id?></td>
								<td><?=$username?></td>
								<td><?=$email?></td>
								<td><?php if($employee !== 0) { echo '<span class="badge badge-success">Employee</span>'; } else { echo '<span class="badge badge-default">User</span>'; } ?></td>
								<td><a href="#" class="btn btn-default">Actions &raquo;</a></td>

								<? endif; ?>


							</tr>
						</tbody>
					</table>
				</div>
			</div>


</div>