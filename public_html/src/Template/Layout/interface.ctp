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
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/css/custom.css?_=<?= CORE_VERSION ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/lte/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/lte/css/skins/all-skins.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/icheck/skins/flat/blue.css">
    <link rel="stylesheet" href="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/bootstrap-toggle/css/bootstrap-toggle.min.css">

    <script src="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/jquery-i18next/jquery-i18next.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/i18next/15.0.5/i18next.min.js"></script>


    <script src="<?= URL_PREFIX . APP_THEME_BASE ?>/components/jquery/jquery.min.js"></script>
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
            <span class="logo-mini"><b>iZ³</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg" data-i18n="[html]page:logo.big"></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="<?= URL_PREFIX ?>/" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <i class="fas fa-bars"></i>
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>

    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header"></li>
                <li class="treeview">
                    <a href="#">
                        <i class="fas fa-link"></i>
                        &nbsp;&nbsp;
                        <span>Send</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="#">
                                <i class="far fa-sm fa-circle"></i>
                                &nbsp;&nbsp;
                                <span>Transaction ONline</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="far fa-sm fa-circle"></i>
                                &nbsp;&nbsp;
                                <span>Transaction OFFline</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-exchange-alt"></i>
                        &nbsp;&nbsp;
                        <span>Exchange</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-shapes"></i>
                        &nbsp;&nbsp;
                        <span>Dapps</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fas fa-code"></i>
                        &nbsp;&nbsp;
                        <span>Contract</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="#">
                                <i class="far fa-sm fa-circle"></i>
                                &nbsp;&nbsp;
                                <span>Work with contract</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="far fa-sm fa-circle"></i>
                                &nbsp;&nbsp;
                                <span>Deploy contract</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="far fa-comment-alt"></i>
                        &nbsp;&nbsp;
                        <span>Message</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="#">
                                <i class="far fa-sm fa-circle"></i>
                                &nbsp;&nbsp;
                                <span>Sign message</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="far fa-sm fa-circle"></i>
                                &nbsp;&nbsp;
                                <span>Verify message</span>
                            </a>
                        </li>
                    </ul>
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
        <span data-i18n="page:copyrights"></span>
    </footer>

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/components/bootstrap/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/components/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/lte/js/adminlte.min.js"></script>
<!-- SlimScroll -->
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/langs.js?_=<?= CORE_VERSION ?>"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/js/main.js?_=<?= CORE_VERSION ?>"></script>

<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/icheck/icheck.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<script src="<?= URL_PREFIX . APP_THEME_BASE ?>/plugins/moment/min/moment.min.js"></script>

</body>
</html>