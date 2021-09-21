<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#domain-li').addClass('active');</script>

<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-rocket panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" title="<?php echo $lang['common']['text_save']; ?>"><i class="far fa-save"></i></button>
                <a href="<?php echo URL.DIR_ROUTE . 'domains'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="<?php echo $lang['common']['text_back_to_list']; ?>"><i class="fa fa-reply"></i></a>
            </div>  
        </div>
        <div class="panel-wrapper p-3">
            <input type="hidden" name="_token" value="<?php echo $token; ?>">
            <div class="mt-3 pl-4 pr-4">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['common']['text_name']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-user"></i></span>
                                </div>
                                <input type="text" name="domain[name]" class="form-control" value="<?php echo $result['name']; ?>" placeholder="<?php echo $lang['common']['text_name']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['domain']['text_url']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-user"></i></span>
                                </div>
                                <input type="text" name="domain[url]" class="form-control" value="<?php echo $result['url']; ?>" placeholder="<?php echo $lang['domain']['text_url']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['domain']['text_registration_date']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-user"></i></span>
                                </div>
                                <input type="text" name="domain[r_date]" class="form-control date" value="<?php echo $result['registration_date']; ?>" placeholder="<?php echo $lang['domain']['text_registration_date']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['domain']['text_expiry_date']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-user"></i></span>
                                </div>
                                <input type="text" name="domain[e_date]" class="form-control date" value="<?php echo $result['expiry_date']; ?>" placeholder="<?php echo $lang['domain']['text_expiry_date']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['domain']['text_provider']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-user"></i></span>
                                </div>
                                <input type="text" name="domain[provider]" class="form-control" value="<?php echo $result['provider']; ?>" placeholder="<?php echo $lang['domain']['text_provider']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['domain']['text_hosting']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-user"></i></span>
                                </div>
                                <input type="text" name="domain[hosting]" class="form-control" value="<?php echo $result['hosting']; ?>" placeholder="<?php echo $lang['domain']['text_hosting']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group customer-search">
                            <label class="col-form-label"><?php echo $lang['common']['text_customer']; ?></label>
                            <select name="domain[customer]" class="selectpicker" data-width="100%" data-live-search="true" title="<?php echo $lang['common']['text_customer']; ?>">
                                <?php if (!empty($customers)) { foreach ($customers as $key => $value) { ?>
                                <option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $result['customer']) { echo "selected"; } ?>><?php echo $value['company']; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['domain']['text_annual_price']; ?></label>
                            <div class="input-group">
                                <input type="text" name="domain[price]" class="form-control" value="<?php echo $result['price']; ?>" placeholder="<?php echo $lang['domain']['text_annual_price']; ?>">
                                <div class="input-group-append">
                                    <select name="domain[currency]" class="custom-select">
                                        <?php if (!empty($currency)) { foreach ($currency as $key => $value) { ?>
                                        <option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $result['currency']) { echo "selected"; } ?>><?php echo $value['name']; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['common']['text_status']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-user"></i></span>
                                </div>
                                <select name="domain[status]" class="custom-select">
                                    <option value="1" <?php if ($result['status'] == "1") { echo "selected"; } ?>><?php echo $lang['common']['text_active']; ?></option>
                                    <option value="0" <?php if ($result['status'] == "0") { echo "selected"; } ?>><?php echo $lang['common']['text_inactive']; ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label d-block"><?php echo $lang['domain']['text_do_not_renew_after_expiry']; ?></label>
                            <div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
                                <input type="checkbox" name="domain[renew]" class="custom-control-input" id="renew" value="1" <?php if ($result['renew'] == "1") { echo "checked"; } ?>>
                                <label class="custom-control-label" for="renew"><?php echo $lang['domain']['text_do_not_renew_after_expiry']; ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="col-form-label d-block"><?php echo $lang['domain']['text_remark']; ?></label>
                            <textarea name="domain[remark]" class="summernote"><?php echo $result['remark']; ?></textarea>
                        </div>
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
</form>

<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script type="text/javascript" src="public/js/custom.summernote.js"></script>

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>