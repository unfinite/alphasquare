<div class="row">

  <div class="col-lg-8 col-md-8">

    <div class="page-header">
      <h2>Search results for <b><?=$query?></b></h2>
    </div>

    <?=$results_html?>

    <? if($results_count < 1): ?>
    <p>Sorry, we couldn't find any debates matching your search.</p>
    <? endif; ?>

  </div>

  <div class="col-lg-4 col-md-4" id="sidebar">

    <?php $this->load->view('sidebar/main') ?>
    <?php $this->load->view('sidebar/follows') ?>

  </div>

</div>

<script src="<?=base_url('assets/js/dashboard.js')?>"></script>