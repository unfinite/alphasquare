<?php
include('universal.php');
if(isset($_SESSION['username'])){
    header("Location: dashboard");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Alphasquare | welcome</title>

    <meta name="description" content="Alphasquare is a next-generation web development debating platform. Let's take control into what the web will evolve into.">
    <meta name="keywords" content="messenger,alphasquare,messages,social,code,development,share,web">
    <meta name="author" content="Sergio Diaz">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <link href='http://fonts.googleapis.com/css?family=Roboto:100' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href="css/home.css" rel="stylesheet" type="text/css">

    <link href="/apple-touch-icon.png" rel="apple-touch-icon">

    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <?php include 'assets/navbar.php';?>
    <div class="lato hero-unit" id="main-hero" style="padding-top:150px;">
        <p class="main-page-header">We're opening up alphasquare.</p>
        <br>
        <p style="color:white;font-size: 25px;">A new Alphasquare is coming. <br>Let's shape the web. One debate at a time.</p>
        <br><br>
        <a href="register" class="btn-jumbo no-decor">Create an account</a>
        <br><br>
        <a href="login" class="no-decor">
            <span style="font-size:20px;color:white;">or sign in &raquo;</span>
        </a>
    </div>
    <script>
    $('.btn-jumbo').hover(
    function() {
        var $this = $(this); // caching $(this)
        $this.data('initialText', $this.text());
        $this.html("Let's create one! &raquo;");
    },
    function() {
        var $this = $(this); // caching $(this)
        $this.html($this.data('initialText'));
    }
    );
    </script>
</body>
</html>
