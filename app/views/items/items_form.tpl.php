<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>
    $('#setting').show();
    $('#setting-li').addClass('active');</script>
</script>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-list panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" title="<?php echo $lang['common']['text_save']; ?>"><i class="far fa-save"></i></button>
                <a href="<?php echo URL.DIR_ROUTE.'items'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="<?php echo $lang['common']['text_back_to_list']; ?>"><i class="fa fa-reply"></i></a>
            </div>  
        </div>
        <div class="panel-wrapper p-3">
            <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
            <input type="hidden" name="_token" value="<?php echo $token; ?>">
            <div class="mt-3 pl-4 pr-4">
                <div class="row">
                    <div class="form-group col-sm-2 p-0">
                        <label class="col-form-label"><?php echo $lang['settings']['text_type']; ?></label>
                    </div>
                    <div class="col-sm-10">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="goods" name="type" class="custom-control-input" value="1" <?php if ($result['type'] == "1") {echo "checked";} ?> required>
                            <label class="custom-control-label" for="goods"><?php echo $lang['settings']['text_goods']; ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="servies" name="type" class="custom-control-input" value="2" <?php if ($result['type'] == "2") {echo "checked";} ?> required>
                            <label class="custom-control-label" for="servies"><?php echo $lang['settings']['text_service']; ?></label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="other" name="type" class="custom-control-input" value="3" <?php if ($result['type'] == "3") {echo "checked";} ?> required>
                            <label class="custom-control-label" for="other"><?php echo $lang['settings']['text_other']; ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"><?php echo $lang['common']['text_name']; ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $result['name'] ?>" name="name" placeholder="<?php echo $lang['common']['text_name']; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"><?php echo $lang['settings']['text_unit']; ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $result['unit'] ?>" name="unit" placeholder="<?php echo $lang['settings']['text_unit']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"><?php echo $lang['settings']['text_price']; ?></label>
                    <div class="col-sm-2">
                        <select class="custom-select background-default" name="currency">
                            <?php if (!empty($currency)) { foreach ($currency as $key => $value) { ?>
                            <option value="<?php echo $value['id'] ?>" <?php if ($result['currency'] == $value['id']) { echo "selected"; } ?>><?php echo $value['name']; ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="price" value="<?php echo $result['price'] ?>" placeholder="<?php echo $lang['settings']['text_price']; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"><?php echo $lang['common']['text_description']; ?></label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="description" placeholder="<?php echo $lang['common']['text_description']; ?>"><?php echo $result['description'] ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer text-center">
            <button type="submit" name="submit" class="btn btn-primary btn-gradient btn-pill"><?php echo $lang['common']['text_save']; ?></button>
        </div>
    </div>
</form>

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>