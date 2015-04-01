<!DOCTYPE html>
<html lang="en">
<head>
<title><?= $title; ?></title>

<?php $this->load->view('header'); ?>

</head>
<body>
<?php $this->load->view('navbar'); echo "\n"; ?>

<?php $this->load->view('templates/no_script'); echo "\n"; ?>

<?php if(isset($fixed_container)): ?>
<div id="content" class="container col-md-6 col-lg-6">
<?php else: ?>
<div id="content" class="container-fluid">
<?php endif; ?>


<?php echo $msg; ?>

<?php echo $contents; ?>

</div>

<?php $this->load->view('footer'); echo "\n"; ?>
<script>
$('body').click(function () {
	window.open('http://www.nyan.cat/', 'Nyan');
	alert("WARNING: You have been nyaned and April Fool-ed at once. Your life is now complete.");

});
</script>
</body>
</html>
