<?php
/**
 * @var array $langs
 * @var \App\Model\Entity\Faq $faq
 */
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= __('FAQ editor') ?>
        <small>editing in different languages</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= URL_PREFIX ?>/admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= URL_PREFIX ?>/admin/faq">FAQ</a></li>
        <li class="active"><?= h($faq->q) ?></li>
    </ol>
</section>

<script src="https://cdn.ckeditor.com/ckeditor5/1.0.0-alpha.2/classic/ckeditor.js"></script>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form method="post" action="<?= URL_PREFIX ?>/admin/faqedit/<?= h($faq->id) ?>" id="faq" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-1 col-sm-2 control-label" for="question">Question</label>
                                    <div class="col-md-7 col-sm-10">
                                        <input name="q" class="form-control" id="question" value="<?= h($faq->q) ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-1 col-sm-2 control-label" for="editor">Answer</label>
                                    <div class="col-md-11 col-sm-10">
                                        <textarea name="a" class="editor" id="editor"><?= htmlspecialchars($faq->a) ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                            foreach ($langs as $lang) {
                                if ($lang === \Cake\Core\Configure::read('App.defaultLocale')) {
                                    continue;
                                }
                                $aKey = $lang . '_' . $faq->id . '_a';
                                $qKey = $lang . '_' . $faq->id . '_q'
                        ?>
                                <div class="row">
                                    <div class="col-md-12">
                                    <h2><small class="label bg-blue"><?= h($lang) ?></small></h2>
                                    <div class="form-group">
                                        <label class="col-md-1 col-sm-2 control-label" for="question">Question</label>
                                        <div class="col-md-7 col-sm-10">
                                            <input name="<?= h($qKey) ?>" id="question" class="form-control" value="<?= h(\App\Lib\KeyValue::read($qKey)) ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-1 col-sm-2 control-label" for="editor">Answer</label>
                                        <div class="col-md-11 col-sm-10">
                                            <textarea name="<?= h($aKey) ?>" class="editor" id="editor"><?= htmlspecialchars(\App\Lib\KeyValue::read($aKey)) ?></textarea>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                        <?php
                            }
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $('.editor').each(function (index, el) {
        console.log(el);
        ClassicEditor.create(el)
            .catch(function (error) {
                console.error(error);
            });
    });
</script>