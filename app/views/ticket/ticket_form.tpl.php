<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#ticket').show();$('#ticket-li').addClass('active');</script>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-8">
            <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
            <div class="panel panel-default">
                <div class="panel-head">
                    <div class="panel-title">
                        <i class="icon-emotsmile panel-head-icon"></i>
                        <span class="panel-title-text"><?php echo $page_title; ?></span>
                    </div>
                    <div class="panel-action">
                        <button type="submit" class="btn btn-primary btn-gradient btn-icon" name="submit" data-toggle="tooltip" title="Save Page"><i class="far fa-save"></i></button>
                        <a href="<?php echo URL.DIR_ROUTE . 'tickets'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="Back to List"><i class="fa fa-reply"></i></a>
                    </div>  
                </div>
                <div class="panel-wrapper">
                    <input type="hidden" name="_token" value="<?php echo $token; ?>">
                    <?php if (empty($result)) { ?>
                    <div class="pt-3 pl-3 pr-3">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['tickets']['text_subject']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="icon-user"></i></span></div>
                                <input type="text" name="ticket[subject]" class="form-control" placeholder="<?php echo $lang['tickets']['text_subject']; ?>">
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="chat p-3">
                        <ul class="chat-history">
                            <?php if (!empty($messages)) { foreach ($messages as $key => $value) { if ($value['message_by'] == "1") { ?>
                            <li class="my-message text-right">
                                <div class="message-data">
                                    <span class="message-data-time"><?php echo $value['date_of_joining']; ?></span>
                                    <span class="message-data-name ml-2"><?php echo $value['user']; ?></span>
                                </div>
                                <div class="message">
                                    <span class="d-block"><?php echo html_entity_decode($value['message']); ?></span>
                                    <?php if (!empty($value['attached'])) { $value['attached'] = json_decode($value['attached'], true); foreach ($value['attached'] as $attached_key => $attached_value) { ?>
                                    <a href="<?php echo URL.DIR_ROUTE.'ticket/fileDownload&name='.urlencode($attached_value); ?>" class="attached-file" target="_blank"><?php echo $attached_value; ?></a>
                                    <?php } } ?>
                                </div>
                            </li>
                            <?php } else { ?>
                            <li class="other-message">
                                <div class="message-data">
                                    <span class="message-data-name mr-2"><?php echo $result['name']; ?></span>
                                    <span class="message-data-time"><?php echo $value['date_of_joining']; ?></span>
                                </div>
                                <div class="message text-left">
                                    <span><?php echo html_entity_decode($value['message']); ?></span>
                                    <?php if (!empty($value['attached'])) { $value['attached'] = json_decode($value['attached'], true); foreach ($value['attached'] as $attached_key => $attached_value) { ?>
                                    <a href="<?php echo URL.DIR_ROUTE.'ticket/fileDownload&name='.urlencode($attached_value); ?>" class="attached-file" target="_blank"><?php echo $attached_value; ?></a>
                                    <?php } } ?>
                                </div>
                            </li>
                            <?php } } } ?>
                        </ul>
                    </div>
                    <?php } ?>
                    <?php if ($result['status'] == "0" || empty($result['id'])) { ?>
                    <div class="p-3">
                        <div class="form-group row align-items-start">
                            <div class="col-12">
                                <label class="col-form-label"><?php echo $lang['tickets']['text_post_reply']; ?></label>
                                <textarea name="ticket[descr]" class="summernote" placeholder="Description"></textarea>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-sm-8 form-group">
                                <label class="col-form-label"><?php echo $lang['tickets']['text_attachments']; ?></label>
                                <div class="attachments">
                                    <div class="custom-file">
                                        <label class="custom-file-label" for="custom_file_1"><?php echo $lang['tickets']['text_choose_file']; ?></label>
                                        <input type="file" name="filename[]" accept="application/pdf, image/gif, image/jpeg, image/png" class="custom-file-input" size="20" onchange="ValidateSize(this);" id="custom_file_1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 text-right">
                                <a class="btn btn-outline btn-primary btn-pill btn-outline-1x btn-sm" id="add-more-file"><?php echo $lang['tickets']['text_add_more_file']; ?></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['tickets']['text_ticket_status']; ?></label>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="ticket[status]" class="custom-control-input" id="ticket-close" value="1">
                                <label class="custom-control-label" for="ticket-close"><?php echo $lang['tickets']['text_close_on_reply']; ?></label>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
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
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-head">
                    <div class="panel-title">
                        <i class="icon-emotsmile panel-head-icon"></i>
                        <span class="panel-title-text"><?php echo $lang['tickets']['text_ticket_info']; ?></span>
                    </div>
                    <div class="panel-action">
                    </div>  
                </div>
                <div class="panel-wrapper p-3">
                    <?php if (empty($result)) { ?>
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['common']['text_name']; ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="icon-user"></i></span></div>
                            <input type="text" name="ticket[name]" class="form-control" value="" placeholder="<?php echo $lang['common']['text_name']; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['common']['text_email_address']; ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="icon-envelope"></i></span></div>
                            <input type="text" name="ticket[email]" class="form-control" value="" placeholder="<?php echo $lang['common']['text_email_address']; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['common']['text_mobile_number']; ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="icon-phone"></i></span></div>
                            <input type="text" name="ticket[mobile]" class="form-control" value="" placeholder="<?php echo $lang['common']['text_mobile_number']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['tickets']['text_department']; ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="icon-user"></i></span></div>
                            <select name="ticket[department]" class="custom-select" required>
                                <?php if ($departments) { foreach ($departments as $key => $value) { ?>
                                <option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $result['departments']) { echo "selected"; } ?>><?php echo $value['name']; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['tickets']['text_priority']; ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="icon-user"></i></span></div>
                            <select name="ticket[priority]" class="custom-select">
                                <option value="Low"><?php echo $lang['tickets']['text_low']; ?></option>
                                <option value="Medium"><?php echo $lang['tickets']['text_medium']; ?></option>
                                <option value="High"><?php echo $lang['tickets']['text_high']; ?></option>
                            </select>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="ticket-info table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td>ID</td>
                                    <td>#<?php echo $result['id']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $lang['tickets']['text_subject']; ?></td>
                                    <td><?php echo $result['subject']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $lang['common']['text_name']; ?></td>
                                    <td><?php echo $result['name']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $lang['common']['text_email_address']; ?></td>
                                    <td><?php echo $result['email']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $lang['tickets']['text_priority']; ?></td>
                                    <td>
                                        <?php if ($result['priority'] == 'Low') { ?>
                                        <span class="badge badge-Low badge-sm badge-pill"><?php echo $lang['tickets']['text_low']; ?></span>
                                        <?php } elseif ($result['priority'] == 'Medium') { ?>
                                        <span class="badge badge-Medium badge-sm badge-pill"><?php echo $lang['tickets']['text_medium']; ?></span>
                                        <?php } else { ?>
                                        <span class="badge badge-High badge-sm badge-pill"><?php echo $lang['tickets']['text_high']; ?></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $lang['tickets']['text_department']; ?></td>
                                    <td><?php echo $result['department']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $lang['common']['text_created_date']; ?></td>
                                    <td><?php echo $result['date_of_joining']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo $lang['tickets']['text_last_updated']; ?></td>
                                    <td><?php echo $result['last_updated']; ?></td>
                                </tr>
                                <?php if ($result['status'] == "1") {?>
                                <tr>
                                    <td><?php echo $lang['common']['text_status']; ?></td>
                                    <td><?php if ($result['status'] == "1") { echo $lang['tickets']['text_closed']; } else { echo $lang['tickets']['text_open']; } ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-head">
                    <div class="panel-title">
                        <i class="icon-info panel-head-icon"></i>
                        <span class="panel-title-text">For Office</span>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group customer-search">
                        <label class="col-form-label">Staff</label>
                        <?php if ($admin) { ?>
                        <select name="ticket[staff]" class="selectpicker" data-width="100%" data-live-search="true" title="Assign Staff">
                            <?php if ($staff) { foreach ($staff as $key => $value) { ?>
                            <option value="<?php echo $value['user_id']; ?>" <?php if ($result['user_id'] == $value['user_id']) { echo "selected"; } ?> ><?php echo $value['name'].' ('.$value['user_name'].')'; ?></option>
                                    <?php } } ?>
                        </select>
                        <?php } else { ?>
                        <input type="text" value="<?php echo $user['firstname'].' '.$user['lastname'].' ('.$user['role'].')'; ?>" readonly>
                        <input type="hidden" name="ticket[staff]" value="<?php echo $user['user_id']; ?>">
                        <?php } ?>   
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Remark</label>
                        <textarea name="ticket[remark]" class="form-control"><?php echo $result['remark']; ?></textarea>
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
    function ValidateSize(file) {
        if (typeof(file.files[0]) === "undefined") {
            $(file).val('');
            $(file).parent('.custom-file').find('label').text('Choose File');
            return false;
        }
        var FileSize = file.files[0].size / 1024 / 1024;
        if (FileSize > 2) {
            alert('File size exceeds 2 MB');
            $(file).val(''); //for clearing with Jquery
        } else {
            $(file).parent('.custom-file').find('label').text(file.files[0].name);
        }
    }

    $('body').on('click', '#add-more-file', function () {
        var count = parseInt($('.attachments').find('.custom-file:nth-last-child(1) input').prop('id').split("_")[2]) + 1; 
        $('.attachments').append('<div class="custom-file">'+
            '<label class="custom-file-label" for="custom_file_'+count+'"><?php echo $lang['tickets']['text_choose_file']; ?></label>'+
            '<input type="file" name="filename[]" accept="application/pdf, image/gif, image/jpeg, image/png" class="custom-file-input" size="20" onchange="ValidateSize(this);" id="custom_file_'+count+'">'+
            '</div>')
    });


</script>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>