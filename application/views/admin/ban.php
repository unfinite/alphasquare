
<div class="container ">
<h2>Welcome to the employee panel</h2>
<hr>
<ul class="nav nav-pills">
  <li><a href="<?=base_url('employee')?>">Welcome</a></li>
  <li class="active"><a href="<?=base_url('employee/ban')?>">Ban</a></li>
  <li><a href="<?=base_url('employee/notes')?>">Notes</a></li>
  <li><a href="<?=base_url('employee/official')?>">Add official</a></li>
  <li><a href="<?=base_url('employee/addstaff')?>">Add staff</a></li>
</ul>

<br>

<div class="alert alert-info"><b>Notice:</b> Do not ban unless the person clearly broke an instant ban rule. Any ban must be taken in consideration from Sergio. This also applies to official status, and staff.</div>
<br>

<br>
		<form action="" method="post">
			<div class="form-group">
				<input type="text" id="username" placeholder="Username of guy to ban" class="form-control" />
			</div>
			<button type="submit">Ban</button>
			</form>

</div>