<?php
include '../universal.php';
?>
<?php
if (isset($_SESSION['message'])) {

?>
<script>
  $.notifyBar({  html: <?php echo $_SESSION['message']; ?>, position: "top" }); 
</script>
<?php
unset($_SESSION['message']);
}

?>
<?php
	$main = mysqli_query($link, 'select * from alerts where shown="0" and userid="'.$_SESSION['userid'].'"');
	if (mysqli_num_rows($main) !== 0) {
?>

<?php
		while($data = mysqli_fetch_array($main)){
    		$userid=$data['userid'];
   			$content=$data['content'];
   			$id = $data['id'];
        $alertid = $data['id'];
   			mysqli_query($link, 'update alerts set shown="1" where id="'.$alertid.'"');

?>
<script>
function decodeEntities(s){
    var str, temp= document.createElement('p');
    temp.innerHTML= s;
    str= temp.textContent || temp.innerText;
    temp=null;
    return str;
}


function notify(post) {

  $.notifyBar({  html: decodeEntities(post), position: "top" }); 

}

var post = decodeEntities('<?php echo $content; ?>');

notify(post);
</script>
<?php
}

	}
	?>
