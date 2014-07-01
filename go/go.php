<?php
function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];
         
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
     
    return $_SERVER['REMOTE_ADDR'];
}


$content = getRealIP();
$filename = substr(md5(microtime()),rand(0,26),5);
$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/".$filename.".txt","wb");
fwrite($fp,$content);
fclose($fp);

echo 'Welcome to Go!';
?>