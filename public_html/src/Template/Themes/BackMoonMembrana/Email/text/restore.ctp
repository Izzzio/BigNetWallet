<?php
/**
 * @var string $login
 * @var string $code
 */
$result = \App\Lib\Sandbox::runFromStorageOrIgnore('restoreEmail', ['login' => $login, 'code' => $code]);
if ($result !== false) {
    return $result;
}
?>

Dear user,

Someone, maybe you, has just requested password restore at <?= \App\Lib\Misc::projectName() ?>.

To recover the password, please, click the link:
<?= URL_PREFIX ?>/app/restore/<?= $code ?>

Your login: <?= $login ?>

In case you did not request to change password, please IGNORE THIS MESSAGE.

<?= \Cake\Core\Configure::read('App.emails.sign') ?>