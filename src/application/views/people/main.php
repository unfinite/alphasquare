<div class="row" id="people">

	<div class="col-lg-8 col-md-8">

		<div class="page-header" style="margin-top:10px;">
			<h1 class="pull-left">People</h1>

			<ul class="nav nav-pills pull-right">
				<li <?= $tab=='popular'?'class="active"':''?>><a href="popular">Popular</a></li>
				<li <?= $tab=='random'?'class="active"':''?>><a href="random">Random</a></li>
				<li <?= $tab=='new'?'class="active"':''?>><a href="new">New</a></li>
			</ul>

			<div class="clearfix"></div>
		</div>

		<?=$users?>

		<div class="clearfix"></div>
	</div>

	<div class="col-lg-4 col-md-4" id="sidebar">
    <?php $this->load->view('sidebar/main', array('people'=>true)) ?>
    <?php $this->load->view('sidebar/follows') ?>
  </div>

</div>

<script src="<?=base_url('assets/js/profile.js')?>"></script>
<script>
$(function() {
	Profile.init();
});
</script>