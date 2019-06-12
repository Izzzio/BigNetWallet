<?php
$styles = ['td' => 'border: 1px solid #000; padding: 2px;'];
$styles['td-right'] = $styles['td'] . ' text-align: right;';

$total = 0;
$count = 0;
$purchaseorder->VtigerInventoryproductrel = (array)$purchaseorder->VtigerInventoryproductrel;
foreach ($purchaseorder->VtigerInventoryproductrel as $key => $productRel) {
	$product = $productRel->VtigerProducts;
	$purchaseorder->VtigerInventoryproductrel[$key]->sum = $productRel->quantity * $productRel->listprice;
	$total += $productRel->sum;
	$count += $productRel->quantity;
	$purchaseorder->VtigerInventoryproductrel[$key]->unit = (($product->usageunit == 'Each') ? 'шт.' : $product->usageunit);
}
?>

<div style="page-break-inside: avoid;">
	<h1 style="font-size: 14pt">Заказ на закупку № <?= $purchaseorder->purchaseorder_no; ?></h1>
	<p style="font-size: 9pt;">Поставщик: <span style="font-weight: bold;"><?= $purchaseorder->VtigerVendor->vendorname; ?></span></p>
	<table style="font-size: 9pt; border-collapse: collapse; border-spacing: 0px;">
		<thead>
		<tr>
			<th width="20" style="<?= $styles['td']; ?>">№</th>
			<th width="70" style="<?= $styles['td']; ?>">Артикул</th>
			<th width="210" style="<?= $styles['td']; ?>">Товар</th>
			<th width="75" colspan="2" style="<?= $styles['td']; ?>">Количество</th>
			<th width="55" style="<?= $styles['td']; ?>">Цена</th>
			<th width="80" style="<?= $styles['td']; ?>">Сумма</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ($purchaseorder->VtigerInventoryproductrel as $productRel) {
			$product = $productRel->VtigerProducts;
			?>
			<tr>
				<td style="<?= $styles['td']; ?>"><?= $productRel->sequence_no ?></td>
				<td style="<?= $styles['td']; ?>"><?= $product->productcode ?></td>
				<td style="<?= $styles['td']; ?>"><?= $product->productname ?></td>
				<td style="<?= $styles['td-right']; ?>"><?= $productRel->quantity ?></td>
				<td style="<?= $styles['td-right']; ?>"><?= $productRel->unit ?></td>
				<td style="<?= $styles['td-right']; ?>"><?= $this->Number->precision($productRel->listprice, 2) ?></td>
				<td style="<?= $styles['td-right']; ?>"><?= $this->Number->precision($productRel->sum, 2) ?></td>
			</tr>
		<?php } ?>
		<tr>
			<td></td>
			<td></td>
			<td style="text-align: right; font-weight: bold;">Всего:</td>
			<td style="text-align: right; font-weight: bold;"><?= $count ?></td>
			<td></td>
			<td style="text-align: right; font-weight: bold;">Итого:</td>
			<td style="text-align: right; font-weight: bold;"><?= $this->Number->precision($total, 2) ?></td>
		</tr>
		</tbody>
	</table>
</div>
