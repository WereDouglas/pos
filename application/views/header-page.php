<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>vugaPos</title>

        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!--basic styles-->

        <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?= base_url(); ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/font-awesome.min.css" />

        <!--[if IE 7]>
          <link rel="stylesheet" href="<?= base_url(); ?>assets/css/font-awesome-ie7.min.css" />
        <![endif]-->

        <!--page specific plugin styles-->

        <!--fonts-->

        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

        <!--ace styles-->
        <link rel=icon href="<?= base_url(); ?>images/favicon.ico">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/ace.min.css" />
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/ace-responsive.min.css" />
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/ace-skins.min.css" />

        <!--[if lte IE 8]>
          <link rel="stylesheet" href="<?= base_url(); ?>assets/css/ace-ie.min.css" />
        <![endif]-->

        <!--inline styles related to this page-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

    <body>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a href="#" class="brand">
                        <small>
                            <img height="50px" width="80px" src="<?= base_url(); ?>images/vugapos.png" class="msg-photo" alt="Logo" />

                        </small>
                    </a><!--/.brand-->

                    <ul class="nav ace-nav pull-right">

                        <li class="light-blue">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">                                
                                <?php
                                if ($this->session->userdata('userIMG') != "") {

                                    echo '<img class="nav-user-photo" src="data:image/jpeg;base64,' . $this->session->userdata('userIMG') . '" />';
                                } else {
                                    ?>

                                    <img class="nav-user-photo" src="<?= base_url(); ?>images/temp.png" alt="image" title="Change the name">
                                    <?php
                                }
                                ?>

                                <span class="user-info">
                                    <small>Welcome,</small>
                                    <?php $this->session->userdata('username'); ?>
                                </span>

                                <i class="icon-caret-down"></i>
                            </a>

                            <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
                                <li>
                                    <a href="#">
                                        <i class="icon-cog"></i>
                                        Settings
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="icon-user"></i>
                                        Profile
                                    </a>
                                </li>

                                <li class="divider"></li>

                                <li>
                                    <a href="<?php echo base_url() . "index.php/welcome/logout"; ?>">
                                        <i class="icon-off"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul><!--/.ace-nav-->
                </div><!--/.container-fluid-->
            </div><!--/.navbar-inner-->
        </div>

        <div class="main-container container-fluid">
            <a class="menu-toggler" id="menu-toggler" href="#">
                <span class="menu-text"></span>
            </a>

            <div class="sidebar" id="sidebar">
                <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                        <button class="btn btn-small btn-success">
                            <i class="icon-signal"></i>
                        </button>

                        <button class="btn btn-small btn-info">
                            <i class="icon-pencil"></i>
                        </button>

                        <button class="btn btn-small btn-warning">
                            <i class="icon-group"></i>
                        </button>

                        <button class="btn btn-small btn-danger">
                            <i class="icon-cogs"></i>
                        </button>
                    </div>

                    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                        <span class="btn btn-success"></span>

                        <span class="btn btn-info"></span>

                        <span class="btn btn-warning"></span>

                        <span class="btn btn-danger"></span>
                    </div>
                </div><!--#sidebar-shortcuts-->

                <ul class="nav nav-list">
                    <li class="active">
                        <a target="frame" href="<?php echo base_url() . "index.php/welcome/start"; ?>">
                            <i class="icon-dashboard"></i>
                            <span class="menu-text"> Dashboard </span>
                        </a>
                    </li>
                    <li>
                        <a target="frame" href="<?php echo base_url() . "index.php/purchase/"; ?>">
                            <i class="icon-shopping-cart"></i>
                            <span class="menu-text"> Sales Register(POS)</span>
                        </a>
                    </li>
                    <li>
                        <a target="frame" href="<?php echo base_url() . "index.php/purchase/"; ?>">
                            <i class="icon-tag"></i>
                            <span class="menu-text"> Purchase Register</span>
                        </a>
                    </li>

                    <li>
                        <a target="frame" href="<?php echo base_url() . "index.php/item/"; ?>">
                            <i class="icon-list"></i>
                            <span class="menu-text"> Inventory  </span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-file"></i>
                            <span class="menu-text">Transactions</span>

                            <b class="arrow icon-angle-down"></b>
                        </a>

                        <ul class="submenu">
                            <li>
                                <a target="frame" href="<?php echo base_url() . "index.php/billing/"; ?>">
                                    <i class="icon-file-alt"></i>
                                    <span class="menu-text">Billing and Invoicing</span>
                                </a>
                            </li>
                            <li>
                                <a target="frame" href="<?php echo base_url() . "index.php/transaction/sale"; ?>">
                                    <i class="icon-double-angle-right"></i>
                                    Transactions
                                </a>
                            </li>
                            <li>
                                <a target="frame" href="<?php echo base_url() . "index.php/transaction/payment"; ?>">
                                    <i class="icon-double-angle-right"></i>
                                    Payments
                                </a>
                            </li>
                            <li>
                                <a target="frame" href="<?php echo base_url() . "index.php/transaction/expense"; ?>">
                                    <i class="icon-double-angle-right"></i>
                                    Expenses
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <a target="frame" href="<?php echo base_url() . "index.php/stock/"; ?>">
                            <i class="icon-pencil"></i>
                            <span class="menu-text">Inventory records </span>
                        </a>
                    </li>
                    <li>
                        <a target="frame" href="<?php echo base_url() . "index.php/taking"; ?>">
                            <i class="icon-tablet"></i>
                            <span class="menu-text">Stock taking </span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-file"></i>
                            <span class="menu-text">Ledgers</span>
                            <b class="arrow icon-angle-down"></b>
                        </a>

                        <ul class="submenu">
                            <li>
                                <a target="frame" href="<?php echo base_url() . "index.php/billing/"; ?>">
                                    <i class="icon-file-alt"></i>
                                    <span class="menu-text">Billing and Invoicing</span>
                                </a>
                            </li>
                            <li>
                                <a target="frame" href="<?php echo base_url() . "index.php/transaction/sale"; ?>">
                                    <i class="icon-double-angle-right"></i>
                                    Transactions
                                </a>
                            </li>
                            <li>
                                <a target="frame" href="<?php echo base_url() . "index.php/transaction/payment"; ?>">
                                    <i class="icon-double-angle-right"></i>
                                    Payments
                                </a>
                            </li>
                            <li>
                                <a target="frame" href="<?php echo base_url() . "index.php/transaction/expense"; ?>">
                                    <i class="icon-double-angle-right"></i>
                                    Expenses
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a target="frame" href="<?php echo base_url() . "index.php/expense/"; ?>">
                            <i class="icon-shopping-cart"></i>
                            <span class="menu-text"> Expenses</span>
                        </a>
                    </li>
                    <li>
                        <a target="frame" href="<?php echo base_url() . "index.php/supplier/"; ?>">
                            <i class="icon-globe"></i>
                            <span class="menu-text">Supplier& Customers</span>
                        </a>
                    </li>

                    <li>
                        <a target="frame" href="<?php echo base_url() . "index.php/category/"; ?>">
                            <i class="icon-table"></i>
                            <span class="menu-text"> Category </span>
                        </a>
                    </li>

                    <li>
                        <a target="frame" href="<?php echo base_url() . "index.php/store/"; ?>">
                            <i class="icon-home"></i>
                            <span class="menu-text"> Stores </span>
                        </a>
                    </li>
                     <li>
                        <a target="frame" href="<?php echo base_url() . "index.php/store/"; ?>">
                            <i class="icon-home"></i>
                            <span class="menu-text"> Stock transfer</span>
                        </a>
                    </li>
                    <li>
                        <a target="frame" href="<?php echo base_url() . "index.php/transaction/"; ?>">
                            <i class="icon-double-angle-right"></i>
                            <span class="menu-text"> Transactions</span>
                        </a>
                    </li>
                    <li>
                        <a target="frame" href="<?php echo base_url() . "index.php/user/"; ?>">
                            <i class="icon-user"></i>
                            <span class="menu-text"> Users</span>
                        </a>
                    </li>
                    <li>
                        <a target="frame" href="<?php echo base_url() . "index.php/role/"; ?>">
                            <i class="icon-lock"></i>
                            <span class="menu-text"> Roles</span>
                        </a>
                    </li>
                     <li>
                        <a href="http://vugapos.pro/file/Vuga%20POS.msi">
                            <i class="icon-lock"></i>
                            <span class="menu-text"> DOWNLOAD</span>
                        </a>
                    </li>


                </ul><!--/.nav-list-->

                <div class="sidebar-collapse" id="sidebar-collapse">
                    <i class="icon-double-angle-left"></i>
                </div>
            </div>

            <div class="main-content">