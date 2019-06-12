<?php

namespace App\Lib;

use App\Lib\Traits\Library;
use App\Model\Table\ComVtigerWorkflowActivatedonceTable;
use App\Model\Table\VtigerInventoryproductrelTable;
use App\Model\Table\VtigerSalesordercfTable;
use App\Model\Table\VtigerSalesorderTable;
use App\Model\Table\ComVtigerWorkflowsTable;
use App\Model\Table\VtigerProductsTable;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
use Cake\Database\Expression\QueryExpression;
use Cake\Core\Configure;


/**
 * Основной функционал производства, который не относится ни к модели, ни к компоненте
 *
 * Class Production
 * @package App\Lib
 */
class Production
{

	use Library;

	const DAY_SESSION_START_HOUR = 8; // дневная смена
	const NIGHT_SESSION_START_HOUR = 20; // ночная смена

	/**
	 * Выставляем следующий статус для заказа
	 *
	 * @param Entity|int $order
	 * @return string|bool Новый статус для заказа, при отправки на производство передается статус "На производстве"
	 */
	public static function setNextOrderStatus($order) {
		$order = self::_getOrder($order);

		if (empty($order)) {
			return false;
		}

		$productList = $order['productList'];
		$nextStatus = false;
		foreach ($productList as $product) {
			if ($nextStatus === false) {
				if ($product->productid == VtigerProductsTable::ID_DESIGN_EDIT) {
					$nextStatus = VtigerSalesorderTable::STATUS_MODEL_APPROVE;
				}
			}
		}

		// проверка на необходимость оплаты
		if ($nextStatus === false
			&& $order['VtigerSalesordercf']->{VtigerSalesorderTable::CF_PAYMENT_TYPE} != VtigerSalesorderTable::PAYMENT_TYPE_NO
			&& VtigerSalesorderTable::getPaymentTypeData($order['VtigerSalesordercf']->{VtigerSalesorderTable::CF_PAYMENT_TYPE})['class'] == VtigerSalesorderTable::PAYMENT_CLASS_PRE
		) {
			$nextStatus = VtigerSalesorderTable::STATUS_WAITING_PAYMENT;
		}

		if ($nextStatus !== false) {
			VtigerSalesorderTable::instance()->saveArr(['sostatus' => $nextStatus], $order);

			// если макет на утверждении, то необходимо сбросить ответственного
			if ($nextStatus == VtigerSalesorderTable::STATUS_MODEL_APPROVE) {
				$crmTable = TableRegistry::get('VtigerCrmentity');
				$crmTable->updateAll(['smownerid' => 1], ['crmid' => $order->salesorderid]);
			}

			return $nextStatus;
		} else {
			if (!defined('TEST_MODE')) {
				self::moveToProduction($order);
			}

			return VtigerSalesorderTable::STATUS_PRODUCTION;
		}
	}

	/**
	 * Вытаскивает заказ с проверками
	 *
	 * @param int|Entity $order
	 * @return Entity|null
	 */
	static private function _getOrder($order) {
		$salesorderId = is_object($order) ? $order->salesorderid : $order;

		if ($salesorderId <= 0) {
			return null;
		}

		// проверка на наличие необходимых полей
		if (!is_object($order) || !isset($order->sostatus)) {
			$order = VtigerSalesorderTable::instance()->get($salesorderId);
		}

		if (!isset($order['VtigerSalesordercf']) || !isset($order['VtigerSalesordercf'][VtigerSalesorderTable::CF_DELIVERY_DATE])) {
			$order['VtigerSalesordercf'] = VtigerSalesordercfTable::instance()->get($salesorderId);
		}

		if (!isset($order['productList'])) {
			$order['productList'] = self::_getProductList($salesorderId);
		}

		return $order;
	}

	/**
	 * Отправляем заказ на производство. Также применима для проверки заказа на поступление товара и пропихивание его на производство
	 *
	 * @param int|Entity $order
	 */
	public static function moveToProduction($order) {
		$order = self::_getOrder($order);

		if (empty($order)) {
			return;
		}

		$productList = $order['productList'];

		$productNoList = [];
		foreach ($productList as $product) {
			$productNo = $product['VtigerProducts']['product_no'];
			if (!isset($productNoList[$productNo])) {
				$productNoList[$productNo] = [
					'productid' => $product['VtigerProducts']->productid,
					'category' => $product['VtigerProducts']->productcategory,
					'unit' => $product['VtigerProducts']->usageunit,
					'qty' => 0,
				];
			}

			// учитываем уже произведенные позиции
			list ($produced, $packed) = explode(':', $product['ArtskillsItemPersonalization']->produced);

			$productNoList[$productNo]['qty'] += ceil($product->quantity) - max((int)$produced, (int)$packed);
		}

		if (count($productNoList)) {
			$remains = SmartStore::getProductRemainsByNo(array_keys($productNoList), true);
			$today = date('Y-m-d', (defined('TEST_MODE') ? Configure::read('TEST_UTIME') : time()));
			$deliveryDate = $order['VtigerSalesordercf'][VtigerSalesorderTable::CF_DELIVERY_DATE]->format('Y-m-d');
			if ($deliveryDate < $today) {
				$deliveryDate = $today;
			}

			$closestDeliveryDate = $today;
			$canProduce = true;

			foreach ($productNoList as $productNo => $product) {
				$qty = $product['qty'];

				if (!isset($remains[$productNo])) {
					$closestDeliveryDate = false;
				} else {
					$cd = false;

					if ($order->sostatus != VtigerSalesorderTable::STATUS_PRODUCTION_WAITING) {
						$remains[$productNo]['now'] -= $qty;
					}

					if ($remains[$productNo]['now'] >= 0) {
						// 0 - значит точно вписались
						$cd = $today;
					}

					foreach ($remains[$productNo]['in_delivery'] as $dk => $dcnt) {
						if ($order->sostatus != VtigerSalesorderTable::STATUS_PRODUCTION_WAITING) {
							$remains[$productNo]['in_delivery'][$dk] = $dcnt - $qty;
						}

						if ($cd === false && $remains[$productNo]['in_delivery'][$dk] >= 0) {
							$cd = $dk;
							$canProduce = false; // заказы помещаем в очередь
						}
					}

					if ($cd === false) {
						$closestDeliveryDate = false;
					} else {
						if ($closestDeliveryDate != false && $cd > $closestDeliveryDate) {
							$closestDeliveryDate = $cd;
						}
					}
				}
			}

			if ($closestDeliveryDate === false || $closestDeliveryDate > $deliveryDate) { // чего-то нет в наличии и не успеем доставить к назначенному сроку
				$newStatus = VtigerSalesorderTable::STATUS_NOT_AVAILABLE;
			} elseif (!$canProduce) { // все в наличии - фигачим сразу
				$newStatus = VtigerSalesorderTable::STATUS_PRODUCTION_WAITING;
			} else {
				//$new_status = VtigerSalesorderTable::STATUS_PRODUCTION; TODO: исправить при переносе логистики
				$newStatus = VtigerSalesorderTable::STATUS_PRODUCTION_WAITING;
			}

			if ($newStatus != $order->sostatus) {
				self::_reserveProductsForProduction($order->salesorderid, $newStatus, $productNoList);
				VtigerSalesorderTable::instance()->saveArr(['sostatus' => $newStatus], $order);

				if ($newStatus == VtigerSalesorderTable::STATUS_PRODUCTION) {
					Promo::addPromo($order);
					self::_registerDelivery($order);
				}
			}
		}
	}

	/**
	 * Формируем список товаров в заказе
	 *
	 * @param int $salesorderId
	 * @return array
	 */
	private static function _getProductList($salesorderId) {
		return VtigerInventoryproductrelTable::instance()->find()
			->contain(['ArtskillsItemPersonalization', 'VtigerProducts', 'VtigerProductcf'])
			->where(['VtigerInventoryproductrel.id' => $salesorderId])
			->order(['VtigerInventoryproductrel.sequence_no'])
			->toArray();
	}

	/**
	 * Заполняем резервы по товарам в БД
	 *
	 * @param int $salesorderId
	 * @param string $newStatus
	 * @param array $reserveProductNoList
	 */
	private static function _reserveProductsForProduction($salesorderId, $newStatus, $reserveProductNoList) {
		$activatedOnceTable = ComVtigerWorkflowActivatedonceTable::instance();
		$productsTable = VtigerProductsTable::instance();

		// резерв закупки
		if (
			in_array($newStatus, [
				VtigerSalesorderTable::STATUS_NOT_AVAILABLE,
				VtigerSalesorderTable::STATUS_PRODUCTION_WAITING,
			])
		) {
			$logReserve = $activatedOnceTable->log($salesorderId, ComVtigerWorkflowsTable::ID_SO_PURCHASE_RESERVE);
			if (empty($logReserve['old'])) {
				// был ли резерв на производство
				$hasProductReserve = $activatedOnceTable->exists([
					'entity_id' => $salesorderId,
					'workflow_id' => ComVtigerWorkflowsTable::ID_SO_PRODUCT_RESERVE,
				]);
				foreach ($reserveProductNoList as $productNo => $product) {
					if (
						$product['category'] == VtigerProductsTable::CATEGORY_PRODUCT
						&& $product['unit'] == VtigerProductsTable::UNIT_COUNTABLE
					) {
						self::_addProductReserve($product['productid'], ($hasProductReserve ? -$product['qty'] : 0), $product['qty']);
					} elseif ($product['category'] == VtigerProductsTable::CATEGORY_PROCESS) {
						$subproductList = $productsTable->getRelatedProducts($product['productid']);
						if (!empty($subproductList)) {
							foreach ($subproductList as $subproduct) {
								if (
									$subproduct->productcategory == VtigerProductsTable::CATEGORY_PRODUCT
									&& $subproduct->usageunit == VtigerProductsTable::UNIT_COUNTABLE
								) {
									$changeQty = $subproduct->qty * $product['qty'];
									self::_addProductReserve($subproduct->productid, ($hasProductReserve ? -$changeQty : 0), $changeQty);
								}
							}
						}
					}
				}
				if ($hasProductReserve) {
					// убираем резерв производства
					$activatedOnceTable->deleteAll([
						'entity_id' => $salesorderId,
						'workflow_id' => ComVtigerWorkflowsTable::ID_SO_PRODUCT_RESERVE,
					]);
				}
			}
		} else { // резерв товара
			$logReserve = $activatedOnceTable->log($salesorderId, ComVtigerWorkflowsTable::ID_SO_PRODUCT_RESERVE);
			if (empty($logReserve['old'])) {
				$hasPurchaseReserve = $activatedOnceTable->exists([
					'entity_id' => $salesorderId,
					'workflow_id' => ComVtigerWorkflowsTable::ID_SO_PURCHASE_RESERVE,
				]); // был ли резерв поставки
				foreach ($reserveProductNoList as $productNo => $product) {
					if (
						$product['category'] == VtigerProductsTable::CATEGORY_PRODUCT
						&& $product['unit'] == VtigerProductsTable::UNIT_COUNTABLE
					) {
						self::_addProductReserve($product['productid'], $product['qty'], ($hasPurchaseReserve ? -$product['qty'] : 0));
					} elseif ($product['category'] == VtigerProductsTable::CATEGORY_PROCESS) {
						$subproductList = $productsTable->getRelatedProducts($product['productid']);
						if ($subproductList) {
							foreach ($subproductList as $subproduct) {
								if (
									$subproduct->productcategory == VtigerProductsTable::CATEGORY_PRODUCT
									&& $subproduct->usageunit == VtigerProductsTable::UNIT_COUNTABLE
								) {
									$changeQty = $subproduct->qty * $product['qty'];
									self::_addProductReserve($subproduct->productid, $changeQty, ($hasPurchaseReserve ? -$changeQty : 0));
								}
							}
						}
					}
				}
				if ($hasPurchaseReserve) {
					// убираем резерв закупки
					$activatedOnceTable->deleteAll([
						'entity_id' => $salesorderId,
						'workflow_id' => ComVtigerWorkflowsTable::ID_SO_PURCHASE_RESERVE,
					]);
				}
			}
		}
	}

	/**
	 * Изменияем количество товара в резервах
	 *
	 * @param int $productId
	 * @param int $reserveQty добавить кол-во в резерв на производство
	 * @param int $demandQty добавить кол-во в резерв на закупку
	 * @return bool
	 */
	static private function _addProductReserve($productId, $reserveQty, $demandQty) {
		$prodTable = TableRegistry::get('VtigerProducts');
		$upd = [];
		if ($reserveQty <> 0) {
			$upd[] = [new QueryExpression('qtyinreserve = qtyinreserve ' . ($reserveQty > 0 ? '+ ' . $reserveQty : $reserveQty))];
		}

		if ($demandQty <> 0) {
			$upd[] = [new QueryExpression('qtyindemand = qtyindemand ' . ($demandQty > 0 ? '+ ' . $demandQty : $demandQty))];
		}

		if (count($upd)) {
			$prodTable->updateAll($upd, ['productid' => $productId]);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Регистрация заказа в КС
	 *
	 * @param int|Entity $order
	 */
	private static function _registerDelivery($order) {
		$salesorderId = is_object($order) ? $order->salesorderid : $order;

		if ($salesorderId <= 0) {
			// нефиг нам тут делать
			return;
		}

		$logDelivery = ComVtigerWorkflowActivatedonceTable::instance()->log($salesorderId, ComVtigerWorkflowsTable::ID_SO_REGISTER_DELIVERY);
		if (empty($logDelivery['old'])) {
			//DeliveryCollection::registerDelivery($entity);
		}
	}

	/**
	 * Проверяет доступность производства на определенную дату.
	 * Автотеста нет, т.к. связь со старой срм
	 *
	 * @param string $dateStart
	 * @param string|bool $dateEnd
	 * @return mixed
	 */
	public static function getProductionAvailability($dateStart, $dateEnd = false) {
		$res = VtigerApi::call('getPCOAvailability', ['date_start' => $dateStart, 'date_end' => $dateEnd]);

		if (isset($res) && isset($res['availability'])) {
			return $res['availability'];
		} else {
			return false;
		}
	}


	/**
	 * Текущая смена обычно работает на завтра
	 * Но если это ночная смена, а сейчас от полуночи до начала дневной смены, то получается что на сегодня
	 *
	 * @return Time
	 */
	protected static function _getCurrentShiftDay() {
		$day = new Time();
		if ($day->format('H') >= self::DAY_SESSION_START_HOUR) {
			$day->addDay();
		}
		return $day;
	}

	/**
	 * Возвращает информацию о загрузке производства
	 *
	 * @param string|null $dateFrom
	 * @param string|null $dateTo
	 * @return array|null
	 */
	public static function getPCOloading($dateFrom = null, $dateTo = null) {
		$dateFrom = new Time($dateFrom);
		$currentShiftDay = self::_getCurrentShiftDay();
		if ($dateFrom->format('Y-m-d') < $currentShiftDay->format('Y-m-d')) {
			$dateFrom = $currentShiftDay;
		}
		$dateTo = new Time($dateTo);
		if ($dateTo->format('Y-m-d') < $dateFrom->format('Y-m-d')) {
			$dateTo = $dateFrom;
		}

		$pcoData = VtigerApi::call('reportPCO', ['dateFrom' => $dateFrom->format('Y-m-d'), 'dateTo' => $dateTo->format('Y-m-d')]);

		if (is_null($pcoData) || $pcoData['status'] == 'error') {
			return null;
		}
		unset($pcoData['status']);

		return $pcoData;
	}


}