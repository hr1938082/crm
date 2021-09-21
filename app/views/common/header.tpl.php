<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Client Manager | CRM</title>
    <link rel="icon" type="image/x-icon" href="public/images/favicon.png">
    <!-- Include css files -->
    <link rel="stylesheet" href="public/css/style.css" />
    <!-- Include js files -->
    <script type="text/javascript" src="public/js/vendor.js"></script>
    <script type="text/javascript" src="public/js/admin.js"></script>
</head>
<body>
    <!-- Media Modal -->
    <div id="media-upload" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="media-hdr">
                        <p><?php echo $lang['common']['text_media']; ?></p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="media-upload-container">
                        <form action="<?php echo URL.DIR_ROUTE;?>upload" class="dropzone" id="media-dropzone" method="post" enctype="multipart/form-data">
                            <div class="fallback"><input name="file" type="file" /></div>
                        </form>
                    </div>
                    <div class="media-all">
                        <?php $media_array = []; $allowed =  array('gif','png' ,'jpg'); $images = scandir(DIR."public/uploads", 1); foreach ($images as $value) { $ext = pathinfo($value, PATHINFO_EXTENSION); if (in_array($ext,$allowed)) { $media_array[] = $value; } } $media_array = json_encode($media_array); ?>
                        <input type="hidden" name="media_all" value="<?php if($user['role'] == 'Admin') { echo htmlspecialchars($media_array, ENT_QUOTES, 'UTF-8'); } else { echo '[]'; } ?>">
                        <input type="hidden" name="absolute-path" value="<?php echo URL.DIR_ROUTE; ?>">
                        <input type="hidden" name="absolute-upload-path" value="<?php echo htmlspecialchars(URL.'public/uploads/', ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="text_language" value="<?php echo $lang['common']['text_drop_message']; ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile-menu-background"></div>
    <div class="wrapper<?php if (!empty($info['theme']['layout'])) { echo ' '.$info['theme']['layout']; } ?>">
        <!-- Main Container -->
        <div id="main-wrapper" class="<?php if (!empty($info['theme']['layout_fixed'])) { echo ' '.$info['theme']['layout_fixed']; } if (!empty($info['theme']['side_menu'])) { echo ' menu-'.$info['theme']['side_menu']; }  if (!empty($info['theme']['layout_menu'])) { echo ' '.$info['theme']['layout_menu']; }?>">
            <!-- Menu Wrapper -->
            <div class="menu-wrapper">
                <div class="menu">
                    <ul>
                        <li class="menu-title"><?php echo $lang['common']['text_main']; ?></li>
                        <li id="dashboard-li">
                            <a href="<?php echo URL.DIR_ROUTE; ?>dashboard"><i class="icon-screen-desktop"></i><span><?php echo $lang['common']['text_dashboard']; ?></span></a>
                        </li>
                        <li id="contact-li">
                            <a href="<?php echo URL.DIR_ROUTE; ?>contacts"><i class="icon-emotsmile"></i><span><?php echo $lang['common']['text_contacts']; ?></span></a>
                        </li>
                        <li id="lead-li">
                            <a href="<?php echo URL.DIR_ROUTE; ?>leads"><i class="fas fa-bullhorn"></i><span><?php echo $lang['common']['text_leads']; ?></span></a>
                        </li>
                        <li id="project-li">
                            <a href="<?php echo URL.DIR_ROUTE; ?>projects"><i class="icon-layers"></i><span>Orders</span></a>
                        </li>
                        <li id="web-client-li">
                            <a href="<?php echo URL.DIR_ROUTE; ?>webclients"><i class="icon-user"></i><span>Websites</span></a>
                        </li>
                        <li class="menu-title"><?php echo $lang['common']['text_sales']; ?></li>
                        <li id="quotes-li">
                            <a href="<?php echo URL.DIR_ROUTE; ?>quotes"><i class="icon-calculator"></i><span><?php echo $lang['common']['text_quotes'].'/'.$lang['common']['text_estimates']; ?></span></a>
                        </li>
                        <li id="invoice-li">
                            <a href="<?php echo URL.DIR_ROUTE; ?>invoices"><i class="icon-doc"></i><span><?php echo $lang['common']['text_invoices']; ?></span></a>
                        </li>
                        <li id="rinvoice-li">
                            <a href="<?php echo URL.DIR_ROUTE; ?>recurring"><i class="icon-docs"></i><span><?php echo $lang['common']['text_recurring_invoices']; ?></span></a>
                        </li>
                        <li class="menu-title"><?php echo $lang['common']['text_support']; ?></li>
                        <li id="ticket-li">
                            <a href="<?php echo URL.DIR_ROUTE; ?>tickets"><i class="fas fa-ticket-alt"></i><span><?php echo $lang['common']['text_tickets']; ?></span></a>
                        </li>
                        <li class="menu-title"><?php echo $lang['common']['text_domains']; ?></li>
                        <li id="domain-li">
                            <a href="<?php echo URL.DIR_ROUTE; ?>domains"><i class="fas fa-server"></i><span><?php echo $lang['common']['text_domains']; ?></span></a>
                        </li>
                        <li class="menu-title"><?php echo $lang['common']['text_others']; ?></li>
                        <li id="expense-li">
                            <a href="<?php echo URL.DIR_ROUTE; ?>expenses"><i class="icon-rocket"></i><span><?php echo $lang['common']['text_expenses']; ?></span></a>
                        </li>
                        <li id="calendar-li">
                            <a href="<?php echo URL.DIR_ROUTE; ?>calendar"><i class="icon-event"></i><span><?php echo $lang['common']['text_calendar']; ?></span></a>
                        </li>
                        <li id="note-li">
                            <a href="<?php echo URL.DIR_ROUTE; ?>notes"><i class="icon-notebook"></i><span><?php echo $lang['common']['text_notes']; ?></span></a>
                        </li>
                        <li class="menu-title"><?php echo $lang['common']['text_users']; ?></li>
                        <li id="user-li" class="has-sub">
                            <a><i class="icon-people"></i><span><?php echo $lang['common']['text_users']; ?></span><i class="arrow rotate"></i></a>
                            <ul id="user" class="sub-menu">
                                <li>
                                    <a href="<?php echo URL.DIR_ROUTE; ?>user"><span><?php echo $lang['common']['text_users']; ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo URL.DIR_ROUTE; ?>role"><span><?php echo $lang['common']['text_user_role']; ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo URL.DIR_ROUTE; ?>subscriber"><span><?php echo $lang['common']['text_subscribers']; ?></span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-title"><?php echo $lang['common']['text_utilities']; ?></li>
                        <li id="utilities-li" class="has-sub">
                            <a><i class="icon-puzzle"></i><span><?php echo $lang['common']['text_utilities']; ?></span><i class="arrow rotate"></i></a>
                            <ul id="utilities" class="sub-menu">
                                <li>
                                    <a href="<?php echo URL.DIR_ROUTE; ?>emaillog"><span><?php echo $lang['common']['text_email_log']; ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo URL.DIR_ROUTE; ?>cronlog"><span><?php echo $lang['common']['text_cron_log']; ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo URL.DIR_ROUTE; ?>dbbackup"><span><?php echo $lang['common']['text_database_backup']; ?></span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-title"><?php echo $lang['common']['text_settings']; ?></li>
                        <li id="setting-li" class="has-sub">
                            <a><i class="icon-settings"></i><span><?php echo $lang['common']['text_settings']; ?></span><i class="arrow rotate"></i></a>
                            <ul id="setting" class="sub-menu">
                                <li>
                                    <a href="<?php echo URL.DIR_ROUTE; ?>info"><span><?php echo $lang['common']['text_organisation_info']; ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo URL.DIR_ROUTE; ?>taxes"><span><?php echo $lang['common']['text_finance']; ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo URL.DIR_ROUTE; ?>emailtemplate&for=newticket"><span><?php echo $lang['common']['text_email_template']; ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo URL.DIR_ROUTE; ?>setting&page=emailsetting"><span><?php echo $lang['common']['text_email_settings']; ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo URL.DIR_ROUTE; ?>items"><span><?php echo $lang['common']['text_items']; ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo URL.DIR_ROUTE; ?>departments"><span><?php echo $lang['common']['text_departments']; ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo URL.DIR_ROUTE; ?>expensetype"><span><?php echo $lang['common']['text_expense_types']; ?></span></a>
                                </li>
                                <li>
                                    <a href="<?php echo URL.DIR_ROUTE; ?>setting&page=recurring"><span><?php echo $lang['common']['text_cron_setting']; ?></span></a>
                                </li>
                            </ul>
                        </li>  
                        <li id="customization-li">
                            <a href="<?php echo URL.DIR_ROUTE; ?>customization"><i class="icon-target"></i><span><?php echo $lang['common']['text_theme_customization']; ?></span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Page header -->
            <div class="page-hdr<?php if (!empty($info['theme']['header_color'])) { echo ' '.$info['theme']['header_color']; } ?>">
                <div class="row align-items-center">
                    <div class="col-4 col-md-7 page-hdr-left">
                        <div id="logo">
                            <div class="tbl-cell logo-icon">
                                <a href="#"><img src="public/images/icon.png" alt=""></a>
                            </div>
                            <div class="tbl-cell logo">
                                <a href="<?php echo URL.DIR_ROUTE; ?>dashboard"><img src="public/images/logo-color.png"></a>
                            </div>
                        </div>
                        <div class="page-menu menu-icon">
                            <a class="animated menu-close"><i class="far fa-hand-point-left"></i></a>
                        </div>
                        <div class="page-menu page-fullscreen">
                            <a><i class="fas fa-expand"></i></a>
                        </div>
                    </div>
                    <div class="col-8 col-md-5 page-hdr-right">
                        <div class="page-menu open-left-menu">
                            <a href="#"><i class="icon-menu"></i></a>
                        </div>
                        <?php if (isset($recents) && !empty($recents)) { ?>
                        <div class="page-menu menu-dropdown-wrapper menu-recent">
                            <a><i class="icon-bell"></i><span></span></a>
                            <div class="menu-dropdown recent-dropdown menu-dropdown-right menu-dropdown-push-right">
                                <div class="arrow arrow-right"></div> 
                                <div class="menu-dropdown-inner">
                                    <div class="menu-dropdown-head"><?php echo $lang['dashboard']['text_recently_added']; ?></div>
                                    <div class="menu-dropdown-body pl-1 pr-3">
                                        <ul class="nav nav-tabs font-12 nav-tabs-line nav-tabs-line-primary">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#recent-contact" data-toggle="tab"><?php echo $lang['common']['text_contacts']; ?></a>
                                            </li>
                                            <li class="nav-item">  
                                                <a class="nav-link" href="#recent-expenses" data-toggle="tab"><?php echo $lang['common']['text_expenses']; ?></a>
                                            </li>
                                            <li class="nav-item">  
                                                <a class="nav-link" href="#recent-invoices" data-toggle="tab"><?php echo $lang['common']['text_invoices']; ?></a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#recent-quotes" data-toggle="tab"><?php echo $lang['common']['text_quotes']; ?></a>
                                            </li>
                                        </ul>
                                        <div class="tab-content m-0 pt-2 pb-2">
                                            <div class="tab-pane active" id="recent-contact">
                                                <ul class="timeline">
                                                    <?php if (!empty($recents['contacts'])) { foreach ($recents['contacts'] as $key => $value) { ?>
                                                    <li>
                                                        <div class="time"><small><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></small></div>
                                                        <a href="<?php echo URL.DIR_ROUTE.'contact/edit&id='.$value['id']; ?>" target="_blank" class="timeline-container">
                                                            <div class="arrow"></div>
                                                            <div class="description"><?php echo $value['company']; ?></div>
                                                            <div class="author"><?php echo $value['name']; ?></div>
                                                        </a>
                                                    </li>
                                                    <?php } } else { ?>
                                                    <li>
                                                        <div class="time"><small>---</small></div>
                                                        <a class="timeline-container">
                                                            <div class="arrow"></div>
                                                            <div class="description"><?php echo $lang['common']['text_no_data_found']; ?></div>
                                                            <div class="author"></div>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>  
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="recent-quotes">
                                                <ul class="timeline">
                                                    <?php if (!empty($recents['quotes'])) { foreach ($recents['quotes'] as $key => $value) { ?>
                                                    <li>
                                                        <div class="time"><small><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></small></div>
                                                        <a href="<?php echo URL.DIR_ROUTE.'quote/view&id='.$value['id']; ?>" target="_blank" class="timeline-container">
                                                            <div class="arrow"></div>
                                                            <div class="description"><?php echo $value['company']; ?></div>
                                                            <div class="author"><?php echo $value['project_name']; ?></div>
                                                        </a>
                                                    </li>
                                                    <?php } } else { ?>
                                                    <li>
                                                        <div class="time"><small>---</small></div>
                                                        <a class="timeline-container">
                                                            <div class="arrow"></div>
                                                            <div class="description"><?php echo $lang['common']['text_no_data_found']; ?></div>
                                                            <div class="author"></div>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>  
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="recent-invoices">
                                                <ul class="timeline">
                                                    <?php if (!empty($recents['invoices'])) { foreach ($recents['invoices'] as $key => $value) { ?>
                                                    <li>
                                                        <div class="time"><small><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></small></div>
                                                        <a href="<?php echo URL.DIR_ROUTE.'invoice/view&id='.$value['id']; ?>" target="_blank" class="timeline-container">
                                                            <div class="arrow"></div>
                                                            <div class="description"><?php echo $value['company']; ?></div>
                                                            <div class="author"><?php echo $value['abbr'].$value['amount']; ?></div>
                                                        </a>
                                                    </li>
                                                    <?php } } else { ?>
                                                    <li>
                                                        <div class="time"><small>---</small></div>
                                                        <a class="timeline-container">
                                                            <div class="arrow"></div>
                                                            <div class="description"><?php echo $lang['common']['text_no_data_found']; ?></div>
                                                            <div class="author"></div>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="recent-expenses">
                                                <ul class="timeline">
                                                    <?php if (!empty($recents['expenses'])) { foreach ($recents['expenses'] as $key => $value) { ?>
                                                    <li>
                                                        <div class="time"><small><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></small></div>
                                                        <a href="<?php echo URL.DIR_ROUTE.'expense/edit&id='.$value['id']; ?>" target="_blank" class="timeline-container">
                                                            <div class="arrow"></div>
                                                            <div class="description"><?php echo $value['purchase_by']; ?></div>
                                                            <div class="author"><?php echo $value['abbr'].$value['purchase_amount']; ?></div>
                                                        </a>
                                                    </li>
                                                    <?php } } else { ?>
                                                    <li>
                                                        <div class="time"><small>---</small></div>
                                                        <a class="timeline-container">
                                                            <div class="arrow"></div>
                                                            <div class="description"><?php echo $lang['common']['text_no_data_found']; ?></div>
                                                            <div class="author"></div>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="page-menu menu-dropdown-wrapper">
                            <a><i class="icon-settings"></i><span></span></a>
                            <div class="menu-dropdown menu-dropdown-right menu-dropdown-push-right">
                                <div class="arrow arrow-right"></div> 
                                <div class="menu-dropdown-inner">
                                    <div class="menu-dropdown-head"><?php echo $lang['common']['text_settings']; ?></div>
                                    <div class="menu-dropdown-body">
                                        <ul class="menu-nav">
                                            <li><a href="<?php echo URL.DIR_ROUTE.'info'; ?>"><i class="icon-share-alt"></i><span><?php echo $lang['common']['text_organisation_info']; ?></span></a></li>
                                            <li><a href="<?php echo URL.DIR_ROUTE.'taxes'; ?>"><i class="icon-credit-card"></i><span><?php echo $lang['common']['text_finance']; ?></span></a></li>
                                            <li><a href="<?php echo URL.DIR_ROUTE.'items'; ?>"><i class="icon-list"></i><span><?php echo $lang['common']['text_items']; ?></span></a></li>
                                            <li><a href="<?php echo URL.DIR_ROUTE.'expensetype'; ?>"><i class="icon-settings"></i><span><?php echo $lang['common']['text_expense_types']; ?></span></a></li>
                                        </ul>
                                    </div>
                                    <div class="menu-dropdown-footer">
                                        <a href="http://support.pepdev.com/" class="btn btn-outline btn-primary btn-pill btn-outline-2x font-12 btn-sm" target="_blank"><?php echo $lang['common']['text_support']; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="page-menu menu-dropdown-wrapper menu-quick-links">
                            <a><i class="icon-grid"></i></a>
                            <div class="menu-dropdown menu-dropdown-right menu-dropdown-push-right">
                                <div class="arrow arrow-right"></div> 
                                <div class="menu-dropdown-inner">
                                    <div class="menu-dropdown-head"><?php echo $lang['common']['text_quick_links']; ?></div>
                                    <div class="menu-dropdown-body p-0">
                                        <div class="row m-0 box">
                                            <div class="col-6 p-0 box">
                                                <a href="<?php echo URL.DIR_ROUTE.'contact/add'; ?>">
                                                    <i class="icon-emotsmile"></i>
                                                    <span><?php echo $lang['common']['text_new'].' '.$lang['common']['text_contact']; ?></span>
                                                </a>
                                            </div>
                                            <div class="col-6 p-0 box">
                                                <a href="<?php echo URL.DIR_ROUTE.'invoice/add'; ?>">
                                                    <i class="icon-docs"></i>
                                                    <span><?php echo $lang['common']['text_new'].' '.$lang['common']['text_invoice']; ?></span>
                                                </a>
                                            </div>
                                            <div class="col-6 p-0 box">
                                                <a href="<?php echo URL.DIR_ROUTE.'quote/add'; ?>">
                                                    <i class="icon-calculator"></i>
                                                    <span><?php echo $lang['common']['text_new'].' '.$lang['common']['text_quote']; ?></span>
                                                </a>
                                            </div>
                                            <div class="col-6 p-0 box">
                                                <a href="<?php echo URL.DIR_ROUTE.'expense/add'; ?>">
                                                    <i class="icon-rocket"></i>
                                                    <span><?php echo $lang['common']['text_new'].' '.$lang['common']['text_expense']; ?></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="page-menu menu-dropdown-wrapper menu-user">
                            <a><i class="icon-user-following"></i></a>
                            <div class="menu-dropdown menu-dropdown-right menu-dropdown-push-right">
                                <div class="arrow arrow-right"></div> 
                                <div class="menu-dropdown-inner">
                                    <div class="menu-dropdown-head pb-3">
                                        <div class="tbl-cell">
                                            <!-- <img src="public/images/author.jpg" alt=""> -->
                                            <i class="fa fa-user-circle"></i>
                                        </div>
                                        <div class="tbl-cell pl-2 text-left">
                                            <p class="m-0 font-18"><?php echo $user['firstname'].' '.$user['lastname']; ?></p>
                                            <p class="m-0 font-14"><?php echo $user['role']; ?></p>
                                        </div>
                                    </div>
                                    <div class="menu-dropdown-body">
                                        <ul class="menu-nav">
                                            <li><a href="<?php echo URL.DIR_ROUTE.'calendar'; ?>"><i class="icon-event"></i><span><?php echo $lang['common']['text_my_events']; ?></span></a></li>
                                            <li><a href="<?php echo URL.DIR_ROUTE.'notes'; ?>"><i class="icon-notebook"></i><span><?php echo $lang['common']['text_my_notes']; ?></span></a></li>
                                            <li><a href="<?php echo URL.DIR_ROUTE.'profile'; ?>"><i class="icon-user"></i><span><?php echo $lang['common']['text_my_profile']; ?></span></a></li>
                                            <li><a href="<?php echo URL_CLIENTS; ?>"><i class="icon-globe"></i><span><?php echo $lang['common']['text_client'].' '.$lang['common']['text_portal']; ?></span></a></li>
                                        </ul>
                                    </div>
                                    <div class="menu-dropdown-footer text-right">
                                        <a href="<?php echo URL.DIR_ROUTE.'logout'; ?>" class="btn btn-outline btn-primary btn-pill btn-outline-2x font-12 btn-sm"><?php echo $lang['common']['text_logout']; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Page Wrapper -->
            <div class="page-wrapper">
                <div class="page-body">