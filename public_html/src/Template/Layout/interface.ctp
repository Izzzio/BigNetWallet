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