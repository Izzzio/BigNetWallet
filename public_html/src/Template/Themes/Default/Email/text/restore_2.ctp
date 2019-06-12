<?php
/**
 * @var string $login
 * @var string $code
 * @var string $password
 */
$result = \App\Lib\Sandbox::runFromStorageOrIgnore('newPasswordEmail', [
    'login'    => $login,
    'password' => $password,
]);
if ($result !== false) {
    return $result;
}
?>
    Dear user,

    Your password has been changed upon your request

    Your login: <?= $login ?>

    You new password: <?= $password ?>

<?= \Cake\Core\Configure::read('App.emails.sign') ?>