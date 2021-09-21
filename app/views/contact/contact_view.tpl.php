<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#contact').show();$('#contact-li').addClass('active');</script>
<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="user-details text-center">
                    <h2><?php echo $result['company']; ?></h2>
                    <ul class="nav flex-column vnav-tabs text-left">
                        <li class="nav-item">
                            <a href="#contacts" class="nav-link active" data-toggle="tab"><i class="icon-emotsmile"></i> <span><?php echo $lang['common']['text_contact']; ?></span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#contact_persons" class="nav-link" data-toggle="tab"><i class="icon-people"></i> <span><?php echo $lang['contact']['text_contact_persons']; ?></span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#invoice" class="nav-link" data-toggle="tab"><i class="icon-docs"></i> <span><?php echo $lang['common']['text_invoices']; ?></span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#quotes" class="nav-link" data-toggle="tab"><i class="icon-calculator"></i> <span><?php echo $lang['common']['text_quotes']; ?></span></a>
                        </li>
                        <li class="nav-item">
                            <a href="#clients" class="nav-link" data-toggle="tab"><i class="icon-user"></i> <span><?php echo $lang['common']['text_client'].' '.$lang['common']['text_portal']; ?></span></a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo URL.DIR_ROUTE.'contact/edit&id='.$result['id']; ?>"><i class="icon-pencil"></i> <span><?php echo $lang['common']['text_edit']; ?></span></a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="modal" data-target="#contactMail"><i class="icon-paper-plane"></i> <span><?php echo $lang['contact']['text_send_mail']; ?></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="tab-content m-0">
            <div id="contacts" class="tab-pane active">
                <div class="panel panel-default">
                    <div class="panel-head">
                        <div class="panel-title">
                            <i class="icon-emotsmile panel-head-icon"></i>
                            <span class="panel-title-text"><?php echo $page_title; ?></span>
                        </div>
                        <div class="panel-action"></div>  
                    </div>
                    <div class="panel-body">
                        <?php if ($admin) { ?>
                            <div class="row align-items-center pb-3">
                                <div class="col-md-3">
                                    <h5 class="font-500 text-primary font-16 m-0"><?php echo $lang['contact']['text_staff']; ?></h5>
                                </div>
                                <div class="col-md-9">
                                    <p class="d-inline-block m-0"><?php echo $result['username']; ?></p>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row align-items-center pb-3">
                            <div class="col-md-3">
                                <h5 class="font-500 text-primary font-16 m-0"><?php echo $lang['contact']['text_primary_contact']; ?></h5>
                            </div>
                            <div class="col-md-9">
                                <p class="d-inline-block m-0"><?php echo $result['salutation'].' '.$result['firstname'].' '.$result['lastname']; ?></p>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-md-3">
                                <h5 class="font-500 text-primary font-16 m-0"><?php echo $lang['common']['text_email_address']; ?></h5>
                            </div>
                            <div class="col-md-9">
                                <p class="d-inline-block m-0"><?php echo $result['email']; ?></p>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-md-3">
                                <h5 class="font-500 text-primary font-16 m-0"><?php echo $lang['common']['text_phone_number']; ?></h5>
                            </div>
                            <div class="col-md-9">
                                <p class="d-inline-block m-0"><?php echo $result['phone']; ?></p>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-md-3">
                                <h5 class="font-500 text-primary font-16 m-0"><?php echo $lang['common']['text_website']; ?></h5>
                            </div>
                            <div class="col-md-9">
                                <p class="d-inline-block m-0"><?php echo $result['website']; ?></p>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-md-3"><h5 class="font-500 text-primary font-16 m-0"><?php echo $lang['contact']['text_marketing']; ?></h5></div>
                            <div class="col-md-9">
                                <?php if (!empty($result['marketing'])) { foreach ($result['marketing'] as $key => $value) { ?>
                                    <?php if ($value == "email") { ?>
                                        <span class="badge badge-primary badge-pill"><?php echo $value; ?></span>
                                    <?php } elseif ($value == "phone") { ?>
                                        <span class="badge badge-primary badge-pill"><?php echo $value; ?></span>
                                    <?php } elseif ($value == "sms") { ?>
                                        <span class="badge badge-primary badge-pill"><?php echo $value; ?></span>
                                    <?php } elseif ($value == "social") { ?>
                                        <span class="badge badge-primary badge-pill"><?php echo $value; ?></span>
                                    <?php } ?>
                                <?php } } ?>
                            </div>
                        </div>
                        <div class="row align-items-center pb-3">
                            <div class="col-auto col-md-3">
                                <h5 class="font-500 text-primary font-16 m-0"><?php echo $lang['contact']['text_expire_date']; ?></h5>
                            </div>
                            <div class="col-auto col-md-9">
                                <?php if(strtotime(date("Y-m-d")) < strtotime($result['expire'])) { ?>
                                    <span class="badge badge-light badge-pill"><?php echo date_format(date_create($result['expire']), 'd-m-Y'); ?></span>
                                <?php } else { ?>
                                    <span class="badge badge-danger badge-sm badge-pill"><?php echo date_format(date_create($result['expire']), 'd-m-Y'); ?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <h5 class="font-500 text-primary font-16 m-0"><?php echo $lang['common']['text_address']; ?></h5>
                            </div>
                            <div class="col-12 col-md-9">
                                <p class="mb-1 d-inline-block"><?php echo $result['address']['address1'].', '.$result['address']['address2']; ?></p>
                                <p class="mb-1 d-inline-block"><?php echo $result['address']['city'].', '.$result['address']['state'].', '; ?></p>
                                <p class="mb-1 d-inline-block"><?php echo $result['address']['country']; ?></p>
                                <p class="mb-1"><span class="font-500"><?php echo $lang['contact']['text_pincode'] ?> </span> - <?php echo $result['address']['pin']; ?></p>
                                <p class="mb-1"><span class="font-500"><?php echo $lang['common']['text_phone_number'] ?></span> - <?php echo $result['address']['phone1']; ?></p>
                                <p class="mb-1"><span class="font-500"><?php echo $lang['contact']['text_fax']; ?></span> - <?php echo $result['address']['fax']; ?></p>
                            </div>
                        </div>
                        <h5 class="font-500 font-16 text-primary mt-4"><?php echo $lang['contact']['text_remark']; ?></h5>
                        <div class="mb-4"><?php echo html_entity_decode($result['remark']); ?></div>
                        
                    </div>
                </div>
            </div>
            <div id="invoice" class="tab-pane">
                <div class="panel panel-default">
                    <div class="panel-head">
                        <div class="panel-title">
                            <i class="icon-emotsmile panel-head-icon"></i>
                            <span class="panel-title-text"><?php echo $lang['common']['text_invoices']; ?></span>
                        </div>
                        <div class="panel-action">

                        </div>  
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $lang['contact']['text_company']; ?></th>
                                        <th><?php echo $lang['contact']['text_amount']; ?></th>
                                        <th><?php echo $lang['contact']['text_balance_due']; ?></th>
                                        <th><?php echo $lang['common']['text_created_date']; ?></th>
                                        <th><?php echo $lang['common']['text_status']; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($invoices)) { foreach ($invoices as $key => $value) { ?>
                                        <tr>
                                            <td><a href="<?php echo URL.DIR_ROUTE . 'invoice/view&id=' .$value['id']; ?>" class="text-primary">INV-<?php echo str_pad($value['id'], 4, '0', STR_PAD_LEFT); ?></a></td>
                                            <td><?php echo $result['company']; ?></td>
                                            <td><?php echo $value['abbr'].' '.$value['amount']; ?></td>
                                            <td><?php echo $value['abbr'].' '.$value['due']; ?></td>
                                            <td><i class="far fa-clock mr-2 text-muted"></i><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></td>
                                            <td>
                                                <?php if ($value['status'] == "Paid") { ?>
                                                    <span class="badge badge-Paid badge-pill badge-sm"><?php echo $lang['contact']['text_paid']; ?></span>
                                                <?php } elseif ($value['status'] == "Unpaid") { ?>
                                                    <span class="badge badge-Unpaid badge-pill badge-sm"><?php echo $lang['contact']['text_unpaid']; ?></span>
                                                <?php } elseif ($value['status'] == "Pending") { ?>
                                                    <span class="badge badge-Pending badge-pill badge-sm"><?php echo $lang['contact']['text_pending']; ?></span>
                                                <?php } elseif ($value['status'] == "In Process") { ?>
                                                    <span class="badge badge-In-Process badge-pill badge-sm"><?php echo $lang['contact']['text_in_process']; ?></span>
                                                <?php } elseif ($value['status'] == "Cancelled") { ?>
                                                    <span class="badge badge-Cancelled badge-pill badge-sm"><?php echo $lang['contact']['text_cancelled']; ?></span>
                                                <?php } elseif ($value['status'] == "Other") { ?>
                                                    <span class="badge badge-Other badge-pill badge-sm"><?php echo $lang['contact']['text_other']; ?></span>
                                                <?php } elseif ($value['status'] == "Partially Paid") { ?>
                                                    <span class="badge badge-Partially-Paid badge-pill badge-sm"><?php echo $lang['contact']['text_partially_paid']; ?></span>
                                                <?php } else { ?>
                                                    <span class="badge badge-Unknown badge-pill badge-sm"><?php echo $lang['contact']['text_unknown']; ?></span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } } else { ?>
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <span class="font-16"><?php echo $lang['common']['text_no_data_found']; ?></span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="quotes" class="tab-pane">
                <div class="panel panel-default">
                    <div class="panel-head">
                        <div class="panel-title">
                            <i class="icon-emotsmile panel-head-icon"></i>
                            <span class="panel-title-text"><?php echo $lang['common']['text_quotes']; ?></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $lang['common']['text_project']; ?></th>
                                        <th><?php echo $lang['contact']['text_company']; ?></th>
                                        <th><?php echo $lang['contact']['text_amount']; ?></th>
                                        <th><?php echo $lang['contact']['text_expiry_date']; ?></th>
                                        <th><?php echo $lang['common']['text_created_date']; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($quotes)) { 
                                        foreach ($quotes as $key => $value) { $amount = json_decode($value['total'], true)['amount']; ?>
                                        <tr>
                                            <td><a href="<?php echo URL.DIR_ROUTE . 'invoice/view&id=' .$value['id']; ?>" class="text-primary">QTN-<?php echo str_pad($value['id'], 4, '0', STR_PAD_LEFT); ?></a></td>
                                            <td><?php echo $value['project_name']; ?></td>
                                            <td><?php echo $result['company']; ?></td>
                                            <td><?php echo $value['abbr'].' '.$amount; ?></td>
                                            <td><i class="far fa-clock mr-2 text-muted"></i><?php echo date_format(date_create($value['expiry']), 'd-m-Y'); ?></td>
                                            <td><i class="far fa-clock mr-2 text-muted"></i><?php echo date_format(date_create($value['date']), 'd-m-Y'); ?></td>
                                        </tr>
                                    <?php } } else { ?>
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <span class="font-16"><?php echo $lang['common']['text_no_data_found']; ?></span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="contact_persons" class="tab-pane">
                <div class="panel panel-default">
                    <div class="panel-head">
                        <div class="panel-title">
                            <i class="icon-emotsmile panel-head-icon"></i>
                            <span class="panel-title-text"><?php echo $lang['contact']['text_contact_persons']; ?></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><?php echo $lang['common']['text_name']; ?></th>
                                        <th><?php echo $lang['common']['text_email_address']; ?></th>
                                        <th><?php echo $lang['common']['text_mobile_number']; ?></th>
                                        <th><?php echo $lang['common']['text_skype']; ?></th>
                                        <th><?php echo $lang['contact']['text_designation']; ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result['persons']) { foreach ($result['persons'] as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo $value['salutation'].' '.$value['name']; ?></td>
                                            <td><?php echo $value['email']; ?></td>
                                            <td><?php echo $value['mobile']; ?></td>
                                            <td><?php echo $value['skype']; ?></td>
                                            <td><span class="badge badge-light badge-sm badge-pill"><?php echo $value['designation']; ?></span></td>
                                        </tr>
                                    <?php } } else { ?>
                                        <tr>
                                            <td colspan="5" class="text-center"><?php echo $lang['common']['text_no_records_available']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="clients" class="tab-pane">
                <div class="panel panel-default">
                    <div class="panel-head">
                        <div class="panel-title">
                            <i class="icon-emotsmile panel-head-icon"></i>
                            <span class="panel-title-text"><?php echo $lang['common']['text_client']; ?><small class="text-muted ml-1">(<?php echo $lang['contact']['text_user_registered_on_client_portal']; ?>)</small></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php if (!empty($client['id'])) { ?>
                            <ul class="timeline">
                                <?php if (!empty($clientactivity)) { foreach ($clientactivity as $key => $value) { ?>
                                    <li>
                                        <div class="time"><small><?php echo $value['date_of_joining']; ?></small></div>
                                        <a class="timeline-container">
                                            <div class="arrow"></div>
                                            <?php if ($value['name'] == "login") { ?>
                                                <div class="description">Client Logged in successfully.</div>
                                            <?php } elseif ($value['name'] == "register") { ?>
                                                <div class="description">Client has registered successfully.</div>
                                            <?php } elseif ($value['name'] == "forgot") { ?>
                                                <div class="description">Client has submitted forgot password query.</div>
                                            <?php } elseif ($value['name'] == "reset") { ?>
                                                <div class="description">Client Changed password Successfully</div>
                                            <?php } elseif ($value['name'] == "profile") { ?>
                                                <div class="description">Client updated their profile.</div>
                                            <?php } elseif ($value['name'] == "changepassword") { ?>
                                                <div class="description">Client has changed password.</div>
                                            <?php } else { ?>
                                                <div class="description">Unkown</div>
                                            <?php } ?>
                                            <div class="author"><?php echo $value['ip']; ?></div>
                                        </a>
                                    </li>
                                <?php } } ?>
                            </ul>
                        <?php } else { ?>
                            <div class="row">
                                <div class="col-12">
                                    <p class="font-16"><?php echo $lang['contact']['text_client_has_not_created_account_at_client_portal']; ?></p>
                                </div>
                            </div> 
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Send Email Modal -->
<div id="contactMail" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $lang['contact']['text_send_mail']; ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?php echo URL.DIR_ROUTE .'contact/sentmail';?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="col-form-label"><?php echo $lang['contact']['text_to']; ?></label>
                            <input type="text" class="form-control" value="<?php echo $result['email'] ?>" placeholder="<?php echo $lang['contact']['text_to']; ?>" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="col-form-label"><?php echo $lang['contact']['text_bcc']; ?></label>
                            <input type="email" class="form-control" name="mail[bcc]" value="" placeholder="<?php echo $lang['contact']['text_bcc']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['contact']['text_subject']; ?></label>
                        <input type="text" class="form-control" name="mail[subject]" value="" placeholder="<?php echo $lang['contact']['text_subject']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['contact']['text_message']; ?></label>
                        <textarea name="mail[message]" class="summernote1" placeholder="<?php echo $lang['contact']['text_message']; ?>"></textarea>
                    </div>
                    <input type="hidden" name="mail[contact]" value="<?php echo $result['id']; ?>">
                    <input type="hidden" name="mail[to]" value="<?php echo $result['email']; ?>">
                    <input type="hidden" name="mail[name]" value="<?php echo $result['company']; ?>">
                    <input type="hidden" name="_token" value="<?php echo $token; ?>">
                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-primary btn-gradient btn-pill" name="submit"><?php echo $lang['contact']['text_send']; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script type="text/javascript" src="public/js/custom.summernote.js"></script>

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>