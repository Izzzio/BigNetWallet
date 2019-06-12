<?php
/**
 * @var string $login
 * @var string $status
 */
$result = \App\Lib\Sandbox::runFromStorageOrIgnore('kycFailEmail', [
    'login'    => $login,
    'status' => $status,
]);
if ($result !== false) {
    return $result;
}
?>
    Dear user,

    The status of your KYC was changed to:

    <?=$status?>

    Your login: <?= $login ?>

<?= \Cake\Core\Configure::read('App.emails.sign') ?>