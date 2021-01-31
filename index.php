<?php
    
    session_start();
    require_once 'config.php';
    require_once 'vendor/autoload.php';
    use Abraham\TwitterOAuth\TwitterOAuth;


if(isset($_SESSION['twitter_acces_token']) && $_SESSION['twitter_acces_token']){
    //nous avons l'acces token

}elseif(isset($_GET['oauth_verifier']) && isset($_GET['oauth_token']) && isset($_SESSION['oauth_token']) && $_GET['oauth_token'] == $_SESSION['oauth_token']){
    //viens de twitter callback url
    $connection=new TwitterOAuth(CONSUMER_KEY,CONSUMER_SECRET,$_SESSION['oauth_token'],$_SESSION['oauth_token_secret']);
    $access_token=$connection->oauth('oauth/access_token',array('oauth_verifier'=>$_GET['oauth_verifier']));
    $_SESSION['twitter_acces_token']=$access_token;
    $isLoggedIn=true;
}else{
    //non autorise par l application,montre loggin bouton
    $connection=new TwitterOAuth(CONSUMER_KEY,CONSUMER_SECRET);
    $request_token=$connection->oauth('oauth/request_token',array('oauth_callback'=>OAUTH_CALLBACK));

    //on capte les tokens dans des des sseions
    $_SESSION['oauth_token']=$request_token['oauth_token'];
    $_SESSION['oauth_token_secret']=$request_token['oauth_token_secret'];


}


// on teste si session token existe
if($_SESSION['oauth_token_secret'] && $_SESSION['oauth_token']){//l'utilisateur est connecte,affichez ses informations
    $connection=new TwitterOAuth(CONSUMER_KEY,CONSUMER_SECRET, $_SESSION['twitter_acces_token']['oauth_token'],$_SESSION['twitter_acces_token']['oauth_token_secret']);
    $user=$connection->get("account/verify_credentials",['include_email'=>'true']);
    if(property_exists($user,'error')){
        //erreur de trouver les infos de l'utilisateur
        $_SESSION=array();
        header('Refresh:0');
    }else{
        //afficher les infos de l'utilisateur
        ?>
            <img src="<?php echo $user->profile_image_url ;?>">
            <br/>
            <b>Nom Complet:</b><?php echo $user->name; ?>
            <br/>
            <b>Location:</b><?php echo $user->location; ?>
            <br/>
            <b>Nom Utilisateur:</b><?php echo $user->screen_name; ?>
            <br/>
            <b>email:</b><?php echo $user->email; ?>
            <br/>
            <b>Date</b><?php echo $user->created_at; ?>


            <!-- Mwen afiche user Info sa anba se te just pou m te ka non ke propriete -->

            <!-- <h3>User Info</h3>
            <textarea style="height:400px; width:100%;" ><?php echo print_r($user,true);?></textarea> -->

        <?php
       
    }
}else{ //not logged in,display loggin with twitter link
  

   $url=$connection->url('oauth/authorize',array('oauth_token'=>$request_token['oauth_token']));
        // $url = $connection->getAuthorizeURL($request_token['oauth_token']);
    ?>
          <a href="<?php echo $url; ?>">Login with Twitter</a>
    <?php

}


?>