<?
/* This is the template
   for form error boxes
 */
?>
<?php if($errors): ?>
<div class="alert alert-danger">
  <p style="margin-bottom:5px;">
  	<strong>Oops!</strong>
  	Please fix the following error(s).
  </p>
  <ul>
    <?=$errors?>
  </ul>
</div>
<?php endif; ?>