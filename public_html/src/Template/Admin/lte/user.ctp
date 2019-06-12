<?php
/**
 * @var \App\Model\Entity\User $editUser
 * @var \App\Model\Entity\Transaction[] $txs
 * @var \App\Model\Entity\UserSettings $tfa
 */
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= __('Edit user') . ' ' . h($editUser->email) ?>
        <small>update user data</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= URL_PREFIX ?>/admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= URL_PREFIX ?>/admin/users">Users</a></li>
        <li class="active">User <?= h($editUser->id) ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <a href="<?= URL_PREFIX ?>/admin/sendConfirmationEmail/<?= h($editUser->id) ?>" class="btn btn-success">
                        Send email confirmation
                    </a>
                    <a href="<?= URL_PREFIX ?>/admin/confirmUser/<?= h($editUser->id) ?>" class="btn btn-success">
                        Verify user
                    </a>
                    <?php if (!empty(\Cake\Core\Configure::read('App.enableSaftDataFilling'))) {
                        if (!empty($editUser->getSaftData())) {
                    ?>
                    <a target="_blank"
                       href="<?= URL_PREFIX ?>/pages/saft/<?= @($editUser->getSaftData()->country != 'United States' ?
                                   's' :
                                   'd') ?>" class="btn btn-success">
                        View user SAFT
                    </a>
                    <?php }
                        ?>

                    <?php
                    } ?>

                    <form style="display: inline;" action="<?= URL_PREFIX ?>/admin/confirmKYC/<?= h($editUser->id) ?>" method="POST">
                        <button
                                class="btn btn-success"><?= $editUser->kyc_reached == \App\Model\Entity\User::KYC_REACHED ?
                            'Set KYC unverified' : 'Set KYC verified' ?></button>
                    </form>

                    <form style="display: inline;" action="<?= URL_PREFIX ?>/admin/disable2FA/<?= h($editUser->id) ?>" method="POST">
                        <button class="btn btn-success">Toggle 2FA</button>
                    </form>


                    <?= $this->Form->create($editUser, ['class' => 'form-horizontal']) ?>

                        <div class="row">
                            <div class="col-md-12">
                                <h3>Main user data</h3>

                                <b>User balance: </b><?= h($editUser->balance) ?><br>
                                <b>User tokens (summary): </b><?= h($editUser->tokens - $editUser->in_chain) ?><br>
                                <b>Tokens withdrawed (in chain): </b><?= h($editUser->in_chain) ?><br>
                                <b>Bonus tokens: </b><?= h($editUser->tokens_bonus) ?><br>
                                <b>CPA click id: </b><?= h($editUser->clickid) ?><br>
                                <b>Verified: </b><?= $editUser->status == 1 ? 'Yes' : 'No' ?><br>
                                <b>2FA enabled: </b><?= ($tfa && $tfa->value == 1) ? 'Yes' : 'No' ?><br>
                                <b>KYC Verified: </b><?= $editUser->kyc_reached == \App\Model\Entity\User::KYC_REACHED ?
                                'Yes' : 'No' ?><br>
                                <b>24 hours restore url: </b><?= URL_PREFIX ?>/app/restore/<?= h(\App\Lib\Misc::makeRestoreCode($editUser->clickid)) ?><br>
                                <b>Referred by: </b><?= empty($editUser->ref_user) ? 'Not referred' :
                                '<a href="' . URL_PREFIX . '/admin/user/' . h($editUser->ref_user) . '">' . h(\App\Model\Table\UsersTable::instance()->get($editUser->ref_user)->email) . '</a>' ?>
                                <br>
                                <b>Role: </b><?= h($editUser->roles); ?><br>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <h3>Regular data</h3>
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label('email', null, ['class' => 'col-sm-2 control-label']);
                                    echo $this->Form->input(
                                    'email',
                                    [
                                    'templates' => [
                                    'inputContainer' => '<div class="col-sm-10">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-sm-10 ">{{content}}{{error}}</div>'
                                    ],
                                    'class' => 'form-control',
                                    'label' => false
                                    ]
                                    );?>
                                </div>

                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label('phone', null, ['class' => 'col-sm-2 control-label']);
                                    echo $this->Form->input(
                                    'phone',
                                    [
                                    'templates' => [
                                    'inputContainer' => '<div class="col-sm-10">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-sm-10 ">{{content}}{{error}}</div>'
                                    ],
                                    'class' => 'form-control',
                                    'label' => false
                                    ]
                                    );?>
                                </div>

                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label('wallet', null, ['class' => 'col-sm-2 control-label']);
                                    echo $this->Form->input(
                                    'wallet',
                                    [
                                    'templates' => [
                                    'inputContainer' => '<div class="col-sm-10">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-sm-10 ">{{content}}{{error}}</div>'
                                    ],
                                    'class' => 'form-control',
                                    'label' => false
                                    ]
                                    );?>
                                </div>

                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label('name', null, ['class' => 'col-sm-2 control-label']);
                                    echo $this->Form->input(
                                    'name',
                                    [
                                    'templates' => [
                                    'inputContainer' => '<div class="col-sm-10">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-sm-10 ">{{content}}{{error}}</div>'
                                    ],
                                    'class' => 'form-control',
                                    'label' => false
                                    ]
                                    );?>
                                </div>

                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label('age', null, ['class' => 'col-sm-2 control-label']);
                                    echo $this->Form->input(
                                    'age',
                                    [
                                    'templates' => [
                                    'inputContainer' => '<div class="col-sm-10">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-sm-10 ">{{content}}{{error}}</div>'
                                    ],
                                    'class' => 'form-control',
                                    'label' => false
                                    ]
                                    );?>
                                </div>

                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label('country', null, ['class' => 'col-sm-2 control-label']);
                                    echo $this->Form->input(
                                    'country',
                                    [
                                    'templates' => [
                                    'inputContainer' => '<div class="col-sm-10">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-sm-10 ">{{content}}{{error}}</div>'
                                    ],
                                    'class' => 'form-control',
                                    'label' => false
                                    ]
                                    );?>
                                </div>

                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label('roles', null, ['class' => 'col-sm-2 control-label']);
                                    echo $this->Form->input(
                                    'roles',
                                    [
                                    'templates' => [
                                    'inputContainer' => '<div class="col-sm-10">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-sm-10 ">{{content}}{{error}}</div>'
                                    ],
                                    'class' => 'form-control',
                                    'label' => false,
                                    'type'  => 'select',
                                    'options'   => \App\Controller\AclController::getRoles()
                                    ]
                                    );?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-10">
                                <h3>Bonus management</h3>
                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label('personal_referal_bonus', 'Additional bonus by referral', ['class' => 'col-sm-3 control-label']);
                                    echo $this->Form->input(
                                    'personal_referal_bonus',
                                    [
                                    'templates' => [
                                    'inputContainer' => '<div class="col-sm-3">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-sm-3 ">{{content}}{{error}}</div>'
                                    ],
                                    'class' => 'form-control',
                                    'label' => false,
                                    'step'  => '0.00000001'
                                    ]
                                    );?>
                                </div>

                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label('bonus_for_referals', 'Additional buying bonus for all referrals', ['class' => 'col-sm-3 control-label']);
                                    echo $this->Form->input(
                                    'bonus_for_referals',
                                    [
                                    'templates' => [
                                    'inputContainer' => '<div class="col-sm-3">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-sm-3 ">{{content}}{{error}}</div>'
                                    ],
                                    'class' => 'form-control',
                                    'label' => false,
                                    'step'  => '0.00000001'
                                    ]
                                    );?>
                                </div>

                                <div class="form-group">
                                    <?php
                                    echo $this->Form->label('personal_bonus', 'Personal additional bonus', ['class' => 'col-sm-3 control-label']);
                                    echo $this->Form->input(
                                    'personal_bonus',
                                    [
                                    'templates' => [
                                    'inputContainer' => '<div class="col-sm-3">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-sm-3 ">{{content}}{{error}}</div>'
                                    ],
                                    'class' => 'form-control',
                                    'label' => false,
                                    'step'  => '0.00000001'
                                    ]
                                    );?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <h3>Special and system fields</h3>
                                <div class="form-group">
                                    <?php
                                        echo $this->Form->label('clickid', null, ['class' => 'col-sm-2 control-label']);
                                    echo $this->Form->input(
                                    'clickid',
                                    [
                                    'templates' => [
                                    'inputContainer' => '<div class="col-sm-10">{{content}}</div>',
                                    'inputContainerError' => '<div class="col-sm-10 ">{{content}}{{error}}</div>'
                                    ],
                                    'class' => 'form-control',
                                    'label' => false
                                    ]
                                    );?>
                                </div>
                            </div>
                        </div>

                        <?php
                            //echo $this->Form->input('balance');
                        ?>

                        <br />
                        <button type="submit" class="btn btn-lg btn-success"><?= __('Save') ?></button>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">User transactions</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Currency</th>
                            <th scope="col">USD equivalent</th>
                            <th scope="col">Created</th>
                            <th scope="col">Type</th>
                            <th scope="col">Comment</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($txs as $transaction): ?>
                            <tr style="<?= $transaction->amount < 0 ? 'background-color: #ffffa6' : '' ?>">
                                <td>
                                    <a href="<?= URL_PREFIX ?>/admin/transaction/<?= h($transaction->id) ?>"><?= h($this->Number->format($transaction->id)) ?> </a>
                                </td>
                                <td>
                                    <?= h(($transaction->amount)) ?>
                                </td>
                                <td>
                                    <?= h($transaction->currency) ?>
                                </td>
                                <td><?= h($transaction->usd) ?></td>
                                <td><?= h($transaction->created) ?></td>
                                <td><?= h($transaction->type) ?></td>
                                <td><?= strlen($transaction->rawdata) > 32 ? '{JSON}' :
                                    h($transaction->rawdata) ?></td>

                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">New transactions</h3>
                </div>
                <div class="box-body">
                    <form action="<?= URL_PREFIX ?>/admin/transact/<?= h($editUser->id) ?>" method="post" id="create-transaction-usd" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-7">
                                <h3>USD transaction</h3>
                                <label for="amount" class="col-sm-3 control-label">USD amount:</label>
                                <div class="input-group col-sm-6">
                                    <input type="number" class="form-control" value="0" min="0" name="amount" id="amount" step="0.00000001">
                                    <input type="hidden" value="0" name="notify">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success btn-flat" type="submit">Create transaction</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form action="<?= URL_PREFIX ?>/admin/transactTokens/<?= h($editUser->id) ?>" method="post" id="create-transaction-token" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-7">
                                <h3>Token transaction</h3>
                                <label for="amount" class="col-sm-3 control-label">Token amount:</label>
                                <div class="input-group col-sm-6">
                                    <input type="number" class="form-control" value="0" min="0" name="amount" id="amount" step="0.00000001">
                                    <input type="hidden" value="0" name="notify">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success btn-flat" type="submit">Create transaction</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form action="<?= URL_PREFIX ?>/admin/withdrawTokens/<?= h($editUser->id) ?>" method="post" id="create-transaction-token" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-7">
                                <h3>Withdraw tokens</h3>
                                <label for="amount" class="col-sm-3 control-label">Token amount:</label>
                                <div class="input-group col-sm-6">
                                    <input type="number" class="form-control" value="0" min="0" name="amount" id="amount" step="0.00000001">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success btn-flat" type="submit">Create transaction</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br />
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Referals</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col"><?= __('User') ?></th>
                            <th scope="col"><?= __('Registration date') ?></th>
                            <th scope="col"><?= __('Tokens') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($refs as $ref): ?>
                            <tr>
                                <td>
                                    <a href="<?= URL_PREFIX ?>/admin/user/<?= h($ref['id']) ?>">   <?= h($ref['name']) ?></a>
                                </td>
                                <td><?= h($ref['created']) ?></td>
                                <td>
                                    <?= h($ref['amount']) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

    <?php
    /**
     * @var \App\Model\Entity\KycAttempts[] $kycAttempts
     */
    $kycAttempts = \App\Model\Table\KycAttemptsTable::f()->where(['user_id'=>$editUser->id])->order(['start'=>'DESC']);
    if (!empty($kycAttempts)) { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">KYC attempts</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Start</th>
                                <th scope="col">End</th>
                                <th scope="col">Applicant id</th>
                                <th scope="col">Status</th>
                                <th scope="col">Show raw</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($kycAttempts as $attempt) {?>
                            <tr style="<?=empty($attempt->finish) ? 'background-color: #ffffa6' : '' ?>">
                                <td>
                                    <?= h($attempt->id) ?>
                                </td>
                                <td>
                                    <?= h($attempt->start) ?>
                                </td>
                                <td>
                                    <?= empty($attempt->finish)?'Pending...':h($attempt->finish) ?>
                                </td>
                                <td><?= h($attempt->applicant_id) ?></td>
                                <td><?= h($attempt->comment) ?></td>
                                <td><a class="showRaw" style="cursor: pointer" data-data='<?= h(str_replace("\n", "", $attempt->result)) ?>'>Show</a> </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">User info</h3>
                </div>
                <div class="box-body">
                    <h3>User data</h3>
                    <?php
                        if (!empty($editUser->getSaftData())) {
                            foreach ($editUser->getSaftData() as $field => $data) {?>
                                <b><?= h($field) ?>: </b><?= h($data) ?><br>
                    <?php
                            }
                        }
                    ?>
                    <br />
                    <h3>User Files</h3>
                        <?php
                        $files = (new \Cake\Filesystem\Folder(\App\Lib\Misc::userUploadPath($editUser->id)))->read()[1];
                        foreach ($files as $file) {
                        ?>
                            <a href="<?= h(\Cake\Core\Configure::read('App.fullBaseUrl')) . '/admin/getUserFile/' . h($editUser->id) . '/' . urlencode($file) ?>"
                            target="_blank"><?= h($file) ?></a><br>
                        <?php
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
</section>