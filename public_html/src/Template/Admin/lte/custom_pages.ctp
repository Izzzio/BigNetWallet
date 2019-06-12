<?php
/**
 * @var array $pages
 */
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Custom pages
        <small>Creates custom pages in cabinet.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= URL_PREFIX ?>/admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Develop</li>
        <li class="active">Cutom pages</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" class="form-horizontal">
                                <div class="input-group col-sm-6">
                                    <input name="alias" class="form-control" placeholder="Alias" required>
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-success btn-flat">
                                            <i class="fa fa-plus" aria-hidden="true"></i> Create New
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>

                    <?php
                    if (!empty($pages)) {
                        foreach ($pages as $page) {
                    ?>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-7 col-xs-12">
                                    <a href="<?= URL_PREFIX ?>/admin/customPage/<?= h($page['alias']) ?>">
                                        <?= h($page['alias']) ?>
                                    </a>
                                    &nbsp;&nbsp;
                                    <a href="<?= URL_PREFIX ?>/admin/deleteCustomPage/<?= h($page['alias']) ?>" class="btn btn-danger btn-xs">
                                        <i class="fa fa-times" aria-hidden="true"></i> Delete
                                    </a>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                    ?>
                        <h4>No custom pages</h4>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>