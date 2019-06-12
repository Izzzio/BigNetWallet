<?php
/**
 * @var string $login
 * @var string $code
 * @var string $password
 */
$result = \App\Lib\Sandbox::runFromStorageOrIgnore('kycSuccessEmail', [
    'login'    => $login,
]);
if ($result !== false) {
    return $result;
}
?>
    Dear user,

    Your KYC has been successfully passed

    Your login: <?= $login ?>

<?= \Cake\Core\Configure::read('App.emails.sign') ?>