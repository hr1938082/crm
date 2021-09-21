<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>
    $('#setting').show();
    $('#setting-li').addClass('active');</script>
</script>
<!-- payment Type page start -->
<div class="content">
    <div class="row">
        <div class="col-md-8">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="<?php echo $token; ?>">
                <div class="panel panel-default">
                    <div class="panel-head">
                        <div class="panel-title">
                            <i class="icon-credit-card panel-head-icon"></i>
                            <span class="panel-title-text"><?php echo $result['name']; ?></span>
                        </div>
                        <div class="panel-action">
                            <button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" title="<?php echo $lang['common']['text_save']; ?>"><i class="far fa-save"></i></button>
                        </div>  
                    </div>
                    <div class="panel-wrapper">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-form-label"><?php echo $lang['common']['text_template'].' '.$lang['common']['text_name']; ?></label>
                                <input type="text" class="form-control" name="mail[name]" value="<?php echo $result['name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"><?php echo $lang['common']['text_subject']; ?></label>
                                <input type="text" class="form-control" name="mail[subject]" value="<?php echo $result['subject']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"><?php echo $lang['common']['text_body']; ?></label>
                                <textarea name="mail[message]" class="summernote1"><?php echo $result['message']; ?></textarea>
                            </div>
                            <input type="hidden" name="mail[template]" value="<?php echo $result['template']; ?>">
                        </div>
                    </div>
                    <div class="panel-footer text-center">
                        <button type="submit" name="submit" class="btn btn-primary btn-gradient btn-pill"><?php echo $lang['common']['text_save']; ?></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <?php include (DIR.'app/views/template/template_menu.tpl.php'); ?>
        </div>
    </div>
</div>
<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script type="text/javascript" src="public/js/custom.summernote.js"></script>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>