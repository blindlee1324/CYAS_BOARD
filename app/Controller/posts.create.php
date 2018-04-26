<?php

require_once($_SERVER['DOCUMENT_ROOT'].'vendor/autoload.php');

use App\User;
use App\Auth;
use App\Post;

session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$title = $_POST['title'];
	$content = $_POST['content'];
	
	// title validation
	if(empty($title)) {
		$_SESSION['t_valid'] = 'TITLE IS NECESSARY!';
		$_SESSION['content'] = $content;
		header('Location: /write.php');
	} else {	
		$user = User::findWithId(intval($_SESSION['id']));
		// authentication
		if(Auth::confirmUser($user)) {
			$title = htmlspecialchars($title); // prevent html tag
			Post::create($user, $title, $content);
			header('Location: /');
		} else {
			session_close();
			header('Location: /');
		}
	}
	
} else {
	// invalid request
	header('Location: /');
}