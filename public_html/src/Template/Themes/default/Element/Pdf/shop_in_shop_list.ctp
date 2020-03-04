<style>
	@media print {
		.more {
			page-break-after: always;
		}
	}
</style>

<?php
$styles = ['td' => 'border: 1px solid #000; padding: 2px;'];
$styles['td-right'] = $styles['td'] . ' text-align: right;';
$date = date('d.m.Y');
foreach ($orders as $accountOrders){
?>
<h1 style="font-size: 14pt">Реестр приёма передачи коммерческих отправлений</h1>
<p style="font-size: 9pt;">
	Город: Москва<br>
	Отправитель: Доволен(ООО)<br>
	Передал: <br>
	Принял: <br>
</p>
<table style="font-size: 9pt; border-collapse: collapse; border-spacing: 0px;">
	<thead>
	<tr>
		<th style="<?= $styles['td']; ?> width: 45px;">№ п/п</th>
		<th style="<?= $styles['td']; ?> width: 90px;">Номер заказа</th>
		<th style="<?= $styles['td']; ?> width: 120px;">Дата отправления</th>
		<th style="<?= $styles['td']; ?> width: 240px;">Адрес получателя</th>
		<th style="<?= $styles['td']; ?> width: 105px;">Сумма к оплате</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($accountOrders as $key => $order) { ?>
		<tr>
			<td style="<?= $styles['td']; ?>"><?= $key + 1 ?></td>
			<td style="<?= $styles['td']; ?>"><?= $order->salesorder_no ?></td>
			<td style="<?= $styles['td']; ?>"><?= $date ?></td>
			<td style="<?= $styles['td']; ?>"><?= $order->VtigerSoshipads->ship_street ?></td>
			<td style="<?= $styles['td']; ?>"><?= $order->total ?></td>
		</tr>
	<?php } ?>
</table>
<div style="font-size: 9pt; float: right; margin-right: 75px;">
	Дата составления: <?= $date ?>
</div>
<p style="font-size: 9pt;">
	Отправления проверены и полностью приняты.
</p>
<table style="font-size: 9pt; border-collapse: collapse; border-spacing: 0px;">
	<tr>
		<td style="<?= $styles['td']; ?> width: 80px;"></td>
		<td style="<?= $styles['td']; ?> width: 220px;">Должность</td>
		<td style="<?= $styles['td']; ?> width: 220px;">Ф.И.О.</td>
		<td style="<?= $styles['td']; ?> width: 80px;">Подпись</td>
	</tr>
	<tr>
		<td style="<?= $styles['td']; ?>">Передал</td>
		<td style="<?= $styles['td']; ?>"></td>
		<td style="<?= $styles['td']; ?>"></td>
		<td style="<?= $styles['td']; ?>"></td>
	</tr>
	<tr>
		<td style="<?= $styles['td']; ?>">Принял</td>
		<td style="<?= $styles['td']; ?>"></td>
		<td style="<?= $styles['td']; ?>"></td>
		<td style="<?= $styles['td']; ?>"></td>
	</tr>
</table>
<div style="font-size: 9pt;  float: right; margin-right: 75px;">
	Реестр составляется в двух экземплярах, по одному экземпляру с каждой стороны
</div>
	<div class="more"></div>
<?php }?>