<?php
/**
 * @var \App\Model\Entity\Comment[] $comments
 * @var int $bindingId
 * @var string $subsystem
 */
?>

<div class="container-fluid">
    <div class="row">
        <div class="panel panel-white">
            <div class="panel-body" id="task-list">
                <h2>Комментарии</h2>
                <div>
                    <?php foreach ($comments as $comment) { ?>
                        <div class="col-md-8">
                            <?= h($comment->comment) ?>
                        </div>
                        <div class="col-md-4" style="text-align: center">
                            <b><?= h($comment->Users->first_name . ' ' . $comment->Users->last_name) ?></b><br>
                            <?= $comment->created ?>
                        </div>
                        <br>
                        <hr>
                        <?php
                    }
                    ?>
                    <h3>Добавить комментарий</h3>
                    <form action="/app/addComment" method="post">
                        <input name="binding_id" value="<?= $bindingId ?>" type="hidden">
                        <input name="subsystem" value="<?= $subsystem ?>" type="hidden">
                        <textarea name='comment' class="form-control" rows="10" placeholder="Напишите текст комментария"
                                  required></textarea>
                        <button type="submit" class="btn btn-primary btn-block">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
