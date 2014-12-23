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

<!-- Make it snow! -->
<script src="<?= base_url('assets/js/snowstorm.js'); ?>"></script>

<!-- Stylesheets -->
<link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />
<link href="<?= base_url('assets/css/global.css'); ?>" rel="stylesheet" />
<?=$extra_stylesheets?>

<!-- start Mixpanel -->
<script type="text/javascript">(function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);
mixpanel.init("a33260663116496a21198829ac80e801");</script><!-- end Mixpanel -->
<!-- end Mixpanel -->

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

<?php

	if(session_get("loggedin")) {

		$uid = session_get("userid");
		$username = session_get("username");
		$points = session_get("points");

		echo "<script>";
		echo "var uid = ".$uid.";";
		echo "mixpanel.identify(uid);";
		echo 'mixpanel.people.set({"points": '.$points.', "username": "'.$username.'"});';
		echo "</script>";

	}

?>

<script>
snowStorm.autoStart = true;

function turnoff() {
   javascript: (
   function () { 
   // the css we are going to inject
   var css = 'html {-webkit-filter: invert(100%);' +
       '-moz-filter: invert(100%);' + 
       '-o-filter: invert(100%);' + 
       '-ms-filter: invert(100%); }',

   head = document.getElementsByTagName('head')[0],
   style = document.createElement('style');

   // a hack, so you can "invert back" clicking the bookmarklet again
   if (!window.counter) { window.counter = 1;} else  { window.counter ++;
   if (window.counter % 2 == 0) { var css ='html {-webkit-filter: invert(0%); -moz-filter:    invert(0%); -o-filter: invert(0%); -ms-filter: invert(0%); }'}
    };

   style.type = 'text/css';
   if (style.styleSheet){
   style.styleSheet.cssText = css;
   } else {
   style.appendChild(document.createTextNode(css));
   }

   //injecting the css to the head
   head.appendChild(style);
   }());
   snowStorm.start();
}
</script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->