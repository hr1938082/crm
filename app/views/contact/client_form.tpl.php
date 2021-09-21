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
                <button type="submit" class="btn btn-info btn-icon" name="submit" data-toggle="tooltip" title="<?php echo $lang['common']['text_save']; ?>"><i class="far fa-save"></i></button>
                <a href="<?php echo URL.DIR_ROUTE . 'clients'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="<?php echo $lang['common']['text_back_to_list']; ?>"><i class="fa fa-reply"></i></a>
            </div>  
        </div>
        <div class="panel-wrapper p-3">
            <input type="hidden" name="_token" value="<?php echo $token; ?>">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-form-label"><?php echo $lang['common']['text_name']; ?></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="client[name]" value="<?php echo $result['name']; ?>" placeholder="<?php echo $lang['common']['text_name']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label"><?php echo $lang['common']['text_email_address']; ?></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-envelope"></i></span>
                        </div>
                        <input type="text" class="form-control" value="<?php echo $result['email']; ?>" placeholder="<?php echo $lang['common']['text_email_address']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label"><?php echo $lang['common']['text_mobile_number']; ?></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-phone"></i></span>
                        </div>
                        <input type="text" class="form-control" name="client[mobile]" value="<?php echo $result['mobile']; ?>" placeholder="<?php echo $lang['common']['text_mobile_number']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label"><?php echo $lang['common']['text_created_date']; ?></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar"></i></span>
                        </div>
                        <input type="text" class="form-control" value="<?php echo date_format(date_create($result['date_of_joining']), 'd-m-Y'); ?>" placeholder="<?php echo $lang['common']['text_created_date']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Status</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-check"></i></span>
                        </div>
                        <select name="client[status]" class="custom-select">
                            <option value="1" <?php if ($result['status'] == "1") { echo "selected"; } ?>><?php echo $lang['common']['text_active']; ?></option>
                            <option value="0" <?php if ($result['status'] == "0") { echo "selected"; } ?>>In <?php echo $lang['common']['text_inactive']; ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" name="client[id]" value="<?php echo $result['id']; ?>">
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-12 text-center">
                    <button type="submit" name="submit" class="btn btn-info"><?php echo $lang['common']['text_save']; ?></button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>