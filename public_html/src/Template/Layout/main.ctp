<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>iZ³ BigNet network. Home</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="iZ³ BigNet network"/>
    <meta name="keywords" content="blockchain, network, izzzio"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="https://izzz.io/favicon.ico">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/components/bootstrap/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/lte/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/lte/css/skins/all-skins.min.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/bootstrap-dialog/css/bootstrap-dialog.min.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/custom.css?_=<?= CORE_VERSION ?>">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/flag-icon.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="<?= URL_PREFIX . APP_THEME_BASE ?>/components/jquery/jquery.min.js"></script>

    <script src="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/jquery-i18next/jquery-i18next.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/i18next/15.0.5/i18next.min.js"></script>

    <script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/bundle.js"></script>

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

    <header class="main-header">

        <!-- Logo -->
        <a href="<?= URL_PREFIX ?>/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini" data-i18n="[html]main:logo.mini"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg" data-i18n="[html]main:logo.big"></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="<?= URL_PREFIX ?>/" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <i class="fas fa-bars"></i>
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-language fa-lg"></i>
                            <span class="label label-warning">EN</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <ul class="menu">
                                    <li class="lang-item" language="ru">
                                        <a href="#">
                                            <div class="pull-left">
                                                <div class="iz3-flag-wrapper">
                                                    <span class="flag-icon flag-icon-ru iz3-flag-bordered"></span>
                                                </div>
                                            </div>
                                            <h4>
                                                Russian
                                            </h4>
                                        </a>
                                    </li>
                                    <li class="lang-item" language="ru">
                                        <a href="#">
                                            <div class="pull-left">
                                                <div class="iz3-flag-wrapper">
                                                    <span class="flag-icon flag-icon-de iz3-flag-bordered"></span>
                                                </div>
                                            </div>
                                            <h4>
                                                German
                                            </h4>
                                        </a>
                                    </li>
                                    <li class="lang-item" language="en">
                                        <a href="#">
                                            <div class="pull-left">
                                                <div class="iz3-flag-wrapper">
                                                    <span class="flag-icon flag-icon-gb iz3-flag-bordered"></span>
                                                </div>
                                            </div>
                                            <h4>
                                            </h4>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu" style="display: none;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="far fa-bell fa-lg"></i>
                            <!--
                            <span class="label label-danger">10</span>
                            -->
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"><h4>No notifications</h4></li>
                            <!--
                            <li class="header">You have 10 notifications</li>
                            -->
                            <!--
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                            page and may cause design problems
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-red"></i> 5 new members joined
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-user text-red"></i> You changed your username
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            -->
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown messages-menu" style="display: none;">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-lg"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <ul class="menu">
                                    <!--
                                    <li>
                                        <a href="#">
                                            <h4>
                                                Settings
                                            </h4>
                                        </a>
                                    </li>
                                    -->
                                    <li>
                                        <a href="#">
                                            <h4>
                                                Log out
                                            </h4>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header"></li>

                <li>
                    <a href="<?= URL_PREFIX ?>/wallet/create">
                        <i class="fas fa-wallet"></i>
                        &nbsp;
                        <span data-i18n="index:menu.wallet_create"></span>
                    </a>
                </li>

                <li>
                    <a href="<?= URL_PREFIX ?>/wallet/login">
                        <i class="fas fa-money-check-alt"></i>
                        &nbsp;
                        <span data-i18n="index:menu.wallet_login"></span>
                    </a>
                </li>
            </ul>
        </section>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <strong>Copyright &copy; <?= date('Y');?> <a href="//izzz.io">iZ³</a>.</strong>
        <span data-i18n="main:footer.copyrights"></span>
    </footer>

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

</body>

<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/components/bootstrap/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/components/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/lte/js/adminlte.min.js"></script>
<!-- SlimScroll -->
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>

<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/toastr/toastr.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/jquery-validation/additional-methods.min.js"></script>

<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/langs.js?_=<?= CORE_VERSION ?>"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/main.js?_=<?= CORE_VERSION ?>"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/walletActions.js?_=<?= CORE_VERSION ?>"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/dappOuter.js?_=<?= CORE_VERSION ?>"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/signable.js?_=<?= CORE_VERSION ?>"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/ecmaContractCallBlock.js?_=<?= CORE_VERSION ?>"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/ecmaContractDeployBlock.js?_=<?= CORE_VERSION ?>"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/interactContract.js?_=<?= CORE_VERSION ?>"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/components/candy/crypto-js/crypto-js.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/jquery.qrcode.min.js"></script>

</html>