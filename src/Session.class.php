<?php

class Session {

	public static function set($name, $value)
	{
		return $_SESSION["$name"] = $value;
	}

	public static function exist($name)
	{
		return (isset($_SESSION["$name"]));
	}

}