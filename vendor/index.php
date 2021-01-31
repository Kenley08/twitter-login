<?php
     session_start();
    require_once 'vendor/autoload.php';
    use abraham\twitteroauth\twitteroauth;

            //app cusUmer Key
    define('CONSUMER_KEY','x97IEVdpv6TMWNVHKfcOf3ABP');

                //app cusumer secret
    define('CONSUMER_SECRET','334zi2YFk5lV9OzxL97pf24VX2uBGwL6PibiqANJD1qIw4uVMG');
            
                  //app callback url
    define('OAUTH_CALLBACK','http://localhost/twitter-login/callback.php');

    

    if(isset($_SESSION['acces_token'])){
      
        //non autorise par l application,montre loggin bouton
        $connection=new TwitterOAuth(CONSUMER_KEY,CONSUMER_SECRET);
        $request_token=$connection->oauth('oauth/request_token',array('oauth_callback'=>OAUTH_CALLBACK));
    
        $_SESSION['oauth_token']=$request_token['oauth_token'];
        $_SESSION['oauth_token_token_secret']=$request_token['oauth_token_secret'];
         $url=$connection->url('oauth/authorize',array('oauth_token'=>$request_token['oauth_token']));
         echo $url;
    }else{
        $acess_token=$_SESSION['acces_token'];
        $connection=new TwitterOAuth(CONSUMER_KEY,CONSUMER_SECRET,$acess_token['oauth_token'],$acess_token['oauth_token_secret']);
        $user=$connection->get("account/verify_credentials");
        echo $user->status->text;
    }

    
 
    
    
?>