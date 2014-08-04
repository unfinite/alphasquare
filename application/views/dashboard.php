<script src="<?=base_url('assets/js/dashboard.js')?>"></script>

<div class="row">

	<div class="col-lg-8 col-md-8">

		<?php $this->load->view('posts/post_box') ?>

		<div id="posts">
			<!-- Begin Posts HTML -->
			<?=$posts_html?>
			<!-- End Posts HTML -->
		</div>

	</div>

	<?php $this->load->view('templates/sidebar') ?>

</div>