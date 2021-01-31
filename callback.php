<?php 
    session_start();
    require_once 'vendor/autoload.php';
    use Abraham\TwitterOAuth\TwitterOAuth;

    if(isset($_REQUEST['oauth_verifier'],$_REQUEST['oauth_token']) && $_REQUEST['oauth_token']==$_SESSION['oauth_token']){
        $request_token=[];
        $request_token['oauth_token']=$_SESSION['oauth_token'];
        $request_token['oauth_token_secret']=$_SESSION['oauth_token_secret'];
        $connection=new TwitterOAuth(CONSUMER_KEY,CONSUMER_SECRET,$request_token['oauth_token'],$request_token['oauth_token_secret']);
        $acess_token=$connection->oauth('oauth/acess_token',array("oauth_verifier"=>$_REQUEST['oauth_verifier']));
        $_SESSION['acess_token']=$acess_token;
        header('Location:./');
    }

?>