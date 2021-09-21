<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#expense-li').addClass('active');</script>

<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-rocket panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <button type="submit" class="btn btn-primary btn-icon" name="submit" data-toggle="tooltip" title="<?php echo $lang['common']['text_save']; ?>"><i class="far fa-save"></i></button>
                <a href="<?php echo URL.DIR_ROUTE.'expenses'; ?>" class="btn btn-white btn-icon" data-toggle="tooltip" title="<?php echo $lang['common']['text_back_to_list']; ?>"><i class="fa fa-reply"></i></a>
            </div>  
        </div>
        <div class="panel-wrapper p-3">
            <input type="hidden" name="_token" value="<?php echo $token; ?>">
            <div class="mt-3 pl-4 pr-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['expenses']['text_purchase_by']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-user"></i></span>
                                </div>
                                <input type="text" name="expense[purchaseby]" class="form-control" value="<?php echo $result['purchase_by']; ?>" placeholder="<?php echo $lang['expenses']['text_purchase_by']; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label"><?php echo $lang['common']['text_currency']; ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-credit-card"></i></span>
                                        </div>
                                        <select name="expense[currency]" class="custom-select" required>
                                            <?php if (!empty($currency)) { foreach ($currency as $key => $value) { ?>
                                            <option value="<?php echo $value['id'] ?>" <?php if ($result['currency'] == $value['id']) { echo "selected"; } ?>><?php echo $value['name'] ?></option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label"><?php echo $lang['expenses']['text_purchase_amount']; ?></label>
                                    <div class="input-group">
                                        <input type="text" name="expense[amount]" class="form-control" value="<?php echo $result['purchase_amount']; ?>" placeholder="<?php echo $lang['expenses']['text_purchase_amount']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['expenses']['text_payment_method']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-wallet"></i></span>
                                </div>
                                <select name="expense[paymenttype]" class="custom-select" required>
                                    <option value=""><?php echo $lang['expenses']['text_payment_method']; ?></option>
                                    <?php if (!empty($paymenttype)) { foreach ($paymenttype as $key => $value) { ?>
                                    <option value="<?php echo $value['id'] ?>" <?php if ($result['payment_type'] == $value['id']) { echo "selected"; } ?>><?php echo $value['name'] ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['expenses']['text_purchase_date']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                </div>
                                <input type="text" name="expense[purchasedate]" class="form-control date" value="<?php echo date_format(date_create($result['purchase_date']), 'd-m-Y'); ?>" placeholder="<?php echo $lang['expenses']['text_purchase_date']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group customer-search">
                            <label class="col-form-label"><?php echo $lang['expenses']['text_expense_type']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-badge"></i></span>
                                </div>
                                <select class="custom-select" name="expense[expensetype]" required>
                                    <?php if (!empty($expensetype)) { foreach ($expensetype as $key => $value) { ?>
                                    <option value="<?php echo $value['id'] ?>" <?php if ($result['expense_type'] == $value['id']) { echo "selected"; } ?>><?php echo $value['name'] ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label"><?php echo $lang['common']['text_description']; ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-speech"></i></span>
                                </div>
                                <textarea name="expense[description]" class="form-control" rows="10"><?php echo $result['description']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($result['id'])) { ?>
                    <div class="col-12">
                        <div class="form-group row">
                            <label class="col-form-label col-md-1"><?php echo $lang['expenses']['text_receipt']; ?></label>
                            <div class="attach-file col-md-10">
                                <a data-toggle="modal" data-target="#attach-file"><?php echo $lang['expenses']['text_upload_receipt']; ?></a>
                            </div>
                        </div>
                        <div class="attached-files">
                            <?php if (!empty($receipt)) { foreach ($receipt as $key => $value) { $file_ext = pathinfo($value['file_name'], PATHINFO_EXTENSION); if ($file_ext == "pdf") { ?>
                            <div class="attached-files-block">
                                <a href="public/uploads/<?php echo $value['file_name']; ?>" class="open-pdf"><i class="fa fa-file-pdf-o"></i></a>
                                <input type="hidden" name="expense[attached][]" value="<?php echo $value['file_name']; ?>">
                                <div class="delete-file"><a class="fa fa-trash"></a></div>
                            </div>
                            <?php } else { ?>
                            <div class="attached-files-block">
                                <a href="public/uploads/<?php echo $value['file_name']; ?>" data-fancybox="gallery"><img src="public/uploads/<?php echo $value['file_name']; ?>" alt=""></a>
                                <input type="hidden" name="expense[attached][]" value="<?php echo $value['file_name']; ?>">
                                <div class="delete-file"><a class="fa fa-trash"></a></div>
                            </div>
                            <?php } } } ?>
                        </div>
                    </div>
                    <?php } ?>
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
<!-- Attach File Modal -->
<div id="attach-file" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $lang['expenses']['text_upload_receipt']; ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="index.php?route=attachFile" class="dropzone" id="attach-file-upload"></form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="public/css/jquery.fancybox.min.css">
<script src="public/js/jquery.fancybox.min.js"></script>
<script>
    $(document).ready(function () {
        $("a.open-pdf").fancybox({
            'frameWidth': 800,
            'frameHeight': 900,
            'overlayShow': true,
            'hideOnContentClick': false,
            'type': 'iframe'
        });

        $("#attach-file-upload").dropzone({
            addRemoveLinks: true,
            acceptedFiles: "image/*,application/pdf",
            maxFilesize: 50000,
            dictDefaultMessage: '<?php echo $lang['common']['text_drop_message'].'<br /><br />'.$lang['common']['text_allowed_file']; ?>',
            init: function() {
                this.on("sending", function(file, xhr, formData){
                    var id = $('input[name=id]').val(),
                    type = 'expense';
                    formData.append("id", id);
                    formData.append("type", type);
                }),
                this.on("success", function(file, xhr){
                    var ext = file.xhr.response.substr(file.xhr.response.lastIndexOf('.') + 1);
                    if (ext === "pdf") {
                        $('.attached-files').append('<div class="attached-files-block attached-'+ file.xhr.response.slice(0, -4)+'">'+
                           '<a href="public/uploads/'+ file.xhr.response +'" class="open-pdf"><i class="fa fa-file-pdf-o"></i></a>'+
                           '<input type="hidden" name="expense[attached][]" value="'+ file.xhr.response +'">'+
                           '<div class="delete-file"><a class="fa fa-trash"></a></div>'+
                           '</div>');
                    } else {
                        $('.attached-files').append('<div class="attached-files-block attached-'+ file.xhr.response.slice(0, -4)+'">'+
                         '<a href="public/uploads/'+ file.xhr.response +'" data-fancybox="gallery"><img src="public/uploads/'+ file.xhr.response +'" alt=""></a>'+
                         '<input type="hidden" name="expense[attached][]" value="'+ file.xhr.response +'">'+
                         '<div class="delete-file"><a class="fa fa-trash"></a></div>'+
                         '</div>');
                    }
                    
                })
            },
            renameFile: function (file) {
                return file.name.split('.')[0] + new Date().valueOf() + "." + file.name.split('.').pop();
            },
            removedfile: function(file) {
                var name = file.upload.filename;
                $.ajax({
                    type: 'POST',
                    url: 'index.php?route=attachFile/delete',
                    data: {name: name, type: 'expense'},
                    error: function() {
                        toastr.error('File could not be deleted', 'Server Error');
                    },
                    success: function(data) {
                        $('.attached-'+name.slice(0, -4)+'').remove();
                        toastr.success('File Deleted Succefully', 'Success');
                    }
                });
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            }
        });

        $('.attached-files-block').on('click', '.delete-file a', function () {
            var ele = $(this),
            name = ele.parents('.attached-files-block').find('input').val();
            $.ajax({
                type: 'POST',
                url: 'index.php?route=attachFile/delete',
                data: {name: name, type: 'expense'},
                error: function() {
                    toastr.error('File could not be deleted', 'Server Error');
                },
                success: function(data) {
                    $('.attached-'+name.slice(0, -4)+'').remove();
                    toastr.success('File Deleted Succefully', 'Success');
                }
            });
            ele.parents('.attached-files-block').remove();
        });
    });
</script>

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>