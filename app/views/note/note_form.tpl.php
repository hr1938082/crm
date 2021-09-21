<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#note-li').addClass('active');</script>

<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-note panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" title="<?php echo $lang['common']['text_save']; ?>"><i class="far fa-save"></i></button>
                <a href="<?php echo URL.DIR_ROUTE . 'notes'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="<?php echo $lang['common']['text_back_to_list']; ?>"><i class="fa fa-reply"></i></a>
            </div>  
        </div>
        <div class="panel-wrapper p-3">
            <input type="hidden" name="_token" value="<?php echo $token; ?>">
            <div class="mt-3 pl-4 pr-4">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2"><?php echo $lang['notes']['text_note_title']; ?></label>
                            <div class="input-group col-sm-10">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-note"></i></span>
                                </div>
                                <input type="text" name="note[title]" class="form-control" value="<?php echo $result['title']; ?>" placeholder="<?php echo $lang['notes']['text_note_title']; ?>">
                            </div>
                        </div>
                        <div class="form-group row align-items-start">
                            <label class="col-form-label col-sm-2"><?php echo $lang['common']['text_description']; ?></label>
                            <div class="col-sm-10">
                                <textarea name="note[descr]" class="summernote"><?php echo $result['description']; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2"><?php echo $lang['notes']['text_background_color']; ?></label>
                            <div class="col-sm-10">
                                <div class="colorPickSelector"></div>
                                <input type="hidden" class="note-background" name="note[background]" value="<?php echo $result['background']; ?>">
                                <input type="hidden" class="note-color" name="note[color]" value="<?php echo $result['color']; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2"><?php echo $lang['common']['text_status']; ?></label>
                            <div class="input-group col-sm-10">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-check"></i></span>
                                </div>
                                <select name="note[status]" class="custom-select">
                                    <option value="0" <?php if ($result['status'] == "0") { echo "selected"; } ?>><?php echo $lang['notes']['text_in_process']; ?></option>
                                    <option value="1" <?php if ($result['status'] == "1") { echo "selected"; } ?>><?php echo $lang['notes']['text_completed']; ?></option>
                                </select>
                            </div>
                        </div>
                        <?php if (!empty($result['id'])) { ?>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2"><?php echo $lang['common']['text_created_date']; ?></label>
                            <div class="input-group col-sm-10">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control" value="<?php echo date_format(date_create($result['date_of_joining']), 'd M Y'); ?>" placeholder="<?php echo $lang['common']['text_created_date']; ?>" readonly>
                            </div>
                        </div>
                        <?php } ?>
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
<input type="hidden" name="system_lang" value="<?php echo $info['language'] ?>">

<!-- include summernote css/js-->
<link href="public/css/summernote-bs4.css" rel="stylesheet">
<script type="text/javascript" src="public/js/summernote-bs4.min.js"></script>
<script type="text/javascript" src="public/js/custom.summernote.js"></script>

<link rel="stylesheet" href="public/css/colorPick.min.css">
<script type="text/javascript" src="public/js/colorPick.min.js"></script>
<script>
    <?php $background = '#F39C12'; if (!empty($result['background'])) { $background = $result['background']; } ?>
    $(".colorPickSelector").colorPick({
        'initialColor': <?php echo " '". $background. "'"; ?>,
        'allowRecent': true,
        'recentMax': 5,
        'palette': [ "#FFF", "#FAD154", "#cfc4ff", "#f7bfff", "#61d1ff","#85ebd9","#c4ffed","#def58f", "#d9e8f0", "#ffed7d", "#ffd921", "#ff9c00", "#fa9959", "#b3d9e6", "#bac28a", "#d1ebb8", "#d1d9c9", "#ffdb70", "#ffa8b3", "#e3e3e3", "#abd1c9", "#e8ba2b", "#9cc2d6", "#d4e0e3", "#ffc27d", "#e8b01c", "#57c2ff", "#bfd9c2", "#82d9de", "#abc29e", "#f0c221", "#0096a8", "#ECF0F1", "#BDC3C7", "#95A5A6", "#7F8C8D", "#CFC", "#FFC", "#CCF", "#1ABC9C"],
        'onColorSelected': function() {
            this.element.css({'backgroundColor': this.color, 'color': this.color});
            $('.note-background').val(this.color);
            if (this.color == "#0096A8" || this.color == "#95A5A6" || this.color == "#7F8C8D" || this.color == "#1ABC9C") {
                $('.note-color').val("#FFFFFF");
            } else {
                $('.note-color').val("#000000");
            }
        }
    });
</script>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>