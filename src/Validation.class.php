<?php

class Validation extends Database {

	public static function LogIn($username, $password)
	{
		if(isset($username) && isset($password)) {

			return ($username == 'admin' && $password == 'admin') ? Session::set('user', $username) : false;

		}
	}

}