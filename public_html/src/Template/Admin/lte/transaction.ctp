<?php
/**
 * @var \App\Model\Entity\Transaction $tx
 */
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= __('View transaction') ?>
        <small>detailed information about transaction</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= URL_PREFIX ?>/admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= URL_PREFIX ?>/admin/transactions">Transactions</a></li>
        <li class="active">Transaction # <?= h($tx->id) ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Transaction # <?= h($tx->id) ?></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <b>Currency: </b><?= h($tx->currency) ?><br>
                            <b>Amount: </b><?= h($tx->amount) ?><br>
                            <b>USD equivalent: </b><?= h($tx->usd) ?><br>
                            <b>BTC/ETC equivalent: </b><?= h(json_decode($tx->currencys_rate, true)['BTC']) ?>/<?= h(json_decode($tx->currencys_rate, true)['ETH']) ?><br>
                            <b>Created: </b><?= h($tx->created) ?><br>
                            <b>Type: </b><?= h($tx->type) ?><br>
                            <b>Type (old): </b><?= h($tx->amount) < 0 ? 'Token buying' : 'Deposit' ?><br>
                            <b>Related entity: </b><?= h($tx->entity_id) ?><br>
                            <br>
                            <b>User: </b><a href="<?= URL_PREFIX ?>/admin/user/<?= h($tx->user->id) ?>"><?= h($tx->user->email) ?></a>
                        </div>
                        <div class="col-md-6">
                            <?php
                                $data = json_decode($tx->rawdata);
                                $data = (is_null($data)) ? h($tx->rawdata) : json_encode($data, JSON_PRETTY_PRINT);
                            ?>
                            <b>Raw data/Comment:</b><br>
                            <pre><code><?= h($data);?></code></pre>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?= URL_PREFIX ?>/admin/transactions ?>" class="btn btn-success">
                                <i class="fa fa-long-arrow-left"></i> All Transactions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>