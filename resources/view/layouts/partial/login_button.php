<?php
use Shucream0117\TwitCastingOAuth\GrantFlow\AuthCodeGrant;
use Shucream0117\TwitCastingOAuth\ApiExecutor\AppExecutor;
use Shucream0117\TwitCastingOAuth\ApiExecutor\UserExecutor;
use Shucream0117\TwitCastingOAuth\Entities\AccessToken;
use App\User;
session_start();
if(!isset($_SESSION['id'])) {
	// $cId, $cSecret, $callbackURL required
	require_once($_SERVER["DOCUMENT_ROOT"].'/config/config.php');
	
	$grant = new AuthCodeGrant($cId, $cSecret, $callbackURL);
	if(!isset($_GET['code'])) {
		if(empty($_SESSION['csrfToken'])) {
			$_SESSION['csrfToken'] = bin2hex(random_bytes(32));
		}
		
		$csrfToken = $_SESSION['csrfToken'];
		
		$url = $grant->getConfirmPageUrl($csrfToken);
		
		// print URL link button on nav bar
		print_r('<a href="'.$url.'">Login</a>');
	} elseif(empty($_GET['state']) || (isset($_SESSION['csrfToken']) && $_GET['state'] !== $_SESSION['csrfToken'])) {
		
		if(isset($_SESSION['csrfToken'])) {
			unset($_SESSION['csrfToken']);
		}
		
		exit('Invalid state');
	} else {
		$state = $_GET['state'] ?? null;
		$code = $_GET['code'] ?? null;
		$accessToken = $grant->requestAccessToken($code, new AppExecutor($cId, $cSecret));
		$executor = new UserExecutor($accessToken);
		$response = $executor->get("verify_credentials");
		$userInfo = json_decode($response->getBody()->getContents(), true);
		
		if(empty(User::findWithId($userInfo["user"]["id"]))) {
			User::insert((int)$userInfo["user"]["id"], $userInfo["user"]["screen_id"], $userInfo["user"]["name"], $userInfo["user"]["image"], $userInfo["user"]["profile"]);
		} 
		
		// for Authentication
		User::setPassword($userInfo["user"]["id"], $_SESSION['csrfToken']);
		$_SESSION['id'] = $userInfo["user"]["id"];
		
		header('Location: /');
	}
	// Login Session
} else {
	$result = User::findWithId($_SESSION['id']);
	
	// print name and screen_id on nav bar
	print_r('<a class="disabled">'.$result['name'].' (@'.$result['screen_id'].')</a>');
}