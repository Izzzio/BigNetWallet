<?php
/**
 * @var string $script
 */

function params($params = [])
{
?>
    <div class="params">
        <b>Params:</b><br>
        <?php
            if (empty($params)) {
        ?>
            No params
        <?php
            } else {
                foreach ($params as $param => $descr) { ?>
                    <code>
                        <?= h($param) ?> - <?= h($descr) ?>
                    </code>
                <br>
                <?php
                }
            }
        ?>
    </div>
<?php
    return '';
}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Scripts, <?= __('Edit scripts') ?>
        <small>helps customize some page elements, financial calculations and adding additional functionality.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= URL_PREFIX ?>/admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Develop</li>
        <li class="active">Scripts</li>
    </ol>
    <br />
    <span class="label label-danger" style="font-size: 12px;">This section is for professionals only.</span><br><br>
    <a href="https://docs.google.com/document/d/1X07jAV66EJ9kTxaxBOgDG8Ibs8pHf9JNhtCJyu941Gc/edit?usp=sharing"
       target="_blank">iZ³ Tokensale platform Scripting guide&nbsp;&nbsp;<i class="fa fa-external-link" aria-hidden="true"></i></a><br>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Global variables</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <?= params([
                            '$domain'           => 'Current domain: ' . BASE_DOMAIN,
                    '$protocol'         => 'Current protocol: ' . BASE_PROTOCOL,
                    '$tokenName'        => 'Current token name: ' . \App\Lib\Misc::tokenName(),
                    '$supportEmail'     => 'Current support email: ' . \App\Lib\Misc::supportEmail(),
                    '$depositEnabled'   => 'Enabled deposit flag: ' . \App\Lib\Misc::depositEnabled(),
                    '$internalCurrency' => 'Working currency: ' . \App\Lib\Misc::internalCurrency(),
                    '$saleShowRatio'    => 'Showing ratio: ' . \App\Lib\Misc::saleShowRatio(),
                    '$currentLang'      => 'Current user language(en, ru, cn). You lang: ' . \Cake\I18n\I18n::locale(),
                    '$calculator'       => 'Calculator configuration array',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Calculator</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/usdToToken">usdToToken</a></h4>
                    <?= h(params(['$usd' => 'Input USD value'])) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/token2Usd">token2Usd</a></h4>
                    <?= h(params(['$tokens' => 'Input Tokens value'])) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/getTokenBonus">getTokenBonus</a></h4>
                    <?= h(params([
                        '$tokens'      => 'Input Tokens value',
                        '$date'        => 'NULL or date string',
                        '$sold_tokens' => 'Total sold tokens',
                        '$userId'      => 'User id',
                    ])) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Main template</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/periods">Periods</a></h4>
                    <?= h(params()) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/beforeClosedBody">beforeClosedBody</a></h4>
                    <?= h(params(['$user' => 'User array'])) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/beforeCss">beforeCss</a></h4>
                    <?= h(params(['$user' => 'User array'])) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/beforeClosedHead">beforeClosedHead</a></h4>
                    <?= h(params(['$user' => 'User array'])) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Login template</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/loginBeforeClosedBody">loginBeforeClosedBody</a>
                    </h4>
                    <?= h(params()) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/loginBeforeClosedHead">loginBeforeClosedHead</a>
                    </h4>
                    <?= h(params()) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Register template</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <h4>
                        <a href="<?= URL_PREFIX ?>/admin/script/registerBeforeClosedBody">registerBeforeClosedBody</a>
                    </h4>
                    <?= h(params()) ?>
                    <h4>
                        <a href="<?= URL_PREFIX ?>/admin/script/registerBeforeClosedHead">registerBeforeClosedHead</a>
                    </h4>
                    <?= h(params()) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Restore template</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/restoreBeforeClosedBody">restoreBeforeClosedBody</a>
                    </h4>
                    <?= h(params()) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/restoreBeforeClosedHead">restoreBeforeClosedHead</a>
                    </h4>
                    <?= h(params()) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Admin template</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/adminBeforeClosedBody">adminBeforeClosedBody</a>
                    </h4>
                    <?= h(params()) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Emails templates</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/restoreEmail">restoreEmail</a></h4>
                    <?= h(params(['$login' => 'User login', '$code' => 'Restore code'])) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/newPasswordEmail">newPasswordEmail</a></h4>
                    <?= h(params(['$login' => 'User login', '$password' => 'New user password'])) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/registerEmail">registerEmail</a></h4>
                    <?= h(params(['$login' => 'User login', '$code' => 'Verify code'])) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/kycFailEmail">kycFailEmail</a></h4>
                    <?= h(params(['$login' => 'User login', '$status' => 'KYC status'])) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/kycSuccessEmail">kycSuccessEmail</a></h4>
                    <?= h(params(['$login' => 'User login'])) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Emails hooks</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/beforeRestoreEmail">beforeRestoreEmail</a></h4>
                    <?= h(params(['$login' => 'User login', '$code' => 'Restore code'])) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/beforeNewPasswordEmail">beforeNewPasswordEmail</a>
                    </h4>
                    <?= h(params(['$login' => 'User login', '$password' => 'New user password'])) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/beforeRegisterEmail">beforeRegisterEmail</a></h4>
                    <?= h(params(['$login' => 'User login', '$code' => 'Verify code'])) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/beforeKYCFailEmail">beforeKYCFailEmail</a></h4>
                    <?= h(params(['$login' => 'User login', '$status' => 'KYC status'])) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/beforeKYCSuccessEmail">beforeKYCSuccessEmail</a>
                    </h4>
                    <?= h(params(['$login' => 'User login'])) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">SAFT</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/extraSaft">SAFT Element Extra</a></h4>
                    <?= h(params([])) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/saft-s">SAFT S - template</a></h4>
                    <?= h(params(['$user' => 'User array with: name, address, email'])) ?>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/saft-d">SAFT D - template</a></h4>
                    <?= h(params(['$user' => 'User array with: name, address, email'])) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Hooks</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <b>Scripts without interface</b><br>
                    <h4><a href="<?= URL_PREFIX ?>/admin/script/userEditProfile">userEditProfile @ $newProfileArray
                        | false</a></h4>
                    <?= h(params(['user' => 'User profile', 'userId' => 'Current user id'])) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">CPA hooks</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <span class="label label-danger" style="font-size: 12px;">
                        <b>Be careful! These hooks should work very fast.</b><br>
                    </span>
                    <h4>
                        <a href="<?= URL_PREFIX ?>/admin/script/<?= h(\App\Lib\CPA::CPA_REGISTER) ?>"><?= h(\App\Lib\CPA::CPA_REGISTER) ?></a>
                    </h4>
                    <?= h(params(['clickId' => 'CPA click id', 'userId' => 'Current user id'])) ?>
                    <h4>
                        <a href="<?= URL_PREFIX ?>/admin/script/<?= h(\App\Lib\CPA::CPA_CONFIRM) ?>"><?= h(\App\Lib\CPA::CPA_CONFIRM) ?></a>
                    </h4>
                    <?= h(params(['clickId' => 'CPA click id', 'userId' => 'Current user id','refUser'=>'Referral user id'])) ?>
                    <h4>
                        <a href="<?= URL_PREFIX ?>/admin/script/<?= h(\App\Lib\CPA::CPA_LOGIN) ?>"><?= h(\App\Lib\CPA::CPA_LOGIN) ?></a>
                    </h4>
                    <?= h(params(['clickId'   => 'CPA click id',
                    'userId'    => 'Current user id',
                    'loginInfo' => 'Info about session',
                    ])) ?>
                    <h4>
                        <a href="<?= URL_PREFIX ?>/admin/script/<?= h(\App\Lib\CPA::CPA_NEW_ORDER) ?>"><?= h(\App\Lib\CPA::CPA_NEW_ORDER) ?></a>
                    </h4>
                    <?= h(params([
                            'clickId'  => 'CPA click id',
                    'userId'   => 'Current user id',
                    'amount'   => 'Order amount',
                    'currency' => 'Order currency',
                    ])) ?>
                    <h4>
                        <a href="<?= URL_PREFIX ?>/admin/script/<?= h(\App\Lib\CPA::CPA_PAY) ?>"><?= h(\App\Lib\CPA::CPA_PAY) ?></a>
                    </h4>
                    <?= h(params([
                            'clickId'       => 'CPA click id',
                    'userId'        => 'Current user id',
                    'amount'        => 'Payment amount',
                    'currency'      => 'Payment currency',
                    'transactionId' => 'Input transaction id',
                    '$tokenAmount'  => 'Amount of tokens'
                    ])) ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .params {
        font-size: 12pt;
    }
</style>