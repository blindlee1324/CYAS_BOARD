<?php

namespace App;

class Auth {
	
	/*
		@param array $user
		@return boolean
	*/
	public static function confirmUser($user) {
		if($user['password'] == $_SESSION['csrfToken']) {
			return true;
		}
		else {
			return false;
		}
	}
}