<!-- Meta -->
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Alphasquare: Debate the web">
<?=$extra_meta?>

<link rel="shortcut icon" href="<?= base_url('favicon.ico'); ?>">

<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>

<!-- Stylesheets -->
<link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/css/global.css'); ?>" rel="stylesheet" />
<?=$extra_stylesheets?>

<!-- JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?= base_url('assets/js/plugins/all.js'); ?>"></script>
<script src="<?= base_url('assets/js/global.js'); ?>"></script>
<script>
$(function() {
  Alp.init({
    base: '<?=base_url()?>'
  });
});
</script>

<!--[if lt IE 10]>
<link href="<?=base_url('assets/css/ie-sucks.css');?>" rel="stylesheet" />
<![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->