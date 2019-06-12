<?php
$styles = [
	'td' => 'border: 1px solid #000; padding: 2px;'
];
?>
<h1 style="font-size: 16px; text-align: center;"><?= $courier->firstname . ' ' . $courier->lastname . ': ' . date('d.m.Y', strtotime($date)) ?></h1>
<div style="font-size: 14px; color: #000; alignment: center;">
	<?php if (!empty($orders)) { ?>
		<table style="font-size: 14px; border-collapse: collapse; border-spacing: 0px;">
			<thead>
				<tr>
					<th style="<?= $styles['td'] ?> font-weight: bold;">№ заказа</th>
					<th style="<?= $styles['td'] ?> font-weight: bold;">Форма оплаты</th>
					<th style="<?= $styles['td'] ?> font-weight: bold;">Принято наличных, руб.</th>
				</tr>
			</thead>
			<?php foreach ($orders as $order) { ?>
				<tr>
					<td style="<?= $styles['td'] ?>"><?= $order->salesorder_no ?></td>
					<td style="<?= $styles['td'] ?>"><?= $order->payment_type ?></td>
					<td style="<?= $styles['td'] ?> text-align: right;"><?= $this->Number->precision($order->totalProcessed, 2) ?></td>
				</tr>
			<?php } ?>
			<tr>
				<td style="<?= $styles['td'] ?> font-weight: bold;"><b>Всего наличных получено, руб.</b></td>
				<td colspan="2" style="<?= $styles['td'] ?> text-align: right; font-weight: bold;"><b><?= $this->Number->precision($totalReturn, 2) ?></b></td>
			</tr>
		</table>
	<?php } ?>
	<br>
	<?php if (!empty($tasks)) { ?>
		<table style="font-size: 14px; border-collapse: collapse; border-spacing: 0px;">
			<thead>
			<tr>
				<th style="<?= $styles['td'] ?> font-weight: bold;">№ задания</th>
				<th style="<?= $styles['td'] ?> font-weight: bold;">Отчитался за, руб.</th>
			</tr>
			</thead>
			<?php foreach ($tasks as $task) { ?>
				<tr>
					<td style="<?= $styles['td'] ?>"><?= $task->taskid ?></td>
					<td style="<?= $styles['td'] ?> text-align: right;"><?= $this->Number->precision($task->money, 2) ?></td>
				</tr>
			<?php } ?>
			<tr>
				<td style="<?= $styles['td'] ?> font-weight: bold;"><b>Всего отчитался за, руб.</b></td>
				<td colspan="2" style="<?= $styles['td'] ?> text-align: right; font-weight: bold;"><b><?= $this->Number->precision($totalReport, 2) ?></b></td>
			</tr>
		</table>
	<?php } ?>
</div>
