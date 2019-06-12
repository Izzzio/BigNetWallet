<?php
/**
 * @var \App\Model\Entity\Transaction[] $transactions
 */
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Transactions Stats
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= URL_PREFIX ?>/admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Transactions Stats</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div id="dashboardHolder">
        <div class="row">
            <?php if(\App\Controller\AclController::isNotUserRole(['ROLE_ANALYST'])) {?>
            <div class="col-md-6">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="transactions_currencies"></div>
                        <script>
                            Plotly.newPlot(
                                'transactions_currencies',
                                [{
                                    values: <?= $currencies['values'] ?>,
                                        labels: <?= $currencies['names'] ?>,
                                        type: 'pie'
                                    }],
                                    {
                                        title: 'Currencies (USD)'
                            },
                            {
                                staticPlot: false
                            }
                            );
                        </script>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div id="transactions_rate"></div>
                        <script>
                            Plotly.newPlot(
                                'transactions_rate',
                                [{
                                    x: <?= json_encode(array_column(h($transChart), 1))?>,
                            y: <?= json_encode(array_column(h($transChart), 0))?>,
                            type: 'bar'
                            }],
                            {
                                title: 'USD amount per day'
                            },
                            {
                                staticPlot: false
                            }
                            );
                        </script>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</section>