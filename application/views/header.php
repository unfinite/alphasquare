<!-- Meta -->
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,  minimal-ui, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="description" content="Alphasquare: Debate the web">
<?=$extra_meta?>

<link rel="shortcut icon" href="<?= base_url('favicon.ico'); ?>">

<link href='http://fonts.googleapis.com/css?family=Roboto:200,300,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>

<!-- Stylesheets -->
<link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/css/global.css'); ?>" rel="stylesheet" />
<?=$extra_stylesheets?>

<!-- JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?= base_url('assets/js/libs/packaged.js'); ?>"></script>
<script src="<?= base_url('assets/js/global.js'); ?>"></script>
<script>
$(function() {
  Alp.init({
    base: '<?=base_url()?>',
    loggedin: <?= session_get("loggedin") ? "true" : "false"; ?>,
    userid: <?= session_get("userid") ? session_get("userid") : 0; ?>
  });
});
</script>

<!-- Google Analytics code start -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45964479-2', 'auto');
  ga('send', 'pageview');

</script>
<!-- Google Analytics code end -->


<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->