<?php
namespace App\Lib;

use App\Model\Table\AsSmsHistoryTable;
use Cake\ORM\TableRegistry;

/**
 * Класс для отсылки смс
 */
class SMS {

	const URI_SEND = 'http://smsc.ru/sys/send.php';
	const URI_STATUS = 'http://smsc.ru/sys/status.php';

	const USERNAME = '';
	const PASSWORD = '';

	const MESSAGE_NO_MONEY = 'no money';
	const MESSAGE_IP_BLOCK = 'ip is blocked, http://smsc.ru/faq/99/';

	protected static $_defaultParams = [
		'login' => self::USERNAME,
		'psw' => self::PASSWORD,
		'charset' => 'utf-8',
		'fmt' => 3,
	];

	protected static $_statusInfo = [
		'-3' => [
			'status' => AsSmsHistoryTable::STATUS_FAIL,
			'status_message' => 'Сообщение не найдено',
		],
		'-1' => [
			'status' => AsSmsHistoryTable::STATUS_PROCESS,
			'status_message' => 'Ожидает отправки',
		],
		'0' => [
			'status' => AsSmsHistoryTable::STATUS_PROCESS,
			'status_message' => 'Передано оператору',
		],
		'1' => [
			'status' => AsSmsHistoryTable::STATUS_DELIVERED,
			'status_message' => 'Доставлено',
		],
		'3' => [
			'status' => AsSmsHistoryTable::STATUS_FAIL,
			'status_message' => 'Просрочено',
		],
		'20' => [
			'status' => AsSmsHistoryTable::STATUS_FAIL,
			'status_message' => 'Невозможно доставить',
		],
		'22' => [
			'status' => AsSmsHistoryTable::STATUS_FAIL,
			'status_message' => 'Неверный номер',
		],
		'23' => [
			'status' => AsSmsHistoryTable::STATUS_FAIL,
			'status_message' => 'Запрещено',
		],
		'24' => [
			'status' => AsSmsHistoryTable::STATUS_FAIL,
			'status_message' => 'Недостаточно средств',
		],
		'25' => [
			'status' => AsSmsHistoryTable::STATUS_FAIL,
			'status_message' => 'Недоступный номер',
		],
	];


	/**
	 * Берёт параметры по умолчанию и дополнительные параметры и делает из них строчку для гет-запроса
	 *
	 * @param $addParams. Массив доп параметров
	 *
	 * @return string
	 */
	protected static function _makeParams($addParams) {
		$params = array_merge(self::$_defaultParams, $addParams);
		$paramString = '';
		foreach ($params as $k => $v) {
			$paramString .= $k . '='  .urlencode($v) . '&';
		}
		return $paramString;
	}

	/**
	 * Посылает смс, пишет в таблицу результат
	 *
	 * @param string $message
	 * @param $phones string phone | array(phone1, phone2, ...) | array(['accountid' => accountid1, 'phone' => phone1], ['accountid' => accountid2, 'phone' => phone2], ...)
	 *
	 * @return void
	 */
	public static function send($message, $phones) {

		if (is_array($phones) && !empty($phones['phone'])) {
			$phones = [$phones];
		}
		$phones = array_unique((array)$phones, SORT_REGULAR);

		$goodPhones = [];
		$accounts = [];
		foreach ($phones as $phoneInfo) {
			$accountid = null;
			if (is_array($phoneInfo)) {
				if (empty($phoneInfo['phone'])) {
					continue;
				}
				$phone = $phoneInfo['phone'];
				if (!empty($phoneInfo['accountid'])) {
					$accountid = $phoneInfo['accountid'];
				}
			} else {
				$phone = $phoneInfo;
			}
			if (defined('DEBUG_PHONE')) {
				$phone = DEBUG_PHONE;
			}

			$phone = Misc::fixRussianPhone($phone);
			if (empty($phone) || in_array($phone, $goodPhones)) {
				continue;
			}
			$goodPhones[] = $phone;
			$accounts[] = $accountid;
			if (defined('DEBUG_PHONE')) {
				break;
			}
		}

		if (empty($goodPhones)) {
			return;
		}
		
		$smsData = ['mes' => $message, 'phones' => implode(',', (array)$goodPhones)];
		$apiData = array_merge(self::$_defaultParams, $smsData);
		$http = new Client();
		$response = json_decode($http->post(self::URI_SEND, $apiData)->body());


		$saveData = [];
		if (empty($response)) {
			$saveData['status_message'] = 'Некорректный ответ сервиса';
			$saveData['status'] = AsSmsHistoryTable::STATUS_FAIL;
		}
		elseif(!empty($response->error)) {
			$saveData['status_message'] = $response->error;
			$saveData['status'] = AsSmsHistoryTable::STATUS_FAIL;
		}
		else {
			$saveData['smsid'] = $response->id;
			$saveData['status'] = AsSmsHistoryTable::STATUS_PROCESS;
			$saveData['status_message'] = 'Ожидает отправки';
		}
		$saveData['message'] = $message;

		$historyTable = TableRegistry::get('AsSmsHistory');
		foreach ($goodPhones as $key => $phone) {
			$historyRecord = $historyTable->newEntity(array_merge([
				'accountid' => $accounts[$key],
				'phone' => $phone,
			], $saveData));
			$historyTable->save($historyRecord);
		}
	}


	/**
	 * Проверяет статус смс и пишет об этом в таблицу
	 *
	 * @param $historyids. Айдишка или массив айдишек из таблицы
	 *
	 * @return void
	 */
	public static function checkStatus($historyids) {
		$historyids = array_unique((array)$historyids);
		$historyTable = TableRegistry::get('AsSmsHistory');
		$records = $historyTable->find()->where(['historyid IN' => $historyids])->toArray();
		$smsids = [];
		$phones = [];
		$map = [];
		foreach ($records as $key => $record) {
			if (empty($record->smsid)) {
				continue;
			}
			$smsids[] = $record->smsid;
			$phones[] = $record->phone;
			$map[$record->smsid . $record->phone] = $key;
		}
		if (empty($phones)) {
			return;
		}
		$url = self::URI_STATUS . '?' . self::_makeParams(['id' => implode(',', $smsids) . ',', 'phone' => implode(',', $phones) . ',']);
		$http = new Client();
		$response = json_decode($http->get($url)->body());
		if (!is_array($response)) {
			return;
		}
		foreach ($response as $info) {
			if (empty($info->id) || empty($info->phone)) {
				continue;
			}

			if (!empty($info->error)) {
				$saveData = [
					'status' => AsSmsHistoryTable::STATUS_FAIL,
					'status_message' => $info->error,
				];
			} else {
				if (!empty(self::$_statusInfo[$info->status])) {
					$saveData = self::$_statusInfo[$info->status];
				} else {
					$saveData = [
						'status' => AsSmsHistoryTable::STATUS_FAIL,
						'status_message' => 'Некорректный ответ сервиса',
					];
				}
			}
			if (empty($map[$info->id . $info->phone])) {
				continue;
			}

			$recordKey = $map[$info->id . $info->phone];
			$record = $historyTable->patchEntity($records[$recordKey], $saveData);
			$historyTable->touch($record);
			$historyTable->save($record);
		}
	}
}