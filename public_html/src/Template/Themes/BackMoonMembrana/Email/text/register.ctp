<?php
/**
 * @var string $login
 * @var string $code
 * @var string $password
 */
$result = \App\Lib\Sandbox::runFromStorageOrIgnore('registerEmail', [
    'login'    => $login,
    'code'     => $code,
    'password' => empty($password) ? null : $password,
]);
if ($result !== false) {
    return $result;
}
?>

<?= __('Hello.') ?>

<?= __('You have been registered on the') ?> <?= \App\Lib\Misc::projectName() ?>.

<?php if (!empty($code)) {
    ?>
    <?= __('To confirm the registration, click on this link') ?>:
    <?= URL_PREFIX ?>/app/register/<?= $code ?>
    <?php
} ?>



<?= __('Your login') ?>: <?= $login ?>

<?php if (!empty($password)) {
    ?>
    <?= __('You new password') ?>: <?= $password ?>
    <?php
} ?>


<?= \Cake\Core\Configure::read('App.emails.sign') ?>