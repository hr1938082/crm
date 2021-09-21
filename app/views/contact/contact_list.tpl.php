<?php include(DIR . 'app/views/common/header.tpl.php'); ?>
<script>
    $('#contact').show();
    $('#contact-li').addClass('active');
</script>
<!-- User list page start -->
<div class="content">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-emotsmile panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <button type="submit" form="deleteForm" class="btn btn-outline btn-danger btn-pill btn-outline-1x btn-sm">Delete</button>
                <?php if ($admin) { ?>
                    <a class="btn btn-outline btn-warning btn-pill btn-outline-1x btn-sm" data-toggle="modal" data-target="#import-contact"><i class="icon-cloud-upload mr-1"></i> <?php echo $lang['contact']['text_import_contact']; ?></a>
                <?php } ?>
                <a href="<?php echo URL . DIR_ROUTE . 'contact/add'; ?>" class="btn btn-primary btn-outline btn-gradient btn-pill btn-sm"><i class="icon-plus mr-1"></i> <?php echo $lang['contact']['text_new_contact']; ?></a>
            </div>
        </div>
        <div class="panel-wrapper">
            <div class="table-container">
                <form action="<?php echo URL . DIR_ROUTE . 'contact/delete'; ?>" id="deleteForm" method="post">
                    <table class="table table-bordered table-striped datatable-table" width="100%">
                        <thead>
                            <tr class="table-heading">
                                <th class="table-srno">#</th>
                                <th><?php echo $lang['contact']['text_company']; ?></th>
                                <th><?php echo $lang['common']['text_email_address']; ?></th>
                                <th><?php echo $lang['common']['text_phone_number']; ?></th>
                                <th><input type="checkbox" data-toggle="tooltip" title="Select all" id="checkall" onclick="checkUncheckAll()"></th>
                                <th><?php echo $lang['common']['text_created_date']; ?></th>
                                <th><?php echo $lang['contact']['text_expire_date']; ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result) {
                                $today = date("Y-m-d");
                                foreach ($result as $key => $value) { ?>
                                    <tr>
                                        <td class="table-srno"><?php echo $key + 1; ?></td>
                                        <td><a class="font-14"><?php echo $value['company']; ?></a></td>
                                        <td><?php echo $value['email']; ?></td>
                                        <td><?php echo $value['phone']; ?></td>
                                        <td><input type="checkbox" name="delete[]" value="<?php echo $value['id'] ?>" data-toggle="tooltip" title="Select to delete"></td>
                                        <td><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></td>
                                        <td>
                                            <?php if (strtotime($today) < strtotime($value['expire'])) { ?>
                                                <span class="badge badge-light badge-sm badge-pill"><?php echo date_format(date_create($value['expire']), 'd-m-Y'); ?></span>
                                            <?php } else { ?>
                                                <span class="badge badge-danger badge-sm badge-pill"><?php echo date_format(date_create($value['expire']), 'd-m-Y'); ?></span>
                                            <?php } ?>
                                        </td>
                                        <td class="table-action">
                                            <a href="<?php echo URL . DIR_ROUTE . 'contact/view&id=' . $value['id']; ?>" class="btn btn-secondary btn-circle btn-outline btn-outline-1x" data-toggle="tooltip" title="<?php echo $lang['common']['text_view']; ?>"><i class="fa fa-eye"></i></a>
                                            <a href="<?php echo URL . DIR_ROUTE . 'contact/edit&id=' . $value['id']; ?>" class="btn btn-primary btn-circle btn-outline btn-outline-1x" data-toggle="tooltip" title="<?php echo $lang['common']['text_edit']; ?>"><i class="icon-pencil"></i></a>
                                            <p class="btn btn-danger btn-circle btn-outline btn-outline-1x table-delete" data-toggle="tooltip" title="<?php echo $lang['common']['text_delete']; ?>"><i class="icon-trash"></i><input type="hidden" value="<?php echo $value['id']; ?>"></p>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div id="delete-card" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $lang['common']['text_confirm_delete']; ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?php echo URL . DIR_ROUTE . 'contact/delete'; ?>" class="delete-card-button" method="post">
                <div class="modal-body">
                    <p class="delete-card-ttl"><?php echo $lang['common']['text_are_you_sure_you_want_to_delete?']; ?></p>
                    <div class="custom-control custom-checkbox custom-checkbox-1 d-inline-block">
                        <input type="checkbox" class="custom-control-input" id="delete-all">
                        <label class="custom-control-label" for="delete-all"><?php echo $lang['contact']['text_contact_delete_all']; ?></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" name="id">
                    <button type="submit" class="btn btn-danger btn-gradient btn-pill" name="delete"><?php echo $lang['common']['text_delete']; ?></button>
                    <a class="btn btn-default btn-gradient btn-pill" data-dismiss="modal"><?php echo $lang['common']['text_close']; ?></a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="import-contact" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $lang['contact']['text_import_contact']; ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="text-right mb-3">
                    <a href="<?php echo URL . DIR_ROUTE . 'contact/sample'; ?>" class="btn btn-warning btn-pill btn-sm" target="_blank">Download Sample File</a>
                </div>
                <form action="<?php echo URL . DIR_ROUTE . 'contact/import'; ?>" class="dropzone dz-clickable" id="contact-import">
                    <div class="dz-default dz-message"><span><?php echo $lang['common']['text_drop_message'] . '<br>' . $lang['common']['text_csv_allowed_file']; ?></span></div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("#contact-import").dropzone({
        addRemoveLinks: true,
        acceptedFiles: '.csv',
        dictInvalidFileType: '<?php echo $lang['common']['text_csv_allowed_file']; ?>',
        maxFiles: 1,
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                this.removeAllFiles();
                this.addFile(file);
            });
        },
        success: function(file, response) {
            if (response == '1') {
                toastr.success('<?php echo $lang['common']['text_page_updated_successfully']; ?>');
                location.reload();
            } else {
                toastr.warning('<?php echo $lang['common']['text_page_not_updated_successfully']; ?>');
            }

        }
    });
</script>

<script>
    var checkUncheckAll = (e) => {
        var checkall = document.getElementById('checkall');
        if (checkall.checked) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = true;
            }
        } else {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = false;
            }
        }
    }
</script>
<!-- Footer -->
<?php include(DIR . 'app/views/common/footer.tpl.php'); ?>