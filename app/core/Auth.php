<?php

class Auth{

	public static function auth(){
		return (object)[
			"name" => "Lorem",
			"role" => "CTR"
		];
	}

	public static function oauth(string $role) {
		$userRole = self::auth()->role;

		if($userRole != $role){
			return "false";
		}
	}
}