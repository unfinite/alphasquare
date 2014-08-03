<!DOCTYPE html>
<html lang="en">
<head>
<title><?= $title; ?></title>

<?php $this->load->view('templates/header'); ?>

</head>
<body>
<?php $this->load->view('templates/navbar'); echo "\n"; ?>

<?php $this->load->view('templates/no_script'); echo "\n"; ?>

<div id="content" class="container-fluid">
<?php echo $msg; ?>

<?php echo $contents; ?>

</div>

<?php $this->load->view('templates/footer'); echo "\n"; ?>

</body>
</html>