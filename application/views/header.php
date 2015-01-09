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
<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Raleway:200,300,700' rel='stylesheet' type='text/css'>

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
<script src="<?= base_url('assets/js/emojify.min.js'); ?>"></script>
<script>
$(function() {
  Alp.init({
    base: '<?=base_url()?>',
    loggedin: <?= session_get("loggedin") ? "true" : "false"; ?>,
    userid: <?= session_get("userid") ? session_get("userid") : 0; ?>
  });

  emojify.setConfig({
      img_dir          : '/assets/img/emoji',  
      ignored_tags     : {                
          'SCRIPT'  : 1,
          'TEXTAREA': 1,
          'A'       : 1,
          'PRE'     : 1,
          'CODE'    : 1
      }
  });

  emojify.run();

});

</script>

<?php if($this->php_session->get('tour')): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.10.1/js/bootstrap-tour.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tour/0.10.1/css/bootstrap-tour.min.css">
<script>
$(document).ready(function() {
	var tour = new Tour({
		backdrop: true,
		steps: [
			{
				placement: "bottom",
				element: "#post-bar",
				title: "Hello, welcome to Alphasquare!",
				content: "Hello and welcome to Alphasquare! To get you started, we've crafted a little tour. Don't worry; it's not too long! Just hit next to fire it up.",
				path: "/dashboard"
			},
			{
				placement: "bottom",
				element: "#post-bar",
				title: "This is the post bar.",
				content: "Go ahead, type up a post, don't be shy! After you're done, hit enter to post it. Then click next."
			},
			{
				placement: "bottom",
				element: "#no-following-message",
				title: "Follow some people",
				content: "Oh, your dashboard looks a bit empty. Let's get some people's updates here. Hit next to start following people!"
			},
			{
				placement: "bottom",
				element: ".user:first-child",
				title: "Follow someone",
				content: "Here's a profile! Hit the follow button to get their updates on your dashboard.",
				path: "/people/list/popular"
			},
			{
				placement: "right",
				element: ".post:first-child",
				title: "That's about it!",
				content: "Now you should have some updates on your dash. Go ahead, interact, share debates, and talk to others! You will earn points, the more you interact, the more points. Try getting to 1k! ",
				path: "/dashboard",
				onShow: function (tour) { $.get("/account/tour/false"); }
			}
			
		]
	});
	tour.init();
	tour.start(true);
});
</script>
<?php endif; ?>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->