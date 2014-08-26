<div class="page-header">
  <h1>Settings &amp; Info</h1>
</div>

<ul class="nav nav-tabs">
  <li class="<? if($tab=='account') echo 'active' ?>"><a href="account">Account</a></li>
  <li class="<? if($tab=='security') echo 'active' ?>"><a href="security">Security</a></li>
  <li class="<? if($tab=='password') echo 'active' ?>"><a href="password">Password</a></li>
  <li class="<? if($tab=='oauth') echo 'active' ?>"><a href="oauth">OAuth</a></li>
</ul>

<br />

<? $this->load->view('settings/'.$tab); ?>

<script src="<?=base_url('assets/js/settings.js');?>"></script>