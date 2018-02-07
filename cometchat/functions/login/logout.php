<?php
$config = dirname(__FILE__) . '/config.php';
require_once( "Social/Auth.php" );

try{
	$socialAuth = new Social_Auth($config);

	if($socialAuth->getNetwork() == 'facebook'){
		$logoutURL = 'https://www.facebook.com/logout.php?next='.urlencode($_SERVER['HTTP_REFERER']).'&access_token='.urlencode($_SESSION['cometchat']['sa_fb_access_token']);
	}elseif($socialAuth->getNetwork() == 'google'){
		$logoutURL = 'https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue='.urlencode($_SERVER['HTTP_REFERER']);
	}
	elseif($socialAuth->getNetwork() == 'twitter'){
		$logoutURL = 'twitter';
	}else{
        $logoutURL = '';
    }

    Social_Auth::session()->deleteByKey( "SA_USER" );
    $socialAuth->logout();

    @session_start();
    unset($_SESSION['cometchat']);
    unset($_SESSION['basedata']);

    if(!empty($_GET['callback'])){
        echo $_GET['callback'].'('.json_encode(array('logoutURL'=>$logoutURL)).')';
    }else{
        echo json_encode(array('logoutURL'=>$logoutURL));
    }
} catch( Exception $ex ) {
    echo "Error occured: " . $ex->getMessage();
}
