<?php
$periods = \App\Lib\Calculator::getPeriods();
$ratio = \App\Lib\Misc::saleShowRatio();
foreach ($periods as $index => $period) {
    $currentPeriod = \App\Lib\Calculator::getPeriodSales()[$index];
    ?>
    <div class="token-date-item <?= $index === \App\Lib\Calculator::getPeriod() ? 'active' :
        '' ?>">
        <?=empty($period['name'])?'':'<h3>'.$period['name'].'</h3>' ?>
        <div class="token-date"><?= $period['start'] ?> <?= empty($period['end'])?'':'— '.$period['end'] ?></div>
        <div class="token-price">
            <div class="token-price-list row">
                <?php
                foreach ($currentPeriod as $percent => $summ) {
                    $raioInternalPrice = \App\Lib\CoinMarketCap::usd2token(\App\Lib\Calculator::token2Usd($ratio), \App\Lib\Misc::internalCurrency());
                    ?>
                    <div class="token-price-item">
                        <div class="token-price-sum"><?= round($summ['min']) ?> <?= $summ['max'] == PHP_INT_MAX ?
                                '+' :
                                '- ' . round($summ['max']) . ' ' . \App\Lib\Misc::tokenName() ?> </div>
                        <div class="token-price-exchange"><?= \App\Lib\Misc::internalCurrency() . ' ' . $raioInternalPrice ?>
                            = <?= $ratio + round($ratio * ($percent / 100), 2) ?> <?= \App\Lib\Misc::tokenName() ?></div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="token-show-link"><?= __('Show') ?></div>
    </div>
    <?php
}
?>