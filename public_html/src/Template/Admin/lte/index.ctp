<?php
/**
 * @var int $totalUsers
 * @var int $notverifiedUsers
 * @var int $verifiedUsers
 * @var \App\Model\Entity\Transaction $lastTx
 * @var int $frozen
 * @var array $transChart
 */
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard - <?= h(\App\Lib\Misc::projectName()) ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Info boxes -->
    <div id="dashboardHolder">
        <div class="row">
            <?php if(\App\Controller\AclController::isUserRole(['ROLE_SYSTEM', 'ROLE_ADMIN'])) {?>
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tokensale main info</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <dl class="dl-horizontal">
                            <dt>Max token vol:</dt>
                            <dd><?= h(\Cake\Core\Configure::read('App.calculator.maxVol')) ?></dd>

                            <dt>Base token price:</dt>
                            <dd><?= h(\Cake\Core\Configure::read('App.calculator.tokenCurrencyPrice')) ?></dd>

                            <dt>Tokensale periods:</dt>
                            <dd><?= h(count(\Cake\Core\Configure::read('App.calculator.periods'))) ?></dd>

                            <dt>Internal currency:</dt>
                            <dd><?= h(\App\Lib\Misc::internalCurrency()) ?></dd>

                            <?php if (\App\Lib\Misc::tcfg('enableReferal')) { ?>
                            <dt>Referal bonus:</dt>
                            <dd><?= h(\App\Lib\Referal::getReferalBonus()) ?>%</dd>
                            <?php } ?>

                            <dt>Campaign:</dt>
                            <dd><?= h(\App\Lib\Misc::projectName()) ?></dd>

                            <dt>Enabled currencies:</dt>
                            <dd><?= h(implode(', ', \Cake\Core\Configure::read('App.enabledCurrencies'))) ?></dd>

                            <dt>Default gate:</dt>
                            <dd><?= h(\App\Lib\Payments\Payment::DEFAULT_GATE) ?></dd>

                            <dt>Payment gates:</dt>
                            <dd><?= (nl2br(\App\Lib\Misc::array2View(\Cake\Core\Configure::read('App.paymentGates')))) ?></dd>
                        </dl>
                    </div>
                    <div class="box-footer text-center">
                        <a href="https://t.me/izzziocabinet" target="_blank">iZ³ Cabinet news and notifications&nbsp;&nbsp;<i class="fa fa-external-link" aria-hidden="true"></i></a><br>
                        <a href="https://docs.google.com/document/d/1LrYJSr7EusRmXFgjkIjVNLYEEQhLqO5aJTVy3l9MVCE/edit#" target="_blank">User manual&nbsp;&nbsp;<i class="fa fa-external-link" aria-hidden="true"></i></a><br>
                    </div>
                </div>
            </div>
            <?php }?>
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">News</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <dl class="direct-chat-messages">
                            <?php
                        foreach (array_reverse(\App\Controller\AdminController::WHATS_NEW) as $new) {
                        ?>
                            <dt><?= h($new['title']) ?></dt>
                            <dd><?= h($new['text']) ?></dd>
                            <hr>
                            <?php
                        }
                        ?>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if(\App\Controller\AclController::isNotUserRole(['ROLE_ANALYST'])) {?>
                <div class="col-md-6">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Users</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <dl class="dl-horizontal">
                                <dt>Total users:</dt><dd><?= h($totalUsers) ?></dd>
                                <dt>Await verify:</dt><dd><?= h($notverifiedUsers) ?></dd>
                                <dt>Verified users:</dt><dd><?= h($verifiedUsers) ?></dd>
                                <dt>Total balance:</dt><dd><?= h($totalBalance) ?> USD</dd>
                                <dt>Total tokens:</dt><dd><?= h($totalTokens) ?></dd>
                            </dl>

                            <div id="users" style="height: 460px;"></div>
                            <script>
                                Plotly.newPlot('users', [{
                                    values: [<?= h($notverifiedUsers) ?>, <?= h($verifiedUsers) ?>],
                                labels: ['Await verify', 'Verified'],
                                type: 'pie'
                            }], null, {staticPlot: true});
                            </script>
                        </div>
                        <div class="box-footer text-center">
                            <a href="<?= URL_PREFIX ?>/admin/users" class="uppercase">View All Users</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Transactions</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <dl class="dl-horizontal">
                                <dt>TX count:</dt><dd><?= h($totalTx) ?></dd>
                                <dt>Total income:</dt><dd><?= h($totalIncome) ?> USD</dd>
                                <dt>Total converted:</dt><dd><?= h($totalOutcome) ?> USD</dd>
                                <dt>Frozen:</dt><dd><?= h($frozen) ?> USD</dd>
                                <?php if (!empty($lastTx)) { ?>
                                    <dt>Last income TX:</dt><dd><?= h($lastTx->created) ?> <?= h($lastTx->amount) ?> <?= h($lastTx->currency) ?> $<?= h($lastTx->usd) ?></dd>
                                <br>
                                <?php } ?>
                            </dl>

                            <div id="transactions" style="height: 440px;"></div>
                            <script>
                                Plotly.newPlot('transactions', [
                                    {
                                        x: <?=json_encode(array_column($transChart, 1))?>,
                                y: <?=json_encode(array_column($transChart, 0))?>,
                                type: 'bar'
                                }
                                ], null, {staticPlot: true});
                            </script>
                        </div>
                        <div class="box-footer text-center">
                            <a href="<?= URL_PREFIX ?>/admin/transactions" class="uppercase">Manage transanctions</a>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>

        <div class="row">
            <?php
            $payments = (new \Cake\Filesystem\Folder(ROOT . '/src/Lib/Payments'))->read()[1];

            foreach ($payments as $payment) {
                $class = '\\App\\Lib\\Payments\\' . str_replace('.php', '', $payment);
                try {
                    /**
                     * @var \App\Lib\Payments\CoinPayments $class
                     */
                    if (!$class::DISABLED) {
                        $class::drawAdminTile();
                    }
                } catch (Exception $e) {

                }
            }
            ?>
        </div>

        <div class="row">
        <?php
        $tokens = (new \Cake\Filesystem\Folder(ROOT . '/src/Lib/Tokens'))->read()[1];

        foreach ($tokens as $token) {
            $class = '\\App\\Lib\\Tokens\\' . str_replace('.php', '', $token);
            try {
                /**
                 * @var \App\Lib\Tokens\ERC20 $class
                 */
                if (!$class::DISABLED) {
                    $class::drawAdminTile();
                }
            } catch (Exception $e) {

            }
        }

        ?>
        </div>

        <div class="row">
            <?php if(\App\Controller\AclController::isUserRole(['ROLE_SYSTEM', 'ROLE_ADMIN'])) {?>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Watchdog</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body" style="overflow-x: scroll">
                            <b>Configuration hash: </b><span style="font-size: 10pt"><?= h(md5_file(CONFIG . CURRENT_CONFIG . '.php')) ?></span><br>
                            <b>Debug: </b><span style="font-size: 10pt"><?= DEBUG ? '<span style="color: red">Enabled</span>' : '<span style="color: green">Disabled</span>' ?></span><br>
                            <b>Error log size: </b><span style="font-size: 10pt"><?= h(round(@filesize(\Cake\Log\Log::config('debug')['path'] . \Cake\Log\Log::config('error')['file'] . '.log') / 1024, 2)) ?> KB</span><br>
                            <b>Debug log size: </b><span style="font-size: 10pt"><?= h(round(@filesize(\Cake\Log\Log::config('debug')['path'] . \Cake\Log\Log::config('debug')['file'] . '.log') / 1024, 2)) ?> KB</span><br>
                            <b>API access token: </b><span style="font-size: 10pt"><?= h(empty(\Cake\Core\Configure::read('App.accessToken'))) ? '<b>Disabled</b>' : h(\Cake\Core\Configure::read('App.accessToken')) ?></span><br>
                            <b>Social auth: </b><span style="font-size: 10pt"><?= h(empty(\Cake\Core\Configure::read('App.enableSocial'))) ? 'Disabled' : 'Enabled' ?></span><br>
                            <b><a href="<?= URL_PREFIX ?>/admin/logs">Info log entries: </a></b><span style="font-size: 10pt"><?= h(App\Model\Table\LogTable::f()->count()) ?></span><br>
                        </div>
                        <div class="box-footer clearfix">
                            <a href="<?= URL_PREFIX ?>/admin/sqldump" class="btn btn-sm btn-primary btn-flat pull-left">Download database dump</a>
                        </div>
                    </div>
                </div>
            <?php }?>


            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Analytics</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <dl class="dl-horizontal">
                            <dt>Google Analytics ID:</dt><dd><?= h(\App\Lib\Misc::tcfg('ga')) ?></dd>
                            <dt>Google tag manager ID:</dt><dd><?= h(\App\Lib\Misc::tcfg('gtm')) ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<script>
    function setWidgetsHeight() {
        var maxHeight = 0;
        $('.row').each(function (i, el) {
            maxHeight = 0;
            $('.box', el).each(function (j, el2) {
                if(maxHeight < $(el2).height()) {
                    maxHeight = $(el2).height();
                }
            });
            $('.box').css('min-height', maxHeight + 'px');
        });

        $('#dashboardHolder').css('min-height', $('#dashBoard').height() + 'px');
    }

    function updateDashboard() {
        $.get('<?= URL_PREFIX ?>/admin/index', function (data) {
            $('#dashBoard').html($(data).find('#dashBoard').html());
            //setWidgetsHeight();
            if(typeof updateDashboardHook !== 'undefined') {
                updateDashboardHook();
            }
        });
    }

    var updateDashboardInterval = setInterval(updateDashboard, 60000);

    //$(window).resize(setWidgetsHeight);
    //setWidgetsHeight();

</script>

<?php
\App\Lib\Sandbox::runFromStorageOrIgnore('adminBeforeClosedBody', ['user' => \App\Lib\CurrentUser::get()]);
?>