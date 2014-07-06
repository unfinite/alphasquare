<?php

include('start.php');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <?php

  $Views->load_view("generic");

  ?>
  </head>
  <body>
  <div class="container">


  <center>
<?php

$Views->load_view("header");

?>
    </center>
  <div class="container">
<?php 
$Views->load_view("buttons");
?>
<br><Br><center><code><?php $HelloWorld->say("It's really cool! In fact, it's so awesome, that this text was written here by a module."); ?></code></center><br><Br>
<div class="container">
<?php

$Views->load_view("description");

?>

 </div>

      <br><hr>
<div class="row">
    <div class="col-md-6">

<?php

$Views->load_view("bottom");

?>
  </div>
</div>

        <br>
      <hr>
<?php 
$Views->load_view("buttons");
?>

</div>
<br><br>
  </body>
</html>