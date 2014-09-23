<div class="container">

	<h2><?=$title?></h2>
	<hr />
	<ul class="nav nav-pills">
	  <li><a href="<?=base_url('employee')?>">Users</a></li>
	  <li><a href="<?=base_url('employee/notes')?>">Notes</a></li>
	  <li><a href="<?=base_url('employe/reports')?>">Reports</a></li>
	</ul>

	<? $this->load->view('admin/'.$tab); ?>

</div>