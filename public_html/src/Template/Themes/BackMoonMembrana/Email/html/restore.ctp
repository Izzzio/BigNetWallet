<?php
/**
 * @var string $login
 * @var string $code
 */
?>
<?= __('Hello.') ?>
<br>
<?= __('You was request password restore at') ?> <?= \App\Lib\Misc::projectName() ?>.
<br>
<?= __('To recover the password, click on this link') ?>:<br>
<?= BASE_PROTOCOL ?>://<?= BASE_DOMAIN ?>/app/restore/<?= $code ?><br>
<br><br>

<?= __('Your login') ?>: <?= $login ?>
<br>

Sincerely your,<br>
<?= \App\Lib\Misc::projectName() ?> Team.<br>
