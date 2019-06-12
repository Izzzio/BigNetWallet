<?php
/**
 * @var string $login
 * @var string $code
 * @var string $password
 */
$result = \App\Lib\Sandbox::runFromStorageOrIgnore('newTransactionEmail', [
    'login'    => $login,
    'amount'  => $amount,
    'currency'  => $currency,
]);
if ($result !== false) {
    return $result;
}
?>
    Dear user,

    for your created new transaction.
    Transaction amount: <?= $amount.' '.$currency ?>.

    Your login: <?= $login ?>


<?= \Cake\Core\Configure::read('App.emails.sign') ?>