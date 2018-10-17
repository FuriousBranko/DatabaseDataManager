<?php

class Validation extends Database {

	public static function LogIn($username, $password)
	{
		if($username == 'admin' && $password == 'admin') {
			return Session::set('user', $username);
		} elseif ($username == 'guest' && $password == 'guest') {
			return Session::set('user', $username);
		} else {
			return false;
		}
	}

	public static function isLoggedIn()
	{
		return (Session::exist('user'));
	}

}