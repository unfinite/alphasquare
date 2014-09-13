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
							

								<? foreach($users as $user): ?>
								<tr>
								<td><img src="<?php echo avatar_url($user['avatar'], $user['email']); ?>" class="img-circle" style="width: 30px; height: 30px;"></td>
								<td><?php echo $user['id']; ?></td>
								<td><?php echo $user['username']; ?></td>
								<td><?php echo $user['email']; ?></td>
								<td><?php if($user['employee'] !== 0) { echo '<span class="label label-primary">Staff</span>'; } else { echo '<span class="label label-success">User</span>'; } ?></td>
								<td><a href="#" class="btn btn-default">Actions &raquo;</a></td>
								</tr>
								<? endforeach; ?>


							
						</tbody>
					</table>
				</div>
			</div>
