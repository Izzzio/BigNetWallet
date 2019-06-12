<?php
namespace App\View\Helper;

use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\View\Helper;

class AssetHelper extends Helper {

	const KEY_SCRIPT = 'script';
	const KEY_STYLE = 'style';
	const KEY_DEPEND = 'depend';
	/**
	 * обязательные переменные
	 */
	const KEY_VARS = 'vars';
	/**
	 * Скрипт в <head> или внизу <body>
	 */
	const KEY_IS_BOTTOM = 'isBottom';

	const TYPE_NUM = 'num';
	const TYPE_STRING = 'string';
	const TYPE_BOOL = 'bool';
	const TYPE_JSON = 'json';

	const BLOCK_SCRIPT_BOTTOM = 'scriptBottom';
	const BLOCK_SCRIPT = 'script';
	const BLOCK_STYLE = 'css';

	const DEFAULT_PARAMS = [
		'controller' => 'pages',
		'action' => 'index',
	];

	const DEFAULT_PATH_PARTS = [
		self::KEY_STYLE => [
			'folder' => 'css',
			'extension' => 'css',
		],
		self::KEY_SCRIPT => [
			'folder' => 'js',
			'extension' => 'js',
		],
	];

	/**
	 * При явном указании путей они должны начинаться с папок assets, css или js, без слеша в начале
	 * URL_PREFIX и CORE_VERSION проставятся автоматически
	 * Если нужны только дефолтные скрипт и стиль, то можно ничего в конфиге не прописывать
	 * [
	 * 	controllerName => [							// camelCase
	 * 		actionName => [							// camelCase
	 * 			self::KEY_SCRIPT => path_to_script,	// необязательно, по умолчанию возьмётся ControllerName/action_name
	 * 			self::KEY_STYLE => path_to_style,	// необязательно, по умолчанию возьмётся ControllerName/action_name
	 * 			self::KEY_IS_BOTTOM => false,		// необязательно, по умолчанию false, т.е. скрипт в <head>
	 * 			self::KEY_DEPEND => [
	 * 				'controllerName1.actionName1',
	 * 				'controllerName1.actionName2',
	 * 				'controllerName2.actionName3',
	 * 			]
	 * 			self::KEY_VARS => [					// если переменные должны быть обязательно объявлены + проверка типа
	 * 				'varName' => 'varType',
	 * 				'varName2' => 'varType2',
	 * 			],
	 * 		],
	 *  ],
	 * ]
	 */
	const CONFIG = [
		'assets' => [								// для ассетов
			'qtip2' => [
				self::KEY_SCRIPT => 'assets/plugins/qtip2/jquery.qtip.min.js',
				self::KEY_STYLE => 'assets/plugins/qtip2/jquery.qtip.min.css',
			],
			'jstree' => [
				self::KEY_SCRIPT => 'assets/plugins/jstree/jstree.min.js',
				self::KEY_STYLE => 'assets/plugins/jstree/themes/default/style.min.css',
			],
			'rangeSlider' => [
				self::KEY_SCRIPT => 'assets/plugins/ion.rangeslider/js/ion-rangeSlider/ion.rangeSlider.min.js',
				self::KEY_STYLE => [
					'assets/plugins/ion.rangeslider/css/ion.rangeSlider.css',
					'assets/plugins/ion.rangeslider/css/ion.rangeSlider.skinModern.css',
				],
			],
			'formWizard' => [
				self::KEY_SCRIPT => 'assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js',
			],
		],
		'lib' => [									// для наших либ
			'dateChange' => [
				self::KEY_VARS => [
					'filterDate' => self::TYPE_STRING,
					'urlPath' => self::TYPE_STRING,
					//mindate string|null, не обязательная
				],
			],
		],
		'test' => [									// для тестов этого хелпера
			'empty' => [],
			'isDependent' => [
				self::KEY_DEPEND => [
					'test.dependency1',
					'test.dependency2',
				],
			],
			'dependency1' => [
				self::KEY_DEPEND => [
					'test.dependency2',
				],
			],
			'dependency2' => [
			],
			'isDependent2' => [
				self::KEY_IS_BOTTOM => true,
				self::KEY_DEPEND => [
					'test.dependency1',
					'test.dependency3',
				],
			],
			'dependency3' => [
			],
			'manualExists' => [
				self::KEY_SCRIPT => 'js/TestManual/file_manual.js',
				self::KEY_STYLE => 'css/TestManual/file_manual.css',
			],
			'manualNotExists' => [
				self::KEY_SCRIPT => 'js/TestManual/notExists.js',
				self::KEY_STYLE => 'css/TestManual/notExists.css',
			],
			'autoNotExists' => [],
			'fromParams' => [
				self::KEY_VARS => [
					'testLoad' => self::TYPE_STRING,
				],
			],
			'vars' => [
				self::KEY_VARS => [
					'var1' => self::TYPE_STRING,
					'var2' => self::TYPE_BOOL,
				],
				self::KEY_DEPEND => [
					'test.varsDuplicate',
				],
			],
			'varsDuplicate' => [
				self::KEY_VARS => [
					'var2' => self::TYPE_BOOL,
					'var3' => self::TYPE_NUM,
				],
			],
			'varsDuplicate2' => [
				self::KEY_VARS => [
					'var2' => self::TYPE_BOOL,
					'var4' => self::TYPE_NUM,
				],
			],
			'varsConflict' => [
				self::KEY_VARS => [
					'var2' => self::TYPE_JSON,
					'var5' => self::TYPE_NUM,
				],
			],
			'varsUndefined' => [
				self::KEY_VARS => [
					'var6' => self::TYPE_NUM,
				],
			],
			'varsWrongType' => [
				self::KEY_VARS => [
					'var7' => self::TYPE_NUM,
				],
			],
		],
		'logistics' => [
			'assignment' => [
				self::KEY_DEPEND => [
					'assets.qtip2', 'assets.jstree', 'lib.dateChange'
				],
				self::KEY_VARS => [
					'deliveries' => self::TYPE_JSON,
					'assignment' => self::TYPE_JSON,
					'types' => self::TYPE_JSON,
					'weights' => self::TYPE_JSON,
					'courierList' => self::TYPE_JSON,
					'subway' => self::TYPE_JSON,
					'icons' => self::TYPE_JSON,
				],
			],
		],
		'pages' => [
			'home' => [
				self::KEY_DEPEND => [
					'lib.likeForLike',
					'assets.rangeSlider'
				],
			],
			'likeForLike' => [
				self::KEY_DEPEND => [
					'lib.likeForLike',
				],
			],
		],
		'orders' => [
			'happy' => [
				self::KEY_DEPEND => [
					'lib.addOrderItems',
					'assets.formWizard',
				],
			],
		],
		'waste' => [
			'index' => [
				self::KEY_DEPEND => [
					'lib.autocomplete',
				]
			]
		]
	];




	/**
	 * Загруженные скрипты/стили
	 *
	 * @var array
	 */
	private $_loadedAssets = [];

	/**
	 * Текущие скрипты/стили
	 *
	 * @var array
	 */
	private $_newAssets = [];




	/**
	 * Загруженные переменные
	 *
	 * @var array
	 */
	private $_loadedVariables = [];

	/**
	 * Обязательные для текущго набора скриптов переменные
	 *
	 * @var array
	 */
	private $_newVariables = [];



	/**
	 * Объявленные для текущго набора скриптов переменные
	 *
	 * @var array
	 */
	private $_definedVariables = [];


	/**
	 * Результат. Массив тегов по блокам
	 *
	 * @var array
	 */
	private $_result = [
		self::BLOCK_SCRIPT => [],
		self::BLOCK_SCRIPT_BOTTOM => [],
		self::BLOCK_STYLE => [],
	];


	/**
	 * Добавление скриптов и стилей на страницу
	 *
	 * @param null|string $controller по умолчанию из request
	 * @param null|string $action по умолчанию из request
	 * @throws \Exception если была какая-то ошибка
	 */
	public function load($controller = null, $action = null) {
		$controller = $this->_getParam($controller, 'controller');
		$action = $this->_getParam($action, 'action');
		try {
			$this->_loadAsset("$controller.$action");
			$this->_render();
			$this->_finish(true);
		} catch(\Exception $e) {
			$this->_finish(false);
			throw $e;
		}
	}

	/**
	 * Возвращает camelCase параметр. Если не задан, то дефолтный
	 *
	 * @param string $value
	 * @param string $name
	 * @return string
	 */
	private function _getParam($value, $name) {
		if (empty($value)) {
			$value = $this->request->param($name);
		}
		if (empty($value)) {
			$value = self::DEFAULT_PARAMS[$name];
		}
		return Inflector::variable($value);
	}

	/**
	 * Загрузка ассета со всеми зависимостями, переменными и проверками
	 *
	 * @param string $assetName
	 */
	private function _loadAsset($assetName) {
		if (in_array($assetName, $this->_loadedAssets) || in_array($assetName, $this->_newAssets)) {
			return;
		}
		$this->_loadDependencies($assetName);
		$this->_loadVariables($assetName);
		$this->_newAssets[] = $assetName;
	}

	/**
	 * Загрузка зависимостей
	 *
	 * @param string $assetName
	 */
	private function _loadDependencies($assetName) {
		$dependencies = Hash::extract(self::CONFIG, $assetName . '.' . self::KEY_DEPEND);
		if (empty($dependencies)) {
			return;
		}
		foreach ($dependencies as $dependency) {
			$this->_loadAsset($dependency);
		}
	}

	/**
	 * Загрузка переменных
	 *
	 * @param string $assetName
	 * @throws \Exception если одна переменная объявлена в нескольких ассетах с разными типами
	 */
	private function _loadVariables($assetName) {
		$variables = Hash::extract(self::CONFIG, $assetName . '.' . self::KEY_VARS);
		if (empty($variables)) {
			return;
		}
		foreach ($variables as $varName => $varType) {
			$existingVarType = $this->_existingVarType($varName, false);
			if (empty($existingVarType)) {
				$this->_newVariables[$varName] = $varType;
			} elseif ($existingVarType != $varType) {
				throw new \Exception("Конфликт переменных: $varName с типами $varType и $existingVarType");
			}
		}
	}

	/**
	 * Если переменная уже объявлена, то возвращает её тип, иначе null
	 *
	 * @param string $varName
	 * @param bool $actual - смотреть формальные или фактические
	 * @return null|string
	 */
	private function _existingVarType($varName, $actual) {
		if (!empty($this->_loadedVariables[$varName])) {
			return $this->_loadedVariables[$varName];
		}
		if ($actual) {
			return (empty($this->_definedVariables[$varName]) ? null : $this->_getVarType($this->_definedVariables[$varName]));
		} else {
			return (empty($this->_newVariables[$varName]) ? null : $this->_newVariables[$varName]);
		}
	}


	/**
	 * Вывод на страницу
	 */
	private function _render() {
		$this->_renderVars();
		$this->_renderAssets();
	}

	/**
	 * Вывод переменных
	 *
	 * @throws \Exception если какие-то переменные не определены или определены неправильно
	 */
	private function _renderVars() {
		$undefinedRequiredVars = array_diff_key($this->_newVariables, $this->_definedVariables);
		if (!empty($undefinedRequiredVars)) {
			throw new \Exception('Не определены обязательные переменные: ' . implode(', ', array_keys($undefinedRequiredVars)));
		}
		if (empty($this->_definedVariables)) {
			return;
		}
		$statements = [];
		foreach ($this->_definedVariables as $varName => $varValue) {
			$expectedType = (empty($this->_newVariables[$varName]) ? null : $this->_newVariables[$varName]);
			$actualType = $this->_getVarType($varValue);
			if (!empty($expectedType) && ($expectedType !== $actualType)) {
				throw new \Exception("$varName должна иметь тип $expectedType, а не $actualType");
			}
			$value = $this->_makeValue($varValue, $actualType);
			$statements[] = "$varName = $value;";
		}
		$html = "<script>\n " . implode("\n ", $statements) . "\n</script>";
		$this->_result[self::BLOCK_SCRIPT][] = $html;
	}

	/**
	 * Формирует значение в соответствии с типом
	 *
	 * @param mixed $value
	 * @param string|null $type
	 * @return string
	 */
	private function _makeValue($value, $type) {
		switch ($type) {
			case self::TYPE_BOOL:
				$value = ($value ? 'true' : 'false');
				break;
			case self::TYPE_NUM:
				// так и остаётся
				break;
			case self::TYPE_STRING:
				$value = "'" . addslashes($value) . "'";
				break;
			case self::TYPE_JSON:
				$value = json_encode($value, JSON_UNESCAPED_UNICODE);
				break;
			default:
				$value = 'null';
				break;
		}
		return $value;
	}

	/**
	 * Вывод скриптов и стилей
	 */
	private function _renderAssets() {
		foreach ($this->_newAssets as $assetName) {
			$scriptPath = $this->_getPath($assetName, self::KEY_SCRIPT);
			if (!empty($scriptPath)) {
				$isBottom = Hash::extract(self::CONFIG, $assetName . '.' . self::KEY_IS_BOTTOM);
				$html = $this->_View->Html->script($scriptPath);
				$block = (empty($isBottom) ? self::BLOCK_SCRIPT : self::BLOCK_SCRIPT_BOTTOM);
				$this->_result[$block][] = $html;
			}

			$stylePath = $this->_getPath($assetName, self::KEY_STYLE);
			if (!empty($stylePath)) {
				$html = $this->_View->Html->css($stylePath);
				$this->_result[self::BLOCK_STYLE][] = $html;
			}
		}
	}

	/**
	 * Возвращает путь к файлу скрипта или стиля
	 *
	 * @param string $assetName
	 * @param string $type скрипт или стиль
	 * @return string
	 * @throws \Exception если файл явно указан, а его нет
	 */
	private function _getPath($assetName, $type) {
		$paths = Hash::extract(self::CONFIG, $assetName . '.' . $type);
		if (!empty($paths)) {
			$finalPaths = [];
			foreach($paths as $path) {
				if (!file_exists(WWW_ROOT . $path)) {
					throw new \Exception("Прописанного файла $path не существует");
				}
				$finalPaths[] = '/' . $path . '?v=' . CORE_VERSION;
			}
			return $finalPaths;
		}

		$pathParts = self::DEFAULT_PATH_PARTS[$type];
		list($controller, $action) = explode('.', $assetName);
		$fileName = $pathParts['folder'] . '/' . Inflector::camelize($controller) . '/' . Inflector::delimit($action) . '.' . $pathParts['extension'];
		if (file_exists(WWW_ROOT . $fileName)) {
			return ('/' . $fileName . '?v=' . CORE_VERSION);
		}
		return '';
	}


	/**
	 * Задание значений переменных
	 *
	 * @param array $variables [название => значение]
	 * проставление кавычек строкам и json_encode() массивов сделаются автоматически, передавать сюда такое не нужно!!!
	 * и по названиям переменных пройдутся preg_match и инфлектор, чтоб туда не попадало говно
	 *
	 * @param bool|array $overwrite можно ли перезаписать переменные, если они уже определены.
	 * bool сразу для всех, массив - для каждого по отдельности
	 *
	 * @throws \Exception если переданы неправильные параметры
	 * или при попытке переопределить переменную, когда это не разрешено
	 */
	public function set($variables, $overwrite = false) {
		if (!is_array($variables)) {
			throw new \Exception('Переменные должны быть массивом [название => значение]');
		}
		foreach ($variables as $varName => $varValue) {
			$varName = $this->_validVarName($varName);
			$existingVarType = $this->_existingVarType($varName, true);
			if (empty($existingVarType)) {
				$this->_definedVariables[$varName] = $varValue;
			} else {
				$canOverwrite = (is_array($overwrite) ? !empty($overwrite[$varName]) : $overwrite);
				if (!$canOverwrite) {
					throw new \Exception("Не разрешено переопределять $varName");
				}
				$newVarType = $this->_getVarType($varValue);
				if (empty($existingVarType) || ($existingVarType == $newVarType)) {
					$this->_definedVariables[$varName] = $varValue;
				} else {
					throw new \Exception("Попытка переопределить $varName из типа $existingVarType в $newVarType");
				}
			}
		}
	}


	/**
	 * Проверка, что такое имя можно задать, и приведение его к camelCase
	 *
	 * @param string $varName
	 * @return string
	 * @throws \Exception если имя - не строка или там полнейшее говно
	 */
	private function _validVarName($varName) {
		if (!is_string($varName)) {
			throw new \Exception('Название переменной должно быть строкой');
		}
		if (preg_match('/([^\w\d_]|[а-яё]|^[\d_])/ui', $varName)) {
			throw new \Exception("Невалидное название переменной '$varName'");
		}
		$validName = Inflector::variable($varName);
		return $validName;
	}

	/**
	 * Возвращает строковое название типа переменной. Если тип null, то возвращает null
	 *
	 * @param mixed $value
	 * @return null|string
	 */
	private function _getVarType($value) {
		if (is_null($value)) {
			return null;
		}elseif (is_bool($value)) {
			return self::TYPE_BOOL;
		} elseif (is_numeric($value)) {
			return self::TYPE_NUM;
		} elseif (is_string($value)) {
			return self::TYPE_STRING;
		} else {
			return self::TYPE_JSON;
		}
	}

	/**
	 * Возвращает сгенерированные теги
	 *
	 * @param null|string $block
	 * @return array
	 */
	public function fetchResult($block = null) {
		if (!empty($block)) {
			if (!empty($this->_result[$block])) {
				$result = $this->_result[$block];
				$this->_result[$block] = [];
			} else {
				$result = [];
			}
		} else {
			$result = $this->_result;
			$this->_result = [
				self::BLOCK_SCRIPT => [],
				self::BLOCK_SCRIPT_BOTTOM => [],
				self::BLOCK_STYLE => [],
			];
		}
		return $result;
	}

	/**
	 * Добавление результата и обновление значений свойств
	 *
	 * @param bool $appendResult
	 */
	private function _finish($appendResult) {
		if ($appendResult) {
			if (!defined('TEST_MODE')) {
				$result = $this->fetchResult();
				foreach ($result as $block => $tags) {
					foreach ($tags as $tag) {
						$this->_View->append($block, $tag);
					}
				}
			}
			$this->_definedVariables = array_diff_key($this->_definedVariables, $this->_newVariables);
			foreach ($this->_definedVariables as $varName => $value) {
				$this->_loadedVariables[$varName] = $this->_getVarType($value);
			}
			$this->_loadedVariables = array_merge($this->_loadedVariables, $this->_newVariables);
			$this->_loadedAssets = array_merge($this->_loadedAssets, $this->_newAssets);
		} else {
			$this->fetchResult();
		}
		$this->_newAssets = [];
		$this->_newVariables = [];
		$this->_definedVariables = [];
	}
}