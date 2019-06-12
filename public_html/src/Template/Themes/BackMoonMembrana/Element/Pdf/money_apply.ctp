<?php
$styles = [
	'h' => 'font-size: 14pt',
	'table' => 'font-size: 9pt; border-collapse: collapse; border-spacing: 0px;',
	'td' => 'border: 1px solid #000; padding: 5px 10px 5px 10px;',
	'th-left' => ' text-align: left;',
];
$styles['th-left'] = $styles['td'] . $styles['th-left'];
foreach ($styles as &$style) {
	$style = 'style="' . $style . '"';
}
$widthCol = 150;
?>
<div style="page-break-before: always; page-break-inside: avoid">
	<h2 <?= $styles['h'] ?>>Заявление на получение денег<?= (!empty($comment) ? ' (' . $comment . ')' : '') ?></h2>
	<table <?= $styles['table'] ?>>
		<tbody>
			<tr><th <?= $styles['th-left'] ?> width="<?= $widthCol ?>">Кто заказывает деньги</th><td width="<?= ($widthCol * 3) ?>" <?= $styles['td'] ?>><?= $applier ?></td></tr>
			<tr><th <?= $styles['th-left'] ?>>Отдел (подчеркнуть)</th><td <?= $styles['td'] ?>>Закупки / Другое</td></tr>
			<tr><th <?= $styles['th-left'] ?>>Кому выдать деньги</th><td <?= $styles['td'] ?>></td></tr>
		</tbody>
	</table>
	<h2 <?= $styles['h'] ?>>Предполагаемое использование денег</h2>
	<table <?= $styles['table'] ?>>
		<tbody>
			<tr><th <?= $styles['th-left'] ?> width="<?= $widthCol ?>">Общая сумма</th><td colspan="3" width="<?= ($widthCol * 3) ?>" <?= $styles['td'] ?>><?= $this->Number->precision($amount, 2) ?></td></tr>
			<tr><th <?= $styles['th-left'] ?>>Цель расхода</th><td colspan="3" <?= $styles['td'] ?>><?= $reason ?></td></tr>
			<tr><th <?= $styles['th-left'] ?>>Номер заказа (закупки)</th><td colspan="3" <?= $styles['td'] ?>><?= $purchaseorder_no ?></td></tr>
			<tr><th <?= $styles['th-left'] ?>>Контрагент в CRM</th><td colspan="3" <?= $styles['td'] ?>><?= $account_no ?></td></tr>
			<tr><th <?= $styles['th-left'] ?> width="<?= $widthCol ?>">Подпись сотрудника</th><td width="<?= $widthCol ?>" <?= $styles['td'] ?>></td><th width="<?= $widthCol ?>" <?= $styles['th-left'] ?>>Дата:</th><td width="<?= $widthCol ?>" <?= $styles['td'] ?>></td></tr>
		</tbody>
	</table>
	<h2 <?= $styles['h'] ?>>Утверждение</h2>
	<table <?= $styles['table'] ?>>
		<thead>
			<tr><th <?= $styles['td'] ?> width="<?= $widthCol ?>">Подпись</th><th <?= $styles['td'] ?> width="<?= $widthCol ?>">ФИО</th><th <?= $styles['td'] ?> width="<?= $widthCol ?>">Должность</th><th <?= $styles['td'] ?> width="<?= $widthCol ?>">Дата</th></tr>
		</thead>
		<tbody>
			<tr><td <?= $styles['td'] ?>><br></td><td <?= $styles['td'] ?>></td><td <?= $styles['td'] ?>></td><td <?= $styles['td'] ?>></td></tr>
		</tbody>
	</table>
</div>