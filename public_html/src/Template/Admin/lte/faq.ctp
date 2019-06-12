<?php
/**
 * @var array $langs
 * @var \App\Model\Entity\Faq[] $faqs
 */
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= __('FAQ') ?>
        <small>Frequently Asked Questions manage</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= URL_PREFIX ?>/admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Manage FAQ</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Main info</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <b>FAQ status:</b> <?= h(\App\Lib\Misc::tcfg('enableFAQ')) ? 'Enabled' : 'Disabled' ?><br>
                            <b>Total questions: </b><?= h(\App\Model\Table\FaqTable::f()->count()) ?><br>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="<?= URL_PREFIX ?>/admin/faq" method="post">
                                <button type="submit" name="addnew" value="addnew" class="btn btn-success">
                                    <i class="fa fa-plus" aria-hidden="true"></i> <?= __('Add new') ?>
                                </button>
                            </form>
                        </div>
                    </div>
                    <br>
                    <?php
                    foreach ($faqs as $faq) {
                    ?>

                    <div class="row">
                        <div class="col-md-7 col-xs-12">
                            <div class="col-md-10 col-xs-8 text-center">
                                <a href="<?= URL_PREFIX ?>/admin/faqedit/<?= h($faq->id) ?>"> <?= h($faq->q) ?></a>
                            </div>
                            <div class="col-md-2 col-xs-4 text-right">
                                <a href="<?= URL_PREFIX ?>/admin/faqdelete/<?= h($faq->id) ?>" class="btn btn-danger">
                                    <i class="fa fa-times" aria-hidden="true"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr style="width: 95%">

                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>