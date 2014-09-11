

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
								<td><img src="<?=$user['avatar']?>" class="img-circle" style="width: 30px; height: 30px;"></td>
								<td><?=$user['id']?></td>
								<td><?=$user['username']?></td>
								<td><?=$user['email']?></td>
								<td><? if($user['employee'] !== 0) { echo '<span class="badge badge-success">Employee</span>'; } else { echo '<span class="badge badge-default">User</span>'; } ?></td>
								<td><a href="#" class="btn btn-default">Actions &raquo;</a></td>

								<? endif; ?>


							</tr>
						</tbody>
					</table>
				</div>
			</div>
