<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#contact').show();$('#contact-li').addClass('active');</script>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-emotsmile panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" title="Save Page"><i class="far fa-save"></i></button>
                <a href="<?php echo URL.DIR_ROUTE . 'contacts'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="Back to List"><i class="fa fa-reply"></i></a>
            </div>  
        </div>
        <div class="panel-wrapper">
            <input type="hidden" name="_token" value="<?php echo $token; ?>">
            <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-primary pt-3">
                <li class="nav-item">
                    <a class="nav-link active" href="#basic-info" data-toggle="tab"><i class="icon-home mr-2"></i><?php echo $lang['contact']['text_basic_info']; ?></a>
                </li>
                <li class="nav-item dropdown">  
                    <a class="nav-link" href="#address" data-toggle="tab"><i class="icon-location-pin mr-2"></i><?php echo $lang['common']['text_address']; ?></a>
                </li>
                <li class="nav-item dropdown">  
                    <a class="nav-link" href="#contact-person" data-toggle="tab"><i class="icon-screen-smartphone mr-2"></i><?php echo $lang['contact']['text_contact_persons']; ?></a>
                </li>
                <li class="nav-item dropdown">  
                    <a class="nav-link" href="#remarks" data-toggle="tab"><i class="icon-bubbles mr-2"></i><?php echo $lang['contact']['text_remark']; ?></a>
                </li>
                <?php if (!empty($result['id'])) { ?>
                    <li class="nav-item dropdown">  
                        <a class="nav-link" href="#client" data-toggle="tab"><i class="icon-bubbles mr-2"></i><?php echo $lang['common']['text_client'].' '.$lang['common']['text_portal']; ?></a>
                    </li>
                <?php } ?>
            </ul>
            <div class="panel-wrapper p-3">
                <div class="tab-content mt-3 pl-4 pr-4">
                    <div class="tab-pane active" id="basic-info">
                        <?php if ($admin) { ?>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_staff']; ?></label>
                                <div class="col-md-10 customer-search">
                                    <select name="contact[staff]" class="selectpicker" data-width="100%" data-live-search="true" title="<?php echo $lang['contact']['text_assign_staff']; ?>">
                                        <?php if ($staff) { foreach ($staff as $key => $value) { ?>
                                            <option value="<?php echo $value['user_id']; ?>" <?php if ($result['user_id'] == $value['user_id']) { echo "selected"; } ?> ><?php echo $value['name'].' ('.$value['user_name'].')'; ?></option>
                                        <?php } } ?>
                                    </select> 
                                </div>
                            </div>
                        <?php } else { ?>
                            <input type="hidden" name="contact[staff]" value="<?php echo $user['user_id']; ?>">
                        <?php } ?>   
                        <div class="row align-items-center">
                            <div class="col-md-2 form-group">
                                <label class="col-form-label"><?php echo $lang['contact']['text_primary_contact']; ?></label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-frown"></i></span>
                                        </div>
                                        <select class="custom-select" name="contact[salutation]" required>
                                            <option value=""><?php echo $lang['contact']['text_salutation']; ?></option>
                                            <option value="<?php echo $lang['contact']['text_mr.']; ?>" <?php if ($result['salutation'] == $lang['contact']['text_mr.']) { echo "selected"; } ?> ><?php echo $lang['contact']['text_mr.']; ?></option>
                                            <option value="<?php echo $lang['contact']['text_mrs.']; ?>" <?php if ($result['salutation'] == $lang['contact']['text_mrs.']) { echo "selected"; } ?>><?php echo $lang['contact']['text_mrs.']; ?></option>
                                            <option value="<?php echo $lang['contact']['text_ms.']; ?>" <?php if ($result['salutation'] == $lang['contact']['text_ms.']) { echo "selected"; } ?>><?php echo $lang['contact']['text_ms.']; ?></option>
                                            <option value="<?php echo $lang['contact']['text_dr.']; ?>" <?php if ($result['salutation'] == $lang['contact']['text_dr.']) { echo "selected"; } ?>><?php echo $lang['contact']['text_dr.']; ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="contact[firstname]" value="<?php echo $result['firstname']; ?>" placeholder="<?php echo $lang['common']['text_first_name']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="contact[lastname]" value="<?php echo $result['lastname']; ?>" placeholder="<?php echo $lang['common']['text_last_name']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row align-items-start">
                            <label class="col-md-2 col-form-label pt-3"><?php echo $lang['contact']['text_company']; ?></label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-building"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="contact[company]" value="<?php echo $result['company']; ?>" placeholder="<?php echo $lang['contact']['text_company']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"><?php echo $lang['common']['text_email_address']; ?></label>
                            <div class="col-md-10 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" name="contact[email]" value="<?php echo $result['email']; ?>" placeholder="<?php echo $lang['common']['text_email_address']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"><?php echo $lang['common']['text_phone_number']; ?></label>
                            <div class="col-md-10 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-phone"></i></span>
                                </div>
                                <input type="number" class="form-control" name="contact[phone]" value="<?php echo $result['phone']; ?>" placeholder="<?php echo $lang['common']['text_phone_number']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"><?php echo $lang['common']['text_website']; ?></label>
                            <div class="col-md-10 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-globe"></i></span>
                                </div>
                                <input type="text" class="form-control" name="contact[website]" value="<?php echo $result['website']; ?>" placeholder="<?php echo $lang['common']['text_website']; ?>" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_marketing']; ?></label>
                            <div class="col-md-10">
                                <div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
                                    <input type="checkbox" name="contact[marketing][email]" class="custom-control-input" id="marketing-email" value="email" <?php if (!empty($result['marketing']['email']) && $result['marketing']['email'] == "email") { echo "checked"; } ?>>
                                    <label class="custom-control-label" for="marketing-email"><?php echo $lang['common']['text_email']; ?></label>
                                </div>
                                <div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
                                    <input type="checkbox" name="contact[marketing][phone]" class="custom-control-input" id="marketing-phone" value="phone" <?php if (!empty($result['marketing']['phone']) && $result['marketing']['phone'] == "phone") { echo "checked"; } ?>>
                                    <label class="custom-control-label" for="marketing-phone"><?php echo $lang['contact']['text_call']; ?></label>
                                </div>
                                <div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
                                    <input type="checkbox" name="contact[marketing][sms]" class="custom-control-input" id="marketing-sms" value="sms" <?php if (!empty($result['marketing']['sms']) && $result['marketing']['sms'] == "sms") { echo "checked"; } ?>>
                                    <label class="custom-control-label" for="marketing-sms"><?php echo $lang['contact']['text_sms']; ?></label>
                                </div>
                                <div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
                                    <input type="checkbox" name="contact[marketing][social]" class="custom-control-input" id="marketing-social" value="social" <?php if (!empty($result['marketing']['social']) && $result['marketing']['social'] == "social") { echo "checked"; } ?>>
                                    <label class="custom-control-label" for="marketing-social"><?php echo $lang['contact']['text_social_media']; ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_expire_date']; ?></label>
                            <div class="col-md-10 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-event"></i></span>
                                </div>
                                <input type="text" name="contact[expire]" class="form-control date" value="<?php echo date_format(date_create($result['expire']), 'd-m-Y'); ?>" placeholder="<?php echo $lang['contact']['text_expire_date']; ?> (dd-mm-yyyy)">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="address">
                        <div class="row form-group">
                            <label class="col-md-2 col-form-label"><?php echo $lang['common']['text_address']; ?></label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-direction"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="contact[address][address1]" value="<?php echo $result['address']['address1'] ?>" placeholder="<?php echo $lang['contact']['text_address_line_1'] ?>">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-directions"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="contact[address][address2]" value="<?php echo $result['address']['address2'] ?>" placeholder="<?php echo $lang['contact']['text_address_line_2'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_city'] ?></label>
                            <div class="col-md-10 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-location-pin"></i></span>
                                </div>
                                <input type="text" class="form-control" name="contact[address][city]" value="<?php echo $result['address']['city'] ?>" placeholder="<?php echo $lang['contact']['text_city'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_state'] ?></label>
                            <div class="col-md-10 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-map"></i></span>
                                </div>
                                <input type="text" class="form-control" name="contact[address][state]" value="<?php echo $result['address']['state'] ?>" placeholder="<?php echo $lang['contact']['text_state'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_country'] ?></label>
                            <div class="col-md-10 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-globe"></i></span>
                                </div>
                                <input type="text" class="form-control" name="contact[address][country]" value="<?php echo $result['address']['country'] ?>" placeholder="<?php echo $lang['contact']['text_country'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_pincode'] ?></label>
                            <div class="col-md-10 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-flag"></i></span>
                                </div>
                                <input type="text" class="form-control" name="contact[address][pin]" value="<?php echo $result['address']['pin'] ?>" placeholder="<?php echo $lang['contact']['text_pincode'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"><?php echo $lang['common']['text_phone_number'] ?></label>
                            <div class="col-md-10 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-phone"></i></span>
                                </div>
                                <input type="text" class="form-control" name="contact[address][phone1]" value="<?php echo $result['address']['phone1'] ?>" placeholder="<?php echo $lang['common']['text_phone_number'] ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_fax']; ?></label>
                            <div class="col-md-10 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-call-in"></i></span>
                                </div>
                                <input type="text" class="form-control" name="contact[address][fax]" value="<?php echo $result['address']['fax'] ?>" placeholder="<?php echo $lang['contact']['text_fax']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="contact-person">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-input font-12">
                                        <thead>
                                            <tr>
                                                <th><?php echo $lang['contact']['text_salutation']; ?></th>
                                                <th><?php echo $lang['common']['text_name']; ?></th>
                                                <th><?php echo $lang['common']['text_email_address']; ?></th>
                                                <th><?php echo $lang['common']['text_mobile_number']; ?></th>
                                                <th><?php echo $lang['common']['text_skype']; ?></th>
                                                <th><?php echo $lang['contact']['text_designation']; ?></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($result['persons']) { foreach ($result['persons'] as $key => $value) { ?>
                                                <tr>
                                                    <td>
                                                        <select class="form-control form-transparent" name="contact[person][<?php echo $key; ?>][salutation]">
                                                            <option value=""><?php echo $lang['contact']['text_salutation']; ?></option>
                                                            <option value="<?php echo $lang['contact']['text_mr.']; ?>" <?php if ($value['salutation'] == $lang['contact']['text_mr.']) { echo "selected"; } ?> ><?php echo $lang['contact']['text_mr.']; ?></option>
                                                            <option value="<?php echo $lang['contact']['text_mrs.']; ?>" <?php if ($value['salutation'] == $lang['contact']['text_mrs.']) { echo "selected"; } ?>><?php echo $lang['contact']['text_mrs.']; ?></option>
                                                            <option value="<?php echo $lang['contact']['text_ms.']; ?>" <?php if ($value['salutation'] == $lang['contact']['text_ms.']) { echo "selected"; } ?>><?php echo $lang['contact']['text_ms.']; ?></option>
                                                            <option value="<?php echo $lang['contact']['text_dr.']; ?>" <?php if ($value['salutation'] == $lang['contact']['text_dr.']) { echo "selected"; } ?>><?php echo $lang['contact']['text_dr.']; ?></option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-transparent" name="contact[person][<?php echo $key; ?>][name]" value="<?php echo $value['name'] ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-transparent" name="contact[person][<?php echo $key; ?>][email]" value="<?php echo $value['email'] ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-transparent" name="contact[person][<?php echo $key; ?>][mobile]" value="<?php echo $value['mobile'] ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-transparent" name="contact[person][<?php echo $key; ?>][skype]" value="<?php echo $value['skype'] ?>">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-transparent" name="contact[person][<?php echo $key; ?>][designation]" value="<?php echo $value['designation'] ?>">
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="#" class="delete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-close text-danger text-danger p-1 m-1"></i></a>
                                                    </td>
                                                </tr>
                                            <?php } } else { ?>
                                                <tr>
                                                    <td>
                                                        <select class="form-control form-transparent" name="contact[person][0][salutation]">
                                                            <option value=""><?php echo $lang['contact']['text_salutation']; ?></option>
                                                            <option value="<?php echo $lang['contact']['text_mr.']; ?>"><?php echo $lang['contact']['text_mr.']; ?></option>
                                                            <option value="<?php echo $lang['contact']['text_mrs.']; ?>"><?php echo $lang['contact']['text_mrs.']; ?></option>
                                                            <option value="<?php echo $lang['contact']['text_ms.']; ?>"><?php echo $lang['contact']['text_ms.']; ?></option>
                                                            <option value="<?php echo $lang['contact']['text_dr.']; ?>"><?php echo $lang['contact']['text_dr.']; ?></option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-transparent" name="contact[person][0][name]">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-transparent" name="contact[person][0][email]">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-transparent" name="contact[person][0][mobile]">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-transparent" name="contact[person][0][skype]">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-transparent" name="contact[person][0][designation]">
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="#" class="delete" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['common']['text_delete']; ?>"><i class="fa fa-close text-danger text-danger p-1 m-1"></i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="mb-3 mt-3">
                                    <a href="#" class="btn btn-success btn-sm add-person"><i class="icon-plus mr-2"></i> <?php echo $lang['contact']['text_add_person']; ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="remarks">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['contact']['text_remark'].'('.$lang['contact']['text_for_internal_use'].')'; ?></label>
                            <textarea class="summernote" name="contact[remark]"><?php echo $result['remark']; ?></textarea>
                        </div>
                    </div>
                    <?php if (!empty($result['id'])) { ?>
                        <div class="tab-pane" id="client">
                            <?php if (!empty($client['id'])) { ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                            <label class="col-form-label"><?php echo $lang['common']['text_name']; ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?php echo $client['name']; ?>" placeholder="<?php echo $lang['common']['text_name']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group"> 
                                            <label class="col-form-label"><?php echo $lang['common']['text_email_address']; ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-envelope"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?php echo $client['email']; ?>" placeholder="<?php echo $lang['common']['text_email_address']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group"> 
                                            <label class="col-form-label"><?php echo $lang['common']['text_mobile_number']; ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-phone"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?php echo $client['mobile']; ?>" placeholder="<?php echo $lang['common']['text_mobile_number']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group"> 
                                            <label class="col-form-label"><?php echo $lang['common']['text_created_date']; ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="<?php echo date_format(date_create($client['date_of_joining']), 'd-m-Y'); ?>" placeholder="<?php echo $lang['common']['text_created_date']; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="col-form-label"><?php echo $lang['common']['text_status']; ?></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="icon-check"></i></span>
                                                </div>
                                                <select class="custom-select" name="client[status]" required>
                                                    <option value="1" <?php if ($client['status'] == "1") { echo "selected"; } ?>><?php echo $lang['common']['text_active']; ?></option>
                                                    <option value="0" <?php if ($client['status'] == "0") { echo "selected"; } ?>><?php echo $lang['common']['text_inactive']; ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="client[client_id]" value="<?php echo $client['id']; ?>">
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="row">
                                    <div class="col-12">
                                        <p class="font-16"><?php echo $lang['contact']['text_client_has_not_created_account_at_client_portal']; ?></p>
                                    </div>
                                </div> 
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="submit" name="submit" class="btn btn-primary btn-gradient btn-pill"><?php echo $lang['common']['text_save']; ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script type="text/javascript" src="public/js/custom.summernote.js"></script>
<script>
    //********************************************
    //Add Contact Persons ************************
    //********************************************
    $('#contact-person').on('click', '.add-person', function () {
        var count = $('#contact-person table tr:last select').attr('name').split('[')[2];
        count = parseInt(count.split(']')[0]) + 1;
        $('#contact-person table tbody').append('<tr><td>'+
            '<select class="form-control form-transparent" name="contact[person]['+count+'][salutation]">'+
            '<option>Salutation</option>'+
            '<option value="<?php echo $lang['contact']['text_mr.']; ?>"><?php echo $lang['contact']['text_mr.']; ?></option>'+
            '<option value="<?php echo $lang['contact']['text_mrs.']; ?>"><?php echo $lang['contact']['text_mrs.']; ?></option>'+
            '<option value="<?php echo $lang['contact']['text_ms.']; ?>"><?php echo $lang['contact']['text_ms.']; ?></option>'+
            '<option value="<?php echo $lang['contact']['text_dr.']; ?>"><?php echo $lang['contact']['text_dr.']; ?></option>'+
            '</select>'+
            '</td>'+
            '<td><input type="text" class="form-transparent" name="contact[person]['+count+'][name]"></td>'+
            '<td><input type="text" class="form-transparent" name="contact[person]['+count+'][email]"></td>'+
            '<td><input type="text" class="form-transparent" name="contact[person]['+count+'][mobile]"></td>'+
            '<td><input type="text" class="form-transparent" name="contact[person]['+count+'][skype]"></td>'+
            '<td><input type="text" class="form-transparent" name="contact[person]['+count+'][designation]"></td>'+
            '<td class="text-center">'+
            '<a href="#" class="delete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-close text-danger text-danger p-1 m-1"></i></a>'+
            '</td></tr>');

        return false;
    });

    $('#contact-person').on('click', '.delete', function () {
        $(this).parents('tr').remove();
    })
</script>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>