<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$subject?></title>
</head>
<body style="padding:35px 20px;margin:0;background:#f3f3f3;font-family:Helvetica, Arial, sans-serif;font-size:14px;">

<div style="background-color:#f9f9f9;border:1px solid #ccc;max-width:530px;border-radius:4px;margin:0 auto;">

<!-- header -->
<h1 style="color:#3498db;margin:20px;padding-bottom:5px;border-bottom:1px solid #ddd;font-size:27px;">Alphasquare</h1>

<!-- content -->
<div style="margin:20px 20px 25px;">
Hello <?=$name?>,
<br />
<br />

<?=$message?>
</div>

</div>

<!-- footer -->
<div style="margin:0px auto;padding:15px 0;color:#555;font-size:11px;width:530px;text-align:center;">
<div style="font-size:12px;margin-bottom:3px;">
  Copyright &copy; 2014 Alphasquare. This email was sent to <strong><?=$to_email?></strong>.
</div>

<?php if(isset($show_unsubscribe)): ?>
Don't want email notifications anymore?
<br />
<a href="http://alphasquare.us/account/email_unsubscribe/<?=$unsub_key?>">Unsubscribe</a>
or <a href="http://alphasquare.us/settings/notifications">change your email preferences</a>.
<?php endif; ?>

</div>

</body>
</html>