<?php
$styles = ['td' => "border: 1px solid #000; padding: 5px 10px 5px 10px;"];
$styles['th-left'] = 'text-align: left;' . $styles['td'];
?>

	<h1 style="font-size: 14pt;">Задание №<?= $task->taskid; ?></h1>
	<div style="font-size: 10pt">
		Курьер: <?= (!empty($task->VtigerContactdetails) ? ($task->VtigerContactdetails->firstname . ' ' . $task->VtigerContactdetails->lastname) : 'Не назначен') ?>
	</div>
	<br>

	<div><?= $this->Barcode->html('task' . $task->taskid) ?></div><br>


	<table style="font-size: 9pt; border-collapse: collapse; border-spacing: 0;">
		<tr>
			<th style="<?= $styles['th-left'] ?>">Дата</th>
			<td style="<?= $styles['td'] ?>"><?= $task->task_date->format('d.m.Y'); ?></td>
		</tr>
		<tr>
			<th style="<?= $styles['th-left'] ?>">Адрес</th>
			<td style="<?= $styles['td'] ?>"><?= h($task->address) ?></td>
		</tr>
		<tr>
			<th style="<?= $styles['th-left'] ?>">Время</th>
			<td style="<?= $styles['td'] ?>"><?= $task->time_from->format('H:i') . ' &mdash; ' . $task->time_to->format('H:i'); ?></td>
		</tr>
		<tr>
			<th style="<?= $styles['th-left'] ?>">Контактный телефон</th>
			<td style="<?= $styles['td'] ?>"><?= (!empty($task->phone) ? h($task->phone) : '&mdash;') ?></td>
		</tr>
		<tr>
			<th style="<?= $styles['th-left'] ?>">Описание</th>
			<td style="<?= $styles['td'] ?>"><?= h($task->description); ?></td>
		</tr>
		<tr>
			<th style="<?= $styles['th-left'] ?>">Сумма</th>
			<td style="<?= $styles['td'] ?>"><?= $this->Number->precision($task->money, 2); ?></td>
		</tr>
		<tr>
			<th style="<?= $styles['th-left'] ?>">Вес</th>
			<td style="<?= $styles['td'] ?>"><?= h($task->weight); ?></td>
		</tr>
		<tr>
			<th style="<?= $styles['th-left'] ?>">Инициатор</th>
			<td style="<?= $styles['td'] ?>">
				<?php
				echo trim($task->VtigerUsers->first_name . ' ' . $task->VtigerUsers->last_name);
				if (!empty($task->VtigerUsers->phone_mobile)) {
					echo " (тел. {$task->VtigerUsers->phone_mobile}) ";
					?>
				<?php } ?>
			</td>
		</tr>
		<tr>
			<th style="<?= $styles['th-left'] ?>">Контрагент</th>
			<td style="<?= $styles['td'] ?>"><?= $task->VtigerAccount->accountname . ' (' . $task->VtigerAccount->account_no . ')'; ?></td>
		</tr>

	</table>
<?php
if (!empty($task->VtigerPurchaseorder)) {
	$this->set('purchaseorder', $task->VtigerPurchaseorder);
	echo "<br>";
	echo $this->element('Pdf/purchaseorder_info');
}
if (!empty($task->money)) {
	$this->set('amount', $task->money);
	$this->set('applier', trim($task->VtigerUsers->first_name . ' ' . $task->VtigerUsers->last_name));
	$this->set('reason', $task->expense_reason);
	$this->set('purchaseorder_no', (!empty($task->VtigerPurchaseorder) ? $task->VtigerPurchaseorder->purchaseorder_no : ''));
	$this->set('account_no', (!empty($task->VtigerAccount) ? $task->VtigerAccount->accountname : ''));
	$this->set('comment', 'Задание №' . $task->taskid);
	echo "<br>";
	echo $this->element('Pdf/money_apply');
}
