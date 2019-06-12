<?php

namespace App\Controller\Component;

use App\Controller\AppController;
use App\Lib\Traits\Library;
use App\Model\Table\VtigerAccountTable;
use App\Model\Table\VtigerCampaignTable;
use App\Model\Table\VtigerSalesordercfTable;
use App\Model\Table\VtigerSalesorderTable;
use Cake\Controller\Component;
use Cake\I18n\Time;
use Cake\Utility\Inflector;
use Cake\Utility\Text;

/**
 * Class LikeForLike
 * Класс для удобной работы с графами
 *
 * @package App\Controller
 */
class LikeForLikeComponent extends Component
{
	const WORKDAY_EXPECTED_ORDERS = 15;
	const WORKDAY_EXPECTED_MONEY = 40;
	const WEEKEND_EXPECTED_ORDERS = 6;
	const WEEKEND_EXPECTED_MONEY = 15;

	const ALG_HISTORY = 'history';
	const ALG_FIXED = 'fixed';

	const OVERALL_GRAPH_NAME = 'Общая статистика'; // при изменении изменить латинскую версию именю в Pages/home.js
	const WHOLESALE_GRAPH_NAME = 'По оптовым заказам';
	const BIG_T_GRAPH_NAME = 'Большой T';

	/**
	 * Контроллер
	 *
	 * @var AppController
	 */
	private $_controller = null;

	/**
	 * Ассоциативный массив со всеми графами для LikeForLike
	 *
	 * @var array
	 */
	private $_graphs = [];

	/**
	 * Координаты x-оси на графе
	 *
	 * @var array
	 */
	private $_ticks = [];

	/**
	 * Первый день для графика текущих продаж
	 *
	 * @var Time|null
	 */
	private $_newFrom = null;

	/**
	 * Последний день для графика текущих продаж
	 *
	 * @var Time|null
	 */
	private $_newTo = null;

	/**
	 * Первый день для графика прошлогодних продаж
	 *
	 * @var Time|null
	 */
	private $_oldFrom = null;

	/**
	 * Последний день для графика прошлогодних продаж
	 *
	 * @var Time|null
	 */
	private $_oldTo = null;

	/**
	 * Разница в днях между соответствующими днями недели этого и прошлого годов
	 *
	 * @var int
	 */
	private $_weekdayOffset = 0;

	/**
	 * Может ли текущий пользователь видеть информацию о доходах компании
	 *
	 * @var bool
	 */
	private $_canViewIncome = false;

	/**
	 * Геттер для графов
	 *
	 * @return array
	 */
	public function getGraphs() {
		return $this->_graphs;
	}

	/**
	 * Добавляет граф
	 *
	 * @param string $graphName
	 * @param array $graph
	 */
	public function addGraph($graphName, $graph) {
		$this->_graphs[$graphName] = $graph;
	}

	/**
	 * @inheritdoc
	 */
	public function initialize(array $config) {
		parent::initialize($config);
		$this->_controller = $this->_registry->getController();
		$this->_canViewIncome = $config['canViewIncome'];
		list($this->_newFrom, $this->_newTo, $this->_oldFrom, $this->_oldTo, $this->_weekdayOffset) = $this->getBorderDays($config['dateFrom'], $config['dateTo']);
	}

	/**
	 * Возвращает 4 даты:
	 *    1) Первый день для графика текущих продаж
	 *    2) Последний  день для графика текущих
	 *    3) Первый день для графика прошлогодних продаж
	 *    4) Последний  день для графика прошлогодних продаж
	 * и разницу в секундах смещения соотвествующего дня недели в текущем и прошлом годах
	 * (1 день для невисокосного, 2 дня для високосного)
	 *
	 * @param string|null $dateTo
	 * @param string|null $dateFrom
	 * @return array
	 */
	public function getBorderDays($dateFrom, $dateTo) {
		$day = new Time($dateTo ? $dateTo : 'today');
		$tomorrow = $day->copy()->addDay();
		$last2Weeks = $tomorrow->copy()->subWeeks(2);
		$lastSeveralDays = $dateFrom ? new Time($dateFrom) : $last2Weeks;

		$period = $tomorrow->diffInDays($lastSeveralDays);

		$weekDayOffset = 1;
		$lastYearTime = $tomorrow->copy()->subYear()->addDay();
		if ($lastYearTime->format('D') != $tomorrow->format('D')) // високосный год
		{
			$weekDayOffset = 2;
			$lastYearTime->addDay();
		}
		$lastYearSeveralDays = $lastYearTime->copy()->subDays($period);
		return [$lastSeveralDays, $tomorrow, $lastYearSeveralDays, $lastYearTime, $weekDayOffset * DAY];
	}

	/**
	 * Графики сравнения текущих и прошлогодних доходов
	 * и отправляет их во вьюху
	 *
	 * @param bool $isFull
	 */
	public function widget($isFull = false) {
		$contain = [
			'VtigerCrmentity',
			'VtigerSalesordercf',
		];

		$conditions = [
			'VtigerCrmentity.deleted' => 0,
			'VtigerCrmentity.createdtime >=' => $this->_newFrom,
			'VtigerCrmentity.createdtime <' => $this->_newTo,
			'VtigerSalesordercf.' . VtigerSalesorderTable::CF_PAYMENT_TYPE . ' <>' => VtigerSalesorderTable::PAYMENT_TYPE_NO,
			'not' => [
				'VtigerSalesorder.sostatus' => VtigerSalesorderTable::STATUS_CANCELLED,
				'VtigerSalesordercf.' . VtigerSalesorderTable::CF_COMMENT => VtigerSalesordercfTable::COMMENT_DOUBLE
			],
		];

		$lastYearConditions = $conditions;
		$lastYearConditions['VtigerCrmentity.createdtime >='] = $this->_oldFrom;
		$lastYearConditions['VtigerCrmentity.createdtime <'] = $this->_oldTo;

		$this->_generateGraphs($conditions, $lastYearConditions, $contain, self::OVERALL_GRAPH_NAME);

		if (!$isFull) {
			return;
		}

		// Оптовые заказы
		$conditionsWholesale = $conditions;
		$lastYearConditionsWholesale = $lastYearConditions;
		$conditionsWholesale['VtigerSalesordercf.' . VtigerSalesorderTable::CF_IS_WHOLESALE] = 1;
		$lastYearConditionsWholesale['VtigerSalesordercf.' . VtigerSalesorderTable::CF_IS_WHOLESALE] = 1;

		$this->_generateGraphs($conditionsWholesale, $lastYearConditionsWholesale, $contain, self::WHOLESALE_GRAPH_NAME);


		// По отдельности магазины в магазине
		$this->_controller->loadModel('VtigerCampaign');
		$shops = $this->_controller->VtigerCampaign->find()
			->select([
				'campaignid',
				'campaignname',
			])
			->where([
				'campaigntype' => VtigerCampaignTable::TYPE_SHOP,
				'campaignstatus' => VtigerCampaignTable::STATUS_ACTIVE,
				'campaignid NOT IN' => VtigerCampaignTable::ID_TEST_SHOPS,
				'VtigerCrmentity.deleted' => 0,
			])
			->contain([
				'VtigerCrmentity',
			]);

		foreach ($shops as $shop) {
			$conditionsShop = $conditions;
			$lastYearConditionsShop = $lastYearConditions;

			$conditionsShop[] = 'campaignid IS NOT NULL';
			$conditionsShop['campaignid'] = $shop->campaignid;

			$lastYearConditionsShop[] = 'campaignid IS NOT NULL';
			$lastYearConditionsShop['campaignid'] = $shop->campaignid;

			$this->_generateGraphs($conditionsShop, $lastYearConditionsShop, $contain, $shop->campaignname,
				[
					'alg' => self::ALG_FIXED,
					'weekday' => (int)$this->_newFrom->format('N') - 1,
					'workdayProfit' => self::WORKDAY_EXPECTED_ORDERS,
					'workdayMoneyProfit' => self::WORKDAY_EXPECTED_MONEY,
					'weekendProfit' => self::WEEKEND_EXPECTED_ORDERS,
					'weekendMoneyProfit' => self::WEEKEND_EXPECTED_MONEY,
				]);
		}


		// Big T

		$fieldName = 'VtigerAccountscf.' . VtigerAccountTable::CF_EXPENDITURE_POINT;
		$contain[] = 'VtigerAccountscf';
		$conditionsBigT = $conditions;
		$lastYearConditionsBigT = $lastYearConditions;

		$or = [[$fieldName . ' IS NULL'], [$fieldName . ' <>' => VtigerAccountTable::EXPEND_POINT_SHOP_IN_SHOP]];
		$conditionsBigT['OR'] = $or;
		$lastYearConditionsBigT['OR'] = $or;
		$conditionsBigT['VtigerSalesordercf.' . VtigerSalesorderTable::CF_IS_WHOLESALE] = 0;
		$lastYearConditionsBigT['VtigerSalesordercf.' . VtigerSalesorderTable::CF_IS_WHOLESALE] = 0;

		$this->_generateGraphs($conditionsBigT, $lastYearConditionsBigT, $contain, self::BIG_T_GRAPH_NAME);


		$this->_controller->set(['likeForLikeGraphs' => $this->getGraphs()]);
	}

	/**
	 * Получает из базы информацию о заказах и доходах по переданным условиям
	 * генерирует массивы данных для графика
	 *
	 * @param array $newConditions
	 * @param array $oldConditions
	 * @param array $contain
	 * @param string $graphName
	 * @param array $advancedProfitLine
	 */
	private function _generateGraphs(
		$newConditions, $oldConditions, $contain, $graphName,
		$advancedProfitLine = ['alg' => self::ALG_HISTORY]
	) {
		$newOrders = [];
		$newMoney = [];
		$oldOrders = [];
		$oldMoney = [];
		$profit = [];
		$moneyProfit = [];


		$query = $this->_controller->VtigerSalesorder->find();
		$selectFields = [
			'date' => $query->func()->date(['createdtime' => 'literal']),
			'total_sum' => $query->func()->sum('subtotal'),
			'total_orders' => $query->func()->count('*'),
		];

		$newStatistics = $this->_controller->VtigerSalesorder->find()
			->select($selectFields)
			->contain($contain)
			->where($newConditions)
			->group('date')
			->order('date')
			->toArray();

		$oldStatistics = $this->_controller->VtigerSalesorder->find()
			->select($selectFields)
			->contain($contain)
			->where($oldConditions)
			->group('date')
			->order('date')
			->toArray();


		// Если тики, не заданы, то нужно их создать, а потом в остальных графах их использовать,
		// чтобы везде были выборки за одинаковые периоды
		$isNewTicks = (empty($this->_ticks));


		$numTicks = $isNewTicks ? count($newStatistics) : count($this->_ticks);

		// Заполним нулями и сгенерим ожидаемый текущий доход, если он задан константами для рабочих и выходных дней
		for ($index = 0; $index < $numTicks; $index++) {
			$newOrders[] = [$index, 0];
			$newMoney[] = [$index, 0];
			$oldOrders[] = [$index, 0];
			$oldMoney[] = [$index, 0];
			$profit[] = [$index, 0];
			$moneyProfit[] = [$index, 0];
			if ($advancedProfitLine['alg'] === self::ALG_FIXED) {
				$line = $advancedProfitLine;
				$isWeekend = ($advancedProfitLine['weekday'] + $index) % 7 >= 5;
				if ($isWeekend) {
					$profit[$index] = [$index, $line['weekendProfit']];
					$moneyProfit[$index] = [$index, $line['weekendMoneyProfit']];
				} else {
					$profit[$index] = [$index, $line['workdayProfit']];
					$moneyProfit[$index] = [$index, $line['workdayMoneyProfit']];
				}
			}
		}

		// Генерируем данные для новых заказов и доходов
		$statIndex = 0;
		for ($index = 0; $index < $numTicks; $index++) {
			if (!array_key_exists($statIndex, $newStatistics)) // Закончились данные
			{
				break;
			}
			$stat = $newStatistics[$statIndex];
			if ($isNewTicks) {
				$this->_ticks[] = [$index, date('d/m', strtotime($stat->date))];
			} elseif ($this->_ticks[$index][1] != date('d/m', strtotime($stat->date))) // Пропустили дату без заказов
			{
				continue;
			}
			$newOrders[$index] = [$index, $stat->total_orders];
			$newMoney[$index] = [$index, round($stat->total_sum / 1000)];
			$statIndex++;
		}

		// Генерируем данные для старых заказов и доходов,
		// а также ожидаемый текущий доход, если он высчитывается из старых значений

		// Циклы похожи, но чтобы выделить их в одну функцию
		// необходимо передать в нее больше 10 переменных
		// Я думаю, это только усложнит код
		$statIndex = 0;
		for ($index = 0; $index < $numTicks; $index++) {
			if (!array_key_exists($statIndex, $oldStatistics)) // Закончились данные
			{
				break;
			}
			$stat = $oldStatistics[$statIndex];
			if ($this->_ticks[$index][1] != date('d/m', strtotime($stat->date) - $this->_weekdayOffset)) // Пропустили дату без заказов
			{
				continue;
			}
			$oldOrders[$index] = [$index, $stat->total_orders];
			$oldMoney[$index] = [$index, round($stat->total_sum / 1000)];
			if ($advancedProfitLine['alg'] === self::ALG_HISTORY) {
				$profit[$index] = [$index, $stat->total_orders * 3];
				$moneyProfit[$index] = [$index, round($stat->total_sum / 1000 * 3)];
			}
			$statIndex++;
		}

		// Не даем данные о доходах, если нет прав
		if (!$this->_canViewIncome) {
			$newMoney = $oldMoney = $moneyProfit = [];
		}

		$latinName = Inflector::camelize(Text::transliterate($graphName), ' ');
		$newGraph = [
			'name' => $graphName,
			'profitLine' => $advancedProfitLine,
			'newOrders' => $newOrders,
			'oldOrders' => $oldOrders,
			'profitOrders' => $profit,
			'newMoney' => $newMoney,
			'oldMoney' => $oldMoney,
			'profitMoney' => $moneyProfit,
		];


		$this->addGraph($latinName, $newGraph);

		$this->_generateTotalsForGraph($newOrders, $latinName, 'ordersNew');
		$this->_generateTotalsForGraph($oldOrders, $latinName, 'ordersOld');
		$this->_generateTotalsForGraph($profit, $latinName, 'ordersProfit');

		if ($this->_canViewIncome) {
			$this->_generateTotalsForGraph($newStatistics, $latinName, 'moneyNew', 'total_sum');
			$this->_generateTotalsForGraph($oldStatistics, $latinName, 'moneyOld', 'total_sum');

			if ($advancedProfitLine['alg'] === self::ALG_HISTORY) {
				$this->_generateTotalsForGraph($oldStatistics, $latinName, 'moneyProfit', 'total_sum', 3);
			} else {
				$this->_generateTotalsForGraph($moneyProfit, $latinName, 'moneyProfit', 1, 1000);
			}
		} else {
			$this->_graphs[$latinName]['moneyNewTotal'] = 0;
			$this->_graphs[$latinName]['moneyOldTotal'] = 0;
			$this->_graphs[$latinName]['moneyProfitTotal'] = 0;
			$this->_graphs[$latinName]['moneyEndOfMonthTotal'] = 0;
		}

		$this->_generateMultipliers($latinName, $newConditions, $contain);

		if ($isNewTicks) {
			$this->_controller->set(['ticks' => $this->_ticks]);
		}
	}

	/**
	 * Записывает в вид сумму значений графа
	 *
	 * @param array $graph
	 * @param string $graphName
	 * @param string $paramName
	 * @param int|string $field
	 * @param int $factor
	 */
	private function _generateTotalsForGraph($graph, $graphName, $paramName, $field = 1, $factor = 1) {
		$total = 0;
		foreach ($graph as $stat) {
			$total += $stat[$field] * $factor;
		}
		$this->_graphs[$graphName][$paramName . 'Total'] = $total;
	}

	/**
	 * Генерирует ожидаемое число заказов/дохода к концу текущего месяца
	 *
	 * @param string $latinName
	 * @param array $conditions
	 * @param array $contain
	 */
	private function _generateMultipliers($latinName, $conditions, $contain) {
		$from = new Time('first day of this month -1 year');
		$to = new Time('first day of next month -1 year');
		$conditions['VtigerCrmentity.createdtime >='] = $from;
		$conditions['VtigerCrmentity.createdtime <'] = $to;
		$graph = $this->_graphs[$latinName];
		$query = $this->_controller->VtigerSalesorder->find();
		$statistics = $this->_controller->VtigerSalesorder->find()
			->select([
				'total_sum' => $query->func()->sum('subtotal'),
				'total_orders' => $query->func()->count('*'),
			])
			->contain($contain)
			->where($conditions)
			->first();
		if ($graph['ordersOldTotal'] != 0) {
			$ordersMultiplier = $graph['ordersNewTotal'] / $graph['ordersOldTotal'];
		} else {
			$ordersMultiplier = 0;
		}
		if ($graph['moneyOldTotal'] != 0) {
			$moneyMultiplier = $graph['moneyNewTotal'] / $graph['moneyOldTotal'];
		} else {
			$moneyMultiplier = 0;
		}

		$this->_graphs[$latinName]['ordersMonthExpected'] = $statistics['total_orders'] * $ordersMultiplier;
		$this->_graphs[$latinName]['moneyMonthExpected'] = $statistics['total_sum'] * $moneyMultiplier;
	}
}