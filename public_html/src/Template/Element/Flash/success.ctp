<div class="row">
	<div class="col-md-12">
		<div class="alert alert-success" role="alert" style="border-radius: 0px;">
			<button type="button" class="close" data-dismiss="alert" aria-label="Убрать"><span aria-hidden="true">×</span></button>
			<?= h($message) ?>
			<?php if (!empty($params['icon'])): ?>
				<i class="<?= $params['icon']; ?>"></i>
			<?php endif; ?>
		</div>
	</div>
</div>
