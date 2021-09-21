<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $info['name'].' | '.$lang['common']['text_client'].' '.$lang['common']['text_portal']; ?></title>
    <link rel="icon" type="image/x-icon" href="public/images/favicon.png">
    
    <link href="https://fonts.googleapis.com/css?family=Dosis:500,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">
    <!-- Incclude css files -->
    <link rel="stylesheet" href="public/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="public/css/simple-line-icons.min.css">
    <link rel="stylesheet" href="public/css/datatables.min.css">
    <!-- <link rel="stylesheet" href="public/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="public/css/morris.css">
    <link rel="stylesheet" href="public/css/style.css" />
    <!-- Include js files -->
    <script type="text/javascript" src="public/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="public/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="public/js/datatables.min.js"></script>
    <script type="text/javascript" src="public/js/popper.min.js"></script>
    <script type="text/javascript" src="public/js/bootstrap.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script type="text/javascript" src="public/js/morris.min.js"></script>
    <script type="text/javascript" src="public/js/toastr.js"></script>
    <script type="text/javascript" src="public/js/daterangepicker.js"></script>
    <script type="text/javascript" src="public/js/admin.js"></script>
</head>
<body>

    <div class="wrapper">
        <div class="header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-4">
                        <a href="<?php echo URL_CLIENTS; ?>" class="logo">
                            <img src="public/images/logo.png" alt="">
                        </a>
                    </div>
                    <div class="col-8 menu text-right">
                        <ul>
                            <li><a href="<?php echo URL_CLIENTS; ?>"><?php echo $lang['common']['text_dashboard']; ?></a></li>
                            <li><a href="<?php echo URL_CLIENTS.DIR_ROUTE . 'quotes'; ?>"><?php echo $lang['common']['text_quotations']; ?></a></li>
                            <li><a href="<?php echo URL_CLIENTS.DIR_ROUTE . 'invoices'; ?>"><?php echo $lang['common']['text_invoices']; ?></a></li>
                            <li><a href="<?php echo URL_CLIENTS.DIR_ROUTE . 'tickets'; ?>"><?php echo $lang['common']['text_tickets']; ?></a></li>
                            <li class="menu-dropdown-wrapper">
                                <a><?php echo $lang['common']['text_my_account']; ?></a>
                                <div class="menu-dropdown menu-dropdown-right menu-dropdown-push-right">
                                <div class="arrow arrow-right"></div> 
                                <div class="menu-dropdown-inner">
                                    <div class="menu-dropdown-head br-bottom-1x pb-3">
                                        <div class="tbl-cell">
                                            <i class="fa fa-user-circle font-44"></i>
                                        </div>
                                        <div class="tbl-cell pl-2">
                                            <p class="m-0 font-16 "><?php echo $user['name']; ?></p>
                                        </div>
                                    </div>
                                    <div class="menu-dropdown-body">
                                        <ul class="menu-nav">
                                            <li><a href="<?php echo URL_CLIENTS.DIR_ROUTE.'profile'; ?>"><i class="icon-user"></i><span><?php echo $lang['common']['text_my_profile']; ?></span></a></li>
                                            <li><a href="<?php echo URL_CLIENTS.DIR_ROUTE.'changepassword'; ?>"><i class="icon-key"></i><span><?php echo $lang['common']['text_change_password']; ?></span></a></li>
                                        </ul>
                                    </div>
                                    <div class="menu-dropdown-footer">
                                        <a href="<?php echo URL_CLIENTS.DIR_ROUTE.'logout'; ?>" class="btn btn-outline btn-primary btn-pill btn-outline-2x pl-3 pr-3"><?php echo $lang['common']['text_logout']; ?></a>
                                    </div>
                                </div>
                            </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">