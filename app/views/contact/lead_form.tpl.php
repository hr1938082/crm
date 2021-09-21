<?php include (DIR.'app/views/common/header.tpl.php');?>
<script>$('#lead-li').addClass('active');</script>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="fas fa-bullhorn panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <button type="submit" class="btn btn-primary btn-icon" name="submit" data-toggle="tooltip" title="Save Page"><i class="far fa-save"></i></button>
                <a href="<?php echo URL.DIR_ROUTE.'leads'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="Back to List"><i class="fa fa-reply"></i></a>
                <?php if (empty($result['contact_id']) && !empty($result['id'])) { ?>
                    <a href="<?php echo URL.DIR_ROUTE . 'lead/convert&id='.$result['id'].'&token='.$token; ?>" class="btn btn-secondary btn-sm pt-2 pb-2"><?php echo $lang['contact']['text_convert_to_contact']; ?></a>
                <?php } elseif (!empty($result['id'])) { ?>
                    <a href="<?php echo URL.DIR_ROUTE . 'contact/edit&id='.$result['contact_id']; ?>" class="btn btn-default btn-sm pt-2 pb-2"><?php echo $lang['contact']['text_converted_to_contact']; ?></a>
                <?php } ?>
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
                    <a class="nav-link" href="#remarks" data-toggle="tab"><i class="icon-bubbles mr-2"></i><?php echo $lang['contact']['text_remark']; ?></a>
                </li>
            </ul>
             
            <div class="panel-wrapper p-3">
                <div class="tab-content mt-3 pl-4 pr-4">
                    <div class="tab-pane active" id="basic-info">
                        <?php if ($admin) { ?>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_staff']; ?></label>
                                <div class="col-md-10 customer-search"> 
                                    <select name="contact[staff]" class="selectpicker" data-width="100%" data-live-search="true" title="Assign Staff">
                                        <?php  if ($staff) { foreach ($staff as $key => $value) { ?>
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
                                <label for="col-form-label">Website name</label>
                            </div>
                            <div class="col-md-10">    
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-frown"></i></span>
                                        </div>
                                        <select class="custom-select" name="contact[website_id]" required>
                                            <option selected disabled>Website name</option>
                                            <?php
                                                $select = "";
                                                foreach ($websites as $value) {
                                                    if($result['website_id'] == $value['id'])
                                                    {
                                                        $select = "selected";
                                                    }
                                            ?>
                                                <option <?php echo $select;?> value="<?php echo $value['id'];?>"><?php echo $value['name'];?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            <label class="col-md-2 col-form-label"><?php echo $lang['contact']['text_source']; ?></label>
                            <div class="col-md-10 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-star"></i></span>
                                </div>
                                <input type="text" class="form-control" name="contact[source]" value="<?php echo $result['source']; ?>" placeholder="<?php echo $lang['contact']['text_source']; ?>" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Marketing</label>
                            <div class="col-md-10">
                                <div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
                                    <input type="checkbox" name="contact[marketing][email]" class="custom-control-input" id="marketing-email" value="email" <?php if (!empty($result['marketing']['email']) && $result['marketing']['email'] == "email") { echo "checked"; } ?>>
                                    <label class="custom-control-label" for="marketing-email">Email</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
                                    <input type="checkbox" name="contact[marketing][phone]" class="custom-control-input" id="marketing-phone" value="phone" <?php if (!empty($result['marketing']['phone']) && $result['marketing']['phone'] == "phone") { echo "checked"; } ?>>
                                    <label class="custom-control-label" for="marketing-phone">Phone</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
                                    <input type="checkbox" name="contact[marketing][sms]" class="custom-control-input" id="marketing-sms" value="sms" <?php if (!empty($result['marketing']['sms']) && $result['marketing']['sms'] == "sms") { echo "checked"; } ?>>
                                    <label class="custom-control-label" for="marketing-sms">SMS</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
                                    <input type="checkbox" name="contact[marketing][social]" class="custom-control-input" id="marketing-social" value="social" <?php if (!empty($result['marketing']['social']) && $result['marketing']['social'] == "social") { echo "checked"; } ?>>
                                    <label class="custom-control-label" for="marketing-social">Social Media</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"><?php echo $lang['common']['text_status']; ?></label>
                            <div class="col-md-10 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-check"></i></span>
                                </div>
                                <select name="contact[status]" class="custom-select">
                                    <option value="1" <?php if ($result['status'] == "1") { echo "selected"; } ?>><?php echo $lang['common']['text_new']; ?></option>
                                    <option value="2" <?php if ($result['status'] == "2") { echo "selected"; } ?>><?php echo $lang['contact']['text_attempted']; ?></option>
                                    <option value="3" <?php if ($result['status'] == "3") { echo "selected"; } ?>><?php echo $lang['contact']['text_not_attempted']; ?></option>
                                    <option value="4" <?php if ($result['status'] == "4") { echo "selected"; } ?>><?php echo $lang['contact']['text_working']; ?></option>
                                    <option value="5" <?php if ($result['status'] == "5") { echo "selected"; } ?>><?php echo $lang['contact']['text_contacted']; ?></option>
                                    <option value="6" <?php if ($result['status'] == "6") { echo "selected"; } ?>><?php echo $lang['contact']['text_converted_qualified']; ?></option>
                                    <option value="7" <?php if ($result['status'] == "7") { echo "selected"; } ?>><?php echo $lang['contact']['text_disqualified']; ?> </option>
                                </select>
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
                    </div>
                    <div class="tab-pane" id="remarks">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['contact']['text_remark']; ?></label>
                            <textarea class="summernote" name="contact[remark]"><?php echo $result['remark']; ?></textarea>
                        </div>
                    </div>
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

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>