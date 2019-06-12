<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= \App\Lib\Misc::projectName() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="msapplication-TileColor" content="#603cba">
    <link rel="shortcut icon" href="<?= \App\Lib\Misc::tcfg('favicon') ?>">
    <meta name="theme-color" content="#ffffff">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/sign.css?_=<?= rand() ?>">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE  ?>/style/flash.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE  ?>/css/select2.min.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE  ?>/bootstrap/datepicker/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_CSS_BASE ?>/customize.css?_=<?= CORE_VERSION ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
          integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <?= $this->element('ga'); ?>
    <?= $this->element('gtag'); ?>

    <?php
    \App\Lib\Sandbox::runFromStorageOrIgnore('registerBeforeClosedHead');
    ?>

    <style>
        .checkboxText{
            display: inline;
        }
    </style>

</head>
<body class="register-body">


<?= $this->Flash->render() ?>
<div class="site sign-up-page register-site" id="site">
    <div class="sign-header row">

        <div class="sign-name sign-header-col">
            <a href="<?= \App\Lib\Misc::mainSite() ?>">
                <picture>
                    <source
                            srcset="<?= \App\Lib\Misc::tcfg('logo') ?>">
                    <img src="<?= \App\Lib\Misc::tcfg('logo') ?>"
                         alt="logo">
                </picture>
            </a>
        </div>


    </div>
    <div class="sign-block-wrapper">
        <div class="sb-bg1 sb-bg">
            <picture>
                <source
                        srcset="/img/sb-bg1.png,
										/img/sb-bg1_2x.png 2x">
                <img class="sb-bg" src="/img/sb-bg1.png"
                     alt="">
            </picture>
        </div>
        <div class="sb-bg2 sb-bg">
            <picture>
                <source
                        srcset="/img/sb-bg2.png,
										/img/sb-bg2_2x.png 2x">
                <img class="sb-bg" src="/img/sb-bg2.png"
                     alt="">
            </picture>
        </div>
        <div class="sign-block">
            <form class="sign-up-form" action="<?= URL_PREFIX ?>/app/register" method="POST">
                <input name="_CSRF" type="hidden" value="<?= \App\Lib\Crypt::ecrypt('CSRF_' . rand()) ?>">
                <input type="hidden" name="registration_data" value="">
                <fieldset class="form-step form-step1 active">
                    <div class="sign-block-title"><?= __('Sign up') ?></div>
                    <div class="input-block">
                        <label for="email">Email</label>
                        <input class="input-field" type="text" name="email" id="email" <?= empty($email) ? '' :
                            'value="' . $email . '"' ?> required>
                        <span style="color: red; font-size: 12px; padding-left: 12px" id="emailError"></span>
                    </div>
                    <div class="input-block">
                        <label for="pass"><?= __('Password') ?></label>
                        <input class="input-field" type="password" name="password" id="pass" autocomplete="off"
                               required style="width: 87%;">
                        <span toggle="#password-field" class="field-icon toggle-password" data-password-view="click">
                            <i class="fa fa-fw fa-eye-slash"></i>
                        </span>
                        <span style="color: red; font-size: 12px; padding-left: 12px; display: none"
                              id="passwordError"><?= __('at least 8 characters, one lowercase letter,  one uppercase letter') ?></span>
                    </div>
                    <div class="input-block">
                        <label for="pass-conf"><?= __('Repeat password') ?></label>
                        <input class="input-field" name="passwordRepeat" type="password" id="pass-conf"
                               required style="width: 87%;">
                    </div>
                    <div class="checkbox checkbox3">
                        <input id="check3" class="checkbox-field" type="checkbox" required>
                        <label class="checkbox-label" for="check3">
								<span>
								</span><div class="checkboxText"><?=__('I agree with')?></div> <a href="<?= \App\Lib\Misc::policyUrl() ?>"
                                                                  target="_blank" class="checkboxHref"> Privacy Policy</a> </label>
                    </div>
                    <div class="checkbox checkbox1">
                        <input id="check1" class="checkbox-field" type="checkbox" required>
                        <label class="checkbox-label" for="check1">
								<span>
                                </span><div class="checkboxText"><?=__('I agree with')?></div> <a href="<?= \App\Lib\Misc::whitepaperUrl() ?>"
                                                                  target="_blank" class="checkboxHref"> Whitepaper</a> </label>
                    </div>
                    <div class="checkbox checkbox2">
                        <input id="check2" class="checkbox-field" type="checkbox" required>
                        <label class="checkbox-label" for="check2">
								<span>
                                </span><div class="checkboxText"><?=__('I agree with')?></div> <a
                                href="<?= \Cake\Core\Configure::read('App.tokenSaleAgreement') ?>" id="TSA"
                                target="_blank"  class="checkboxHref"> Token Sale
                            Agreement</a></label>
                    </div>
                    <div class="input-block sbm-block">
                        <?php if (\Cake\Core\Configure::read('App.enableUserData')) { ?>
                        <input type="button" name="next" class="btn-sbm btn-next" value="<?= __('Continue') ?>"/>
                        <?php } else { ?>
                        <input type="submit" class="btn-sbm" value="<?= __('Continue') ?>"/>
                        <?php } ?>
                    </div>
                    <a class="sign-link" href="<?= URL_PREFIX ?>/app/login"><?= __('Sign in') ?></a>
                </fieldset>
                <?php if (\Cake\Core\Configure::read('App.enableUserData')) { ?>
                <fieldset class="form-step form-step2">
                    <div class="sign-block-title"><?= __('Almost done') ?></div>
                    <div class="input-block">
                        <label for="name"><?= __('Full name') ?></label>
                        <input class="input-field <?= \Cake\Core\Configure::read('App.enableSaftDataFilling') ?
                                'disabled' : '' ?>" type="text" name="name" id="name" required>
                    </div>

                    <div class="input-block row">
                        <?php if (!\Cake\Core\Configure::read('App.enableSaftDataFilling')) { ?>
                        <div class="input-block-col">
                            <label for="age"><?= __('Age') ?></label>
                            <input class="input-field" type="text" id="age" pattern="\d\d" name="age" required>
                        </div>

                        <div class="input-block-col">
                            <label for="country"><?= __('Country') ?></label>
                            <div class="select-wrapper">
                                <select class="input-field <?= \Cake\Core\Configure::read('App.enableSaftDataFilling') ?
                                            'disabled' : '' ?>" type="text" id="country" name="country" required>
                                    <option value="" selected></option>
                                    <?php foreach (\App\Lib\Misc::COUNTRY as $country) {
                                                ?>
                                    <option value="<?= $country ?>"><?= $country ?></option>
                                    <?php
                                            } ?>

                                </select>
                                <div class="select-arrow">
                                </div>
                            </div>
                        </div>
                        <?php } else {
                                ?>
                        <input type="hidden" id="age" name="age">
                        <input type="hidden" id="country" name="country">
                        <?php
                            } ?>
                    </div>
                    <div class="input-block">
                        <label for="phone"><?= __('Phone') ?></label>
                        <input class="input-field <?= \Cake\Core\Configure::read('App.enableSaftDataFilling') ?
                                'disabled' : '' ?>" type="text" name="phone" id="phone" required>
                    </div>
                    <?php if (\Cake\Core\Configure::read('App.enableSaftDataFilling')) { ?>
                    <div>
                        <a href="" class="btn btn-block btn-primary" style="font-size: 20px;" id="fillSaftData"
                           onclick="openSaftModal()">Edit personal data</a>
                    </div>
                    <?php } ?>
                    <div class="input-block sbm-block">
                        <input type="submit" name="next" class="btn-sbm" id="doneButton" value="<?= __('Done') ?>"/>
                    </div>
                </fieldset>
                <?php } ?>
            </form>
        </div>
    </div>
</div>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/jquery-1.12.4.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/jquery.maskedinput.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/select2.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/bootstrap/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?= URL_PREFIX ?>/js/additional.js"></script>
<script>

    function checkerClick(e) {
        e.preventDefault();
        if($('#pass').val() !== $('#pass-conf').val()) {
            alert('Passwords do not match');
            return;
        }

        if($('#email').val().length === 0) {
            alert('Email required');
            return;
        }

        if($('#pass').val().length === 0) {
            alert('Password required');
            return;
        }

        if(!($('#check1').is(':checked') && $('#check2').is(':checked') && $('#check3').is(':checked'))) {
            alert('Accept our rules');
            return;
        }




        <?php if (\Cake\Core\Configure::read('App.enableSaftDataFilling')) { ?>
        openSaftModal();
        $('.sign-up-form').off('submit', checkerClick);
        <?php }elseif (\Cake\Core\Configure::read('App.enableUserData')){?>
        $(this).closest(".form-step").removeClass("active");
        $(this).closest(".form-step").next(".form-step").addClass("active");
        $(".btn-sbm").off("click", checkerClick);
        $('.sign-up-form').off('submit', checkerClick);
        <?php
        }else{?>

        $(".btn-sbm").off("click", checkerClick);
        $('.sign-up-form').off('submit', checkerClick);
        $('.sign-up-form').submit();
        <?php

        } ?>


    }

    $(".btn-sbm").on("click", checkerClick);
    $('.sign-up-form').on('submit', checkerClick);


    /* $('.sign-up-form').submit(function(e){
         e.preventDefault();
         if($('#pass').val()!==$('#pass-conf').val()){
             alert('Passwords do not match');
             return;
         }
         $(this).closest(".form-step").removeClass("active");
         $(this).closest(".form-step").next(".form-step").addClass("active");
     });*/

    $('.close').click(function () {
        $(this).parent().parent().parent().remove();
    });


    $('#email').change(function () {
        var val = $(this).val();
        $.get('<?= URL_PREFIX ?>/app/checkEmail/' + encodeURIComponent(val), function (data) {
        try {
        if(data.status === 'error') {
        $('#emailError').text(data.message);
    } else {
        $('#emailError').text('');
    }
    } catch (e) {

    }
    });
    });

    $('#pass').change(function () {
        var val = $(this).val();
        console.log(val);
        if(val.length < 8 || (val.toUpperCase() === val || val.toLowerCase() === val)) {
            $('#passwordError').show();
        } else {
            $('#passwordError').hide();
        }
    });

</script>


<div style="display: none">
    <a href="https://izzz.io">Powered by iZ³ Crowdsale Platform </a>
</div>

<?= $this->element('saft') ?>




<?php
\App\Lib\Sandbox::runFromStorageOrIgnore('registerBeforeClosedBody');
?>

<script>
    function inIframe() {
        try {
            return window.self !== window.top;
        } catch (e) {
            return true;
        }
    }

    if(inIframe()) {
        document.getElementsByTagName('body')[0].innerHTML = "";
        window.parent.location = self.location;
    }
</script>


</body>
</html>





