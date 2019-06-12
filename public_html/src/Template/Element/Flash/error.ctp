<div class="row">
	<div class="col-md-12">
		<div class="alert alert-danger" role="alert" style="border-radius: 0px;">
			<button type="button" class="close" data-dismiss="alert" aria-label="Убрать"><span aria-hidden="true">×</span></button>
			<?= nl2br($message) ?>
			<?php if (!empty($params['icon'])): ?>
				<i class="<?= $params['icon']; ?>"></i>
			<?php endif; ?>
		</div>
	</div>
</div>
