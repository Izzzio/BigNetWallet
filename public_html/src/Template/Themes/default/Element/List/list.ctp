<?php
/**
 * @var array $columnNames
 * @var array $data
 * @var \Cake\View\View $this
 */

?>
<table class="table table-bordered">
	<?= $this->Html->tableHeaders($columnNames) ?>
	<?= $this->Html->tableCells($data) ?>
</table>