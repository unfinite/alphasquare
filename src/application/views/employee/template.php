<div class="container">

	<h2>Employee Panel</h2>
	<hr />
	<ul class="nav nav-pills">
	  <li <?php if($tab === 'users') echo 'class="active"'; ?>><a href="<?=base_url('employee')?>">Users</a></li>
	  <li <?php if($tab === 'notes') echo 'class="active"'; ?>><a href="<?=base_url('employee/notes')?>">Notes</a></li>
	  <li <?php if($tab === 'reports') echo 'class="active"'; ?>><a href="<?=base_url('employe/reports')?>">Reports</a></li>
	</ul>

	<br />

	<?php $this->load->view('employee/'.$tab); ?>

</div>