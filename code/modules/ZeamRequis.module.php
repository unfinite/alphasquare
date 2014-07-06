<?php

/*



 ________  _______   ________  _____ ______      
|\_____  \|\  ___ \ |\   __  \|\   _ \  _   \    
 \|___/  /\ \   __/|\ \  \|\  \ \  \\\__\ \  \   
     /  / /\ \  \_|/_\ \   __  \ \  \\|__| \  \  
    /  /_/__\ \  \_|\ \ \  \ \  \ \  \    \ \  \ 
   |\________\ \_______\ \__\ \__\ \__\    \ \__\
    \|_______|\|_______|\|__|\|__|\|__|     \|__|
                                                 
                                                 
                                                 
Copyright 2014 Alphasquare.us
Licensed with the MIT license
http://github.com/Alphasquare/Zeam
http://alphasquare.us/code

You can remove this, but we'd love you to death if you kept this here. 
Also, we'd marry you if you put a link back to Alphasquare.us.


*/


class ZeamRequisiteTester {

  function installRequisitesCheck() {
    
    $files=array("Modules"=>"modules/","Zeam"=>"zeam/", "Views"=>"views/");
    
    if (file_exists($files['Modules']) and file_exists($files['Zeam']) and file_exists($files['Views'])) {
      echo "All directories were created.";
    } else {
      echo "One or more of the directories is missing; please create it."; 
    }
  
  }

}

?>
