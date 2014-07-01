<?php

define('IN_BLOG', true);

define('PATH', '');

include('includes/miniblog.php');

?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>Alphapixels' Blog. The hub for all me, myself, and I.</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<link href='//cdnjs.cloudflare.com/ajax/libs/animate.css/3.0.0/animate.min.css' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Roboto:100,300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:300' rel='stylesheet' type='text/css'>
<style>
body {
	background-image: url("linedpaper.png");
}
.roboto-slab {
	font-family: 'Roboto Slab', serif;
	font-size: 16px;
}
.right {
  float: right;

}
</style>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'alphasquare'; // required: replace example with your forum shortname

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function () {
        var s = document.createElement('script'); s.async = true;
        s.type = 'text/javascript';
        s.src = '//' + disqus_shortname + '.disqus.com/count.js';
        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
    }());
    </script>
</head>

<body>

<div class="container">
<center>
<br>
<br>
<img class="img-circle animated bounceIn" style="height:200px; width:200px;" src="https://www.twii.me/data/user/avatar/big/12/19196187145435138732309468913.jpg">
<br>
<div class="container">

  <h1 >Hi there. <br><small>My name is Alphapixels and I'm a web designer.</small></h1>


</div>
<br>
</center>
</div>
<div class="container">
	<?=$miniblog_posts?>

	</div>



		<? if(!$single) { ?> <center>

			<? if($miniblog_previous) {	?> <?=$miniblog_previous?><? } ?>
&nbsp;
			<? if($miniblog_next) {	?><?=$miniblog_next?> <? } ?>
</center>

		<? } ?>

		<? if($single) { ?>
		<center>
<br>
			<a class="btn btn-success" href="<?=$config['miniblog-filename']?>"> return to posts</a>
			<br>
			<br>
			<div class="container">
			<div class="col-md-6 col-md-offset-3">
			<div id="disqus_thread"></div>
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'alphasquare'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
    </div>
			</div>
		</center>	<? } ?>





	<div class="footer">



</div>
<br><center>
		<p>Sponsored by: <a href="http://www.spyka.net/">Spyka</a></p>
</center>
	</div>



</body>

</html>