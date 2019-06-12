<?php
/**
 * @var \App\Model\Entity\Transaction[] $transactions
 */
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Transactions
        <small>list of all transactions</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= URL_PREFIX ?>/admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Transactions</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-2 col-xs-3">
                            <a href="<?= URL_PREFIX ?>/admin/tranasctionsExport" class="btn btn-success"><i class="fa fa-download"></i> Export</a>
                        </div>
                        <div class="col-lg-4 col-md-5 col-xs-9">
                            <form method="GET">
                                <div class="input-group input-group-md">
                                    <input type="text" name="search" class="form-control pull-right" placeholder="By any tx data">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <ul class="pagination pagination-md no-margin">
                        <?= $this->Paginator->first('<< ' . __('First')) ?>
                        <?= $this->Paginator->prev('< ' . __('Prev')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('Next') . ' >') ?>
                        <?= $this->Paginator->last(__('Last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter() ?></p>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id', 'id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('email', 'Email') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('amount', 'Amount') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('currency', 'Currency') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('usd', 'USD equivalent') ?></th>
                            <th scope="col"><?= 'BTC/ETH' ?></th>
                            <th scope="col"><?= $this->Paginator->sort('created', 'Date') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('type', 'Type') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('rawdata', 'Raw data') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($transactions as $transaction): ?>
                        <tr style="<?= $transaction->amount < 0 ? 'background-color: #ffffa6' : '' ?>">
                            <td>
                                <a href="<?= URL_PREFIX ?>/admin/transaction/<?= h($transaction->id) ?>"><?= h($this->Number->format($transaction->id)) ?> </a>
                            </td>
                            <td>
                                <?= h($transaction->user->email) ?>
                            </td>
                            <td>
                                <?= h($transaction->amount) ?>
                            </td>
                            <td>
                                <?= h($transaction->currency) ?>
                            </td>
                            <td><?= h($transaction->usd) ?></td>
                            <td><?= empty($transaction->currencys_rate) ? '' :
                                h((json_decode($transaction->currencys_rate, true)['BTC'] . '/' . json_decode($transaction->currencys_rate, true)['ETH'])) ?></td>
                            <td><?= h($transaction->created) ?></td>
                            <td><?= h($transaction->type) ?></td>
                            <td><?= strlen($transaction->rawdata) > 20 ? '{JSON}' :
                                h($transaction->rawdata) ?></td>

                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix" style="border-top: none;">
                    <ul class="pagination pagination-md no-margin">
                        <?= $this->Paginator->first('<< ' . __('First')) ?>
                        <?= $this->Paginator->prev('< ' . __('Prev')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('Next') . ' >') ?>
                        <?= $this->Paginator->last(__('Last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter() ?></p>
                </div>
            </div>
        </div>
    </div>
</section>