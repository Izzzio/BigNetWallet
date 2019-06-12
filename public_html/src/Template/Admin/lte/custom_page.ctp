<?php
/**
 * @var string $script
 * @var string $scriptSource
 * @var string $editor
 */
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/ace.js"
        integrity="sha256-U//RSeH3TR3773Rk+1lAufJnRjEaG5LcdbvGV72kHEM=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/mode-php.js"
        integrity="sha256-f49lfF9pLCZR2NZgxoZsad63dH+Cbq0Po+YprUqCtE4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/snippets/php.js"
        integrity="sha256-7B9g1/8cQFMfN9slrUI+x2gWUevJPhWH+R4ZIfIHqWY=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/worker-php.js"
        integrity="sha256-csBZqptmXXFPrR+UVnBc0LJn3z8Bsl+Rzcni1fk1DbU=" crossorigin="anonymous"></script>

<style type="text/css" media="screen">
    #editor {
        height: 50vh;
    }

    .alert {
        color: #0f0f0f !important;
    }
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= __('Edit page') . ' "' . h($script) .'"' ?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= URL_PREFIX ?>/admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= URL_PREFIX ?>/admin/customPages">Custom pages</a></li>
        <li class="active"><?= h($script) ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="POST" id="scriptForm"
                                  action="<?= URL_PREFIX ?>/admin/customPage/<?= h($script) ?>/<?= h($editor) ?>">
                                <?php
                            if ($editor === 'php') {
                                ?>
                                <a href="<?= URL_PREFIX ?>/admin/customPage/<?= h($script) ?>/html"
                                   onclick="return confirm('HTML Editor does not support the PHP code. Code will be deleted!  All unsaved data will be lost! Are you sure?')"
                                   class="btn btn-primary btn-xs"
                                   style="margin-bottom: 10px;"
                                >
                                    Toggle to HTML editor</a>
                                <div id="editor"><?= htmlspecialchars($scriptSource) ?></div>
                                <input type="hidden" id="script" name="script">
                                <br />
                                <button type="button" id="save" class="btn btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                                <?php
                            } else {
                                ?>
                                <a href="<?= URL_PREFIX ?>/admin/customPage/<?= h($script) ?>/php"
                                   onclick="return confirm('All unsaved data will be lost! Are you sure?')"
                                    class="btn btn-primary btn-xs"
                                    style="margin-bottom: 10px;"
                                >
                                    Toggle to PHP editor</a>
                                <textarea name="script" class="editor"><?= htmlspecialchars($scriptSource) ?></textarea>
                                <br />
                                <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                                <?php
                            }
                            ?>
                                &nbsp;&nbsp;
                                <a href="<?= URL_PREFIX ?>/custom/call/<?= h($script) ?>" target="_blank" class="btn btn-success">
                                    <i class="fa fa-eye"></i> View page
                                </a>
                                &nbsp;&nbsp;
                                <a href="<?= URL_PREFIX ?>/admin/customPages" class="btn btn-success">
                                    <i class="fa fa-long-arrow-left"></i> List pages
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.ckeditor.com/ckeditor5/1.0.0-alpha.2/classic/ckeditor.js"></script>
<script>
    <?php if($editor === 'php'){?>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/php");

    $('#save').click(function () {
        $('#script').val(editor.getValue());
        $('#scriptForm').submit();
    });
    <?php
    }else{
    ?>
    var editor;
    $('.editor').each(function (index, el) {
        editor = ClassicEditor.create(el,{})
            .catch(function (error) {
                console.error(error);
            });
    });

    <?php
    } ?>
</script>