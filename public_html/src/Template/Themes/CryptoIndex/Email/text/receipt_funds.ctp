<?php
/**
 * @var float $tokenCount
 * @var float $amount
 * @var string $currency
 */
$result = \App\Lib\Sandbox::runFromStorageOrIgnore('receiptFundsEmail', [
    'tokens' => $tokenCount,
    'amount'  => $amount,
    'currency'  => $currency,
]);
if ($result !== false) {
    return $result;
}
?>
    Dear user,

    we inform you that you received funds.

    Received: <?= $tokenCount ?> token(s).
    Paid: <?= $amount.' '.$currency ?>.


<?= \Cake\Core\Configure::read('App.emails.sign') ?>