<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>
    $('#setting').show();
    $('#setting-li').addClass('active');</script>
</script>
<!-- payment Type page start -->
<div class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <form action="<?php echo $action; ?>" method="post">
                    <input type="hidden" name="_token" value="<?php echo $token; ?>">
                    <div class="panel-head">
                        <div class="panel-title">
                            <i class="icon-credit-card panel-head-icon"></i>
                            <span class="panel-title-text"><?php echo $page_title; ?></span>
                        </div>
                    </div>
                    <div class="panel-wrapper">
                        <div class="mt-3 pl-4 pr-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="col-form-label"><?php echo $lang['settings']['text_paypal_username']; ?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-user"></i></span>
                                            </div>
                                            <input type="text" name="gateway[username]" class="form-control" value="<?php echo $result['username'] ?>" placeholder="<?php echo $lang['settings']['text_paypal_username']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label"><?php echo $lang['settings']['text_paypal_mode']; ?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-bulb"></i></span>
                                            </div>
                                            <select name="gateway[mode]" class="custom-select">
                                                <option value="0" <?php if ($result['mode'] == "0") { echo "selected"; } ?>>Sandbox</option>
                                                <option value="1" <?php if ($result['mode'] == "1") { echo "selected"; } ?>>Live</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label"><?php echo $lang['common']['text_status']; ?></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-check"></i></span>
                                            </div>
                                            <select name="gateway[status]" class="custom-select">
                                                <option value="1" <?php if ($result['status'] == "1") { echo "selected"; } ?>><?php echo $lang['settings']['text_active']; ?></option>
                                                <option value="0" <?php if ($result['status'] == "0") { echo "selected"; } ?>><?php echo $lang['settings']['text_inactive']; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-center">
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" name="submit" class="btn btn-primary btn-gradient btn-pill"><?php echo $lang['common']['text_save']; ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <?php include (DIR.'app/views/common/setting_menu_finance.tpl.php'); ?>
        </div>
    </div>
</div>
<script>
    $('#finance-gateway').addClass('active');
</script>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>