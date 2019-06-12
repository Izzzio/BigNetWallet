<?php
namespace App\Lib;

/**
 * Информация о текущем пользователе.
 */
class CurrentUser {

	const DEFAULT_USER_DATA = ['id' => 0];

	/**
	 * Информация о текущем пользователе
	 *
	 * @var array
	 */
	protected static $_currentUserData = self::DEFAULT_USER_DATA;


	/**
	 * Задаёт информацио о пользователе
	 *
	 * @param array $currentUserData
	 *
	 * @return void
	 */
	public static function set($currentUserData) {
		self::$_currentUserData = $currentUserData;
	}

	/**
	 * Возвращает информацию об авторизованном пользователе.
	 *
	 * @param string|null $param. Что вернуть. Если пуст, то вернёт всё.
	 *
	 * @return mixed
	 */
	public static function get($param = null) {
		$user = self::DEFAULT_USER_DATA;
		if (!empty(self::$_currentUserData)) {
			$user = self::$_currentUserData;
		} elseif (!empty($_SESSION['cake_user'])) {
			$user = $_SESSION['cake_user'];
		}
		if (empty($param)) {
			return $user;
		}
		return (array_key_exists($param, $user) ? $user[$param] : null);
	}


}