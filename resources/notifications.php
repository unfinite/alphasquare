<?php


include '../universal.php';


	$main = mysqli_query($link, 'select * from alerts where shown="0" and userid="'.$_SESSION['userid'].'"');
	if (mysqli_num_rows($main) !== 0) {

		while($data = mysqli_fetch_array($main)){
    		$userid=$data['userid'];
   			$content=$data['content'];
   			$id = $data['id'];
        $alertid = $data['id'];
   			mysqli_query($link, 'update alerts set shown="1" where id="'.$alertid.'"');

?>
<script>
function decodeEntities(e){var t,n=document.createElement("p");n.innerHTML=e;t=n.textContent||n.innerText;n=null;return t}function notify(e){$.notifyBar({html:decodeEntities(e),position:"top"})}var post=decodeEntities("<?php echo $content; ?>");notify(post)
</script>
<?php
}

	}
	?>
