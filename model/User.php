<?php

class User {
	public static function login($user) {
		$_SESSION["user"] = $user;
	}

	public static function logout() {
		session_destroy();
	}

	public static function isLoggedIn() {
		return isset($_SESSION["user"]);
	}
}