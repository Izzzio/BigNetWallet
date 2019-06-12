<?php


namespace App\Lib;

use Cake\Core\Configure;

class Http
{
	/**
	 * Экземпляр http клиента
	 *
	 * @var null
	 */
	private static $_httpClient = null;

	/**
	 * Работает по типу file_get_contents но только для url
	 *
	 * @param string $url
	 * @return string mixed
	 */
	public static function getContent($url) {
		$request = static::makeRequest();
		return static::getRequest($url, $request)->body();
	}

	/**
	 * Возвращает JSON ответ
	 *
	 * @param string $url
	 * @return array mixed
	 */
	public static function getJson($url) {
		$request = static::makeRequest();
		return static::getRequest($url, $request)->json;
	}


	/**
	 * Возвращает XML ответ
	 *
	 * @param string $url
	 * @return array mixed
	 */
	public static function getXml($url) {
		$request = static::makeRequest();
		return static::getRequest($url, $request)->xml;
	}

	/**
	 * Выполняет get запрос
	 *
	 * @param string $url
	 * @param Client $request
	 * @return mixed
	 */
	public static function getRequest($url, $request) {
		return $request->get($url);
	}

	/**
	 * Создает экземпляр клиента если нужно
	 *
	 * @return Client
	 */
	public static function makeRequest() {
		if (static::$_httpClient == null) {
			static::$_httpClient = new Client();
		}
		return static::$_httpClient;
	}

	/**
	 * Скачивает файл по указанной ссылке в targetFile или во временную директорию
	 *
	 * @param string $url
	 * @param string $targetFile
	 * @param int $timeout
	 * @return string
	 */
	public static function downloadFile($url, $targetFile = '', $timeout = 30) {

		if (empty($targetFile)) {
			$targetFile = TMP . uniqid() . '.tmp';
		}

		@$fileHandle = fopen($targetFile, 'w+');
		if (empty($fileHandle)) {
			return '';
		}

		$curlHandle = curl_init($url);

		curl_setopt($curlHandle, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($curlHandle, CURLOPT_FILE, $fileHandle);
		curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, true);
		curl_exec($curlHandle);
		$err = curl_error($curlHandle);
		curl_close($curlHandle);

		fclose($fileHandle);

		if (!empty($err)) {
			unlink($targetFile);
			return '';
		}


		return $targetFile;
	}
}