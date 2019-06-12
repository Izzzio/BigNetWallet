<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class AutocompleteComponent extends Component
{

	const DEFAULT_LIMIT = 10;
	const DEFAULT_MIN_LENGTH = 3;

	/**
	 * Конфиг вида:
	 * (тут проставлены дефолтные значения)
	 * [
	 * 		'minLength' => 3,					// минимальная длина поискового запроса
	 * 		'model' => '', 						// обязательно заполнить
	 * 		'keyField' => key, 					// поле таблицы, значение которого попадёт на форму
	 * 		'searchFields' => [keyField],		// поля, по которым проводить поиск
	 * 		'showFields' => [searchFields],		// поля, которые будут выводиться на форме
	 * 		'contain' => [],
	 * 		'where' => [],
	 * 		'order' => [],
	 * 		'limit' => 10,
	 * 	]
	 * @inheritdoc
	 * @throws \Exception если пустое поле или в конфиге не указана модель или поле уже добавлено
	 */
	public function config($key = null, $value = null, $merge = true) {
		$currentValue = parent::config($key);
		if (empty($value)) {
			return $currentValue;
		}

		if (empty($key) || empty($value['model'])) {
			throw new \Exception('Не задано название поля или модель у автокомплита');
		}
		if (!empty($currentValue)) {
			throw new \Exception('Поле ' . $key . ' уже добавлено');
		}

		$defaultConf = [
			'minLength' => self::DEFAULT_MIN_LENGTH,
			'limit' => self::DEFAULT_LIMIT,
			'keyField' => $key,
		];
		$value = array_replace($defaultConf, $value);

		if (empty($value['searchFields'])) {
			$value['searchFields'] = $value['keyField'];
		}
		if (empty($value['showFields'])) {
			$value['showFields'] = $value['searchFields'];
		} else {
			$value['showFields'] = array_unique(array_merge($value['searchFields'], $value['showFields']));
		}

		return parent::config($key, $value, false);
	}

	/**
	 * Поиск
	 * @param string $key
	 * @param string $term
	 * @return array
	 */
	public function suggest($key, $term) {
		$conf = parent::config($key);
		if (empty($conf)) {
			return [];
		}

		$terms = explode('|', $term);
		array_unshift($terms, $term);
		$terms = array_unique($terms);

		$minLength = $conf['minLength'];
		$terms = array_filter($terms, function($term) use($minLength) {return (mb_strlen(trim($term)) >= $minLength);});

		if (empty($terms)) {
			return [];
		}

		$query = TableRegistry::get($conf['model'])->find('list', ['keyField' => $conf['keyField'], 'valueField' => 'title']);

		$title = 'concat(' . implode(", ' ', ", $conf['showFields']) . ')';
		$query->select([($conf['model'] . '.' . $conf['keyField']), 'title' => $query->newExpr($title)]);

		foreach (['contain', 'where', 'order', 'limit'] as $queryMethod) {
			if (!empty($conf[$queryMethod])) {
				$query->{$queryMethod}($conf[$queryMethod]);
			}
		}

		$searchConditions = [];
		$fieldTypes = [];
		foreach ($conf['searchFields'] as $fieldName) {
			$fieldTypes[$fieldName] = 'string';
			foreach ($terms as $term) {
				$searchConditions[] = [
					($fieldName . ' LIKE') => '%' . trim($term) . '%',
				];
			}
		}

		$query->where([
			'OR' => $searchConditions,
		], $fieldTypes);

		$res = [];
		$queryRes = $query->toArray();
		foreach ($queryRes as $key => $value) {
			$res[] = ['id' => $key, 'text' => $value];
		}
		return $res;
	}

}