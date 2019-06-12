<?php


namespace App\Lib;

use Cake\Core\Configure;
use Cake\Log\Log;

class Client extends \Cake\Network\Http\Client
{
	const CUSTOM_ADAPTER_CONFIGURE_NAME = 'httpClientAdapter';

	/**
	 * Client constructor.
	 *
	 * @param array $config
	 */
	public function __construct($config = ['redirect' => 2]) {
		// возможность глобального переопределения адаптора отправки запросов
		$adapter = Configure::check(self::CUSTOM_ADAPTER_CONFIGURE_NAME);
		if ($adapter !== false) {
			$config['adapter'] = Configure::read(self::CUSTOM_ADAPTER_CONFIGURE_NAME);
		}

		parent::__construct($config);
	}

	/**
	 * @inheritdoc
	 * Обернул в try/catch для, дабы чтобы код не валилися
	 */
	protected function _doRequest($method, $url, $data, $options) {
		try {
			$result = parent::_doRequest($method, $url, $data, $options);
			return $result;
		} catch (\Exception $error) {
			Log::error($error->getMessage() . $error->getTraceAsString());
			return false;
		}
	}
}