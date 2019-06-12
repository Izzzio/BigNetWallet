<?php
/**
 * @var string $script
 * @var string $scriptSource
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
    .alert{
        color: #0f0f0f!important;
    }
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= __('Edit script') . ' "' . h($script) .'"' ?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= URL_PREFIX ?>/admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?= URL_PREFIX ?>/admin/scripts">Scripts</a></li>
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
                            <div id="editor"><?= htmlspecialchars($scriptSource) ?></div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-1 col-xs-3">
                            <form method="POST" id="scriptForm" action="<?= URL_PREFIX ?>/admin/script/<?= h($script) ?>" >
                                <input type="hidden" id="script" name="script">
                                <button type="button" id="save" class="btn btn-success"><i class="fa fa-floppy-o"></i> Save</button>
                            </form>
                        </div>
                        <div class="col-md-2 col-xs-5">
                            <a href="<?= URL_PREFIX ?>/admin/scripts" class="btn btn-success">
                                <i class="fa fa-long-arrow-left"></i> List scripts
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/php");

    $('#save').click(function () {
        $('#script').val(editor.getValue());
        $('#scriptForm').submit();
    });
</script>