<?php
/**
 * @var \App\Model\Entity\User $user
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Izzz.io - iZ³ Tokensale platform</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="iZ³ Tokensale platform"/>
    <meta name="keywords" content="HTML, CSS, XML"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="https://izzz.io/favicon.ico">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= URL_PREFIX . ADMIN_THEME_BASE ?>/plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= URL_PREFIX . ADMIN_THEME_BASE ?>/plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= URL_PREFIX . ADMIN_THEME_BASE ?>/plugins/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= URL_PREFIX . ADMIN_THEME_BASE ?>/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= URL_PREFIX . ADMIN_THEME_BASE ?>/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="<?= URL_PREFIX . ADMIN_THEME_BASE ?>/css/main.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 3 -->
    <script src="<?= URL_PREFIX . ADMIN_THEME_BASE ?>/plugins/jquery/dist/jquery.min.js"></script>

    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">

        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>iZ³</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>iZ³</b> Tokensale platform</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <?php
                    $name = '';
                    $email = '';
                    if (isset($user) && $user) {
                        $name = $user->name;
                        $email = $user->email;
                    }
                    ?>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-lg hidden-md hidden-sm">
                                <i class="fa fa-lg fa-user-circle-o" aria-hidden="true"></i>
                            </span>
                            <span class="hidden-xs"><?= h($name) ?>&nbsp</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <p>
                                    <?= h($name) ?>
                                    <small><?= h($email) ?></small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="<?= URL_PREFIX ?>/app/logout" class="btn btn-success btn-flat" style="background: #00a65a;">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!--
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                    -->
                </ul>
            </div>

        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>

                <li>
                    <a href="<?= URL_PREFIX ?>/">
                        <i class="fa fa-arrow-left"></i> <span>Back to main page</span>
                    </a>
                </li>
                <li class="<?= $activeMenu['dashboard'] ?>">
                    <a href="<?= URL_PREFIX ?>/admin">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="<?= $activeMenu['users'] ?>">
                    <a href="<?= URL_PREFIX ?>/admin/users">
                        <i class="fa fa-users"></i> <span>Users</span>
                    </a>
                </li>

                <li class="treeview <?= $activeMenu['txn_list'].$activeMenu['txn_stat'] ?>">
                    <a href="#">
                        <i class="fa fa-link"></i>
                        <span>Transactions</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="<?= $activeMenu['txn_list'] ?>"><a href="<?= URL_PREFIX ?>/admin/transactions"><i class="fa fa-circle-o"></i> List all</a></li>
                        <li class="<?= $activeMenu['txn_stat'] ?>"><a href="<?= URL_PREFIX ?>/admin/transactionsstats"><i class="fa fa-circle-o"></i> Statistics</a></li>
                    </ul>
                </li>

                <?php if(\App\Controller\AclController::isUserRole(['ROLE_SYSTEM', 'ROLE_ADMIN'])) {?>
                <?php if (!\App\Lib\Misc::tcfg('disableScripts')) { ?>
                    <li class="treeview <?= $activeMenu['dev_script'].$activeMenu['dev_page'] ?>">
                        <a href="#">
                            <i class="fa fa-code"></i>
                            <span>System</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= $activeMenu['dev_script'] ?>"><a href="<?= URL_PREFIX ?>/admin/scripts"><i class="fa fa-circle-o"></i> Scripts</a></li>
                            <li class="<?= $activeMenu['dev_page'] ?>"><a href="<?= URL_PREFIX ?>/admin/customPages"><i class="fa fa-circle-o"></i> Custom pages</a></li>
                            <li class="<?= $activeMenu['dev_logs'] ?>"><a href="<?= URL_PREFIX ?>/admin/logs"><i class="fa fa-circle-o"></i> Info logs</a></li>
                        </ul>
                    </li>
                <?php }
                }
                ?>

                <li class="<?= $activeMenu['faq'] ?>">
                    <a href="<?= URL_PREFIX ?>/admin/faq">
                        <i class="fa fa-question-circle"></i> <span>Manage FAQ</span>
                    </a>
                </li>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>

    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right">
            <a target="_blank" href="https://izzz.io/en/cabinet/?client=<?=urlencode(\App\Lib\Misc::projectName())?>">About iZ³ Tokensale platform</a>
        </div>
        <strong>Copyright &copy; <?= date('Y');?> iZ³ - IZZZIO crowdsale platform.</strong>
    </footer>

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.7 -->
<script src="<?= URL_PREFIX . ADMIN_THEME_BASE ?>/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?= URL_PREFIX . ADMIN_THEME_BASE ?>/plugins/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= URL_PREFIX . ADMIN_THEME_BASE ?>/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="<?= URL_PREFIX . ADMIN_THEME_BASE ?>/plugins/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- SlimScroll -->
<script src="<?= URL_PREFIX . ADMIN_THEME_BASE ?>/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?= URL_PREFIX . ADMIN_THEME_BASE ?>/js/main.js"></script>

<script>
    console.log("%cDon't Panic!", 'color: red; font-size: 48px');
    console.log("%c   " + " %cTokensale Platform", 'color: black; background: url(<?= URL_PREFIX ?>/images/logo-white.svg) no-repeat black; font-size: 48px', 'font-size: 48px; background-color:black; color:white');
    console.log("%cwill do all the hard work itself!", 'background-color:black; color:white; font-size: 30px');
    console.log("%cMore at " + $('#about').attr('href'), 'background-color:black; color:white; font-size: 30px');
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter47787229 = new Ya.Metrika2({
                    id:47787229,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/47787229" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>