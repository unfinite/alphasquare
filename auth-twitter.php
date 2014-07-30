<?php
include('universal.php');
  $config   = dirname(__FILE__) . '/auth/config.php';
  require_once( "auth/Hybrid/Auth.php" );
error_reporting(E_ALL);

function user_exists($email) {

global $link;


      $e = mysqli_real_escape_string($link, stripslashes($email));

    
      $query = 'select id from users where email="'.$e.'"';

      $req = mysqli_query($link, $query);


      if(mysqli_fetch_array($req) !== false) { 

        return true; 

      } else {

        return false;

      }


}


  try{
    // create an instance for Hybridauth with the configuration file path as parameter
    $hybridauth = new Hybrid_Auth( $config );
  
    // try to authenticate the user with twitter, 
    // user will be redirected to Twitter for authentication, 
    // if he already did, then Hybridauth will ignore this step and return an instance of the adapter
    $twitter = $hybridauth->authenticate( "Twitter" );  
 
    // get the user profile 
    $twitter_user_profile = $twitter->getUserProfile();
    
      $user = mysqli_real_escape_string($link, stripslashes($twitter_user_profile->displayName));


      $email = mysqli_real_escape_string($link, stripslashes($twitter_user_profile->email));

      if (user_exists($email) == true) {

      $query = 'select id, username from users where email="'.$email.'"';
        $qu2 = mysqli_query($link, $query);
        $foo = mysqli_fetch_array($qu2);

        $_SESSION['userid'] = $foo['id'];
        $_SESSION['username'] = $foo['username'];

        header("Location: dashboard");

      } else {

        header("Location: login?message=notexists");

      }

  }


  catch( Exception $e ){  
    switch( $e->getCode() ){ 
      case 0 : $_SESSION['autherror'] = "Error (-21); An unknown error ocurred. We're sorry. Contact a Ranger."; header('Location: login?message=sess'); break;
      case 1 : $_SESSION['autherror'] = "An unknown error ocurred. Please contact a Ranger with the error code: (-31)."; header('Location: login?message=sess'); break;
      case 2 : $_SESSION['autherror'] = "An unknown error ocurred. Please contact a Ranger with the error code: (-34)."; header('Location: login?message=sess'); break;
      case 3 : $_SESSION['autherror'] = "You've chosen a provider that has been disabled temporarily. Sorry."; header('Location: login?message=sess'); break;
      case 4 : $_SESSION['autherror'] = "An unknown error ocurred. Please contact a Ranger with the error code: (-0)."; header('Location: login?message=sess'); break;
      case 5 : $_SESSION['autherror'] = "Sorry for this, but somehow we couldn't authenticate you with the service. Did you hit cancel?";
               header('Location: login?message=sess'); break;
      case 6 : $_SESSION['autherror'] = "Please login again to the service."; 
               $twitter->logout(); 
               header('Location: login?message=sess'); break;
      case 7 : $_SESSION['autherror'] = "Please login again to the service."; 
               $twitter->logout(); 
              header('Location: login?message=sess'); break;
      case 8 : $_SESSION['autherror'] = "The service didn't like the request you threw. Try again later."; header('Location: login?message=sess'); break;
    } 
 
  }




      

    
?>
