<?php
/**
 * @var \App\Model\Entity\User[] $users
 */
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Users
        <small>list of all users</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= URL_PREFIX ?>/admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Users</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-2 col-xs-3">
                            <a href="<?= URL_PREFIX ?>/admin/userExport" class="btn btn-success"><i class="fa fa-download"></i> Export</a>
                        </div>
                        <div class="col-lg-4 col-md-5 col-xs-9">
                            <form method="GET" action="<?= URL_PREFIX ?>/admin/users">
                                <div class="input-group input-group-md">
                                    <input type="text" name="search" class="form-control pull-right" placeholder="Email or name">
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
                <div class="box-header" style="padding-bottom: 0px;">
                    <ul class="pagination pagination-md no-margin">
                        <?= $this->Paginator->first('<< ' . __('First')) ?>
                        <?= $this->Paginator->prev('< ' . __('Prev')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('Next') . ' >') ?>
                        <?= $this->Paginator->last(__('Last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter() ?></p>
                </div>
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('id', 'id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('email', 'Email') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('status', 'Email Verified') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('kyc_reached', 'KYC Passed') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('balance', 'Balance') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('tokens', 'Tokens') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('tokens', 'Tokens bonus') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('in_chain', 'Tokens on wallet') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('wallet', 'Wallet address') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('country', 'Country') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('roles', 'Role') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('created', 'Registration date') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <a href="<?= URL_PREFIX ?>/admin/user/<?= h($user->id) ?>"><?= h($this->Number->format($user->id)) ?> </a>
                                </td>
                                <td style="text-align: center">
                                    <?= h($user->email) ?>
                                </td>
                                <td style="text-align: center">
                                    <?= ($user->status == 1 ? 'Yes' : '') ?>
                                </td>
                                <td style="text-align: center">
                                    <?= ($user->kyc_reached == \App\Model\Entity\User::KYC_REACHED ? 'Yes' : 'No') ?>
                                </td>
                                <td style="text-align: center">
                                    <?= h($user->balance) ?>
                                </td>
                                <td style="text-align: center">
                                    <?= h($user->tokens - $user->in_chain) ?>
                                </td>
                                <td style="text-align: center">
                                    <?= h($user->tokens_bonus) ?>
                                </td>
                                <td style="text-align: center">
                                    <?= h($user->in_chain) ?>
                                </td>
                                <td><?= h($user->wallet) ?></td>
                                <td><?= h($user->country) ?></td>
                                <td><?= h($user->roles) ?></td>
                                <td><?= h($user->created) ?></td>

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