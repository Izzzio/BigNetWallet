<?php
/**
 * @var \App\Model\Entity\Log[] $logs
 * @var string $search
 */
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= __('Info Logs') ?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= URL_PREFIX ?>/admin/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><?= __('Info Logs') ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-5 col-xs-9">
                            <form method="GET">
                                <div class="input-group input-group-md">
                                    <input type="text" name="search" value="<?= h($search) ?>" class="form-control pull-right" placeholder="By any data">
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
                        <?= $this->Paginator->prev('< ' . __('Next')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('Prev') . ' >') ?>
                        <?= $this->Paginator->last(__('Last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter() ?></p>
                </div>
                <div class="box-body table-responsive" style="padding-top: 0px;">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id', '#') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('type', 'Type') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('email', 'User email') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('created', 'Date') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('data', 'Entry data') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($logs as $log) { ?>
                        <tr style="<?= $log->amount < 0 ? 'background-color: #ffffa6' : '' ?>">
                            <td><?= h($this->Number->format($log->id)) ?></td>
                            <td><?= h($log->type) ?></td>
                            <td>
                                <?php if (!empty($log->user)) { ?>
                                <a href="<?= URL_PREFIX ?>/admin/user/<?= h($log->user->id) ?>"> <?= h(empty($log->user->email) ?
                                    '' : h($log->user->email)) ?></a>
                                <?php } ?>
                            </td>
                            <td><?= h($log->created) ?></td>
                            <td data-data="<?= htmlentities($log->data) ?>"><?= strlen($log->data) > 40 ?
                                '<a href="#" class="showData">Show</a>' : h($log->data) ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix" style="border-top: none;">
                    <ul class="pagination pagination-md no-margin">
                        <?= $this->Paginator->first('<< ' . __('First')) ?>
                        <?= $this->Paginator->prev('< ' . __('Next')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('Prev') . ' >') ?>
                        <?= $this->Paginator->last(__('Last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter() ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="showMore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel">More info</h5>
            </div>
            <div class="modal-body" style="overflow-y: auto;" id="showMoreInfoText">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<script>
    $('.showData').click(function () {
        var data = $(this).parent().data('data');

        if(typeof data !== 'string') {
            data = "JSON OBJECT: \n" + JSON.stringify(data, "", 4);
        }

        data = data.replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
            return '&#'+i.charCodeAt(0)+';';
        });
        data = data.replace(/\n/gi, "<br>");
        data = data.replace(/ /gi, "&nbsp;");

        $('#showMoreInfoText').html(data);
        $('#showMore').modal();
        //alert(data);
    });
</script>