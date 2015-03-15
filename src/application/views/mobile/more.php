<div class="panel panel-default">
  <ul class="nav nav-pills nav-stacked">
    <li><a href="<?=base_url('people')?>"><span class="glyphicon glyphicon-user"></span> Discover</a></li>
    <li><a href="<?=base_url('about/terms')?>"><span class="glyphicon glyphicon-bookmark"></span> About Alphasquare</a></li>
    <li><a href="<?=base_url('about/terms')?>"><span class="glyphicon glyphicon-comment"></span> Contact Alphasquare</a></li>
    <li><a href="<?=base_url('help')?>"><span class="glyphicon glyphicon-question-sign"></span> Help Center</a></li>
    <li><a href="<?=base_url('about/terms')?>"><span class="glyphicon glyphicon-tasks"></span> Terms of Service</a></li>
    <li><a href="<?=base_url('about/privacy')?>"><span class="glyphicon glyphicon-eye-close"></span> Privacy Policy</a></li>
  </ul>
</div>

<style>
.nav.nav-pills li a .glyphicon {
  padding-right: 5px;
}
</style>


<?php $this->load->view('sidebar/main') ?>