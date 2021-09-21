<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>
    $('#setting').show();
    $('#setting-li').addClass('active');</script>
</script>
<!-- Expense Type page start -->
<div class="content">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-settings panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <a class="btn btn-primary btn-outline btn-gradient btn-pill btn-sm" data-toggle="modal" data-target="#addExpenseModel"><i class="icon-plus mr-1"></i> <?php echo $lang['settings']['text_new_expense_type']; ?></a>
            </div>  
        </div>
        <div class="panel-wrapper">
            <div class="table-container">
                <table class="table table-bordered table-striped datatable-table" width="100%">
                    <thead>
                        <tr class="table-heading">
                            <th class="table-srno">#</th>
                            <th><?php echo $lang['settings']['text_expense_type_name']; ?></th>
                            <th><?php echo $lang['common']['text_description']; ?></th>
                            <th><?php echo $lang['common']['text_status']; ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result) { foreach ($result as $key => $value) { ?>
                        <tr> 
                            <td class="table-srno"><?php echo $key+1; ?></td>
                            <td><?php echo $value['name']; ?></td>
                            <td><?php echo $value['description']; ?></td>
                            <td>
                                <?php if ($value['status'] == 1) { echo "Active"; } else { echo "InActive"; } ?>
                            </td>
                            <td class="table-action">
                                <a class="btn btn-primary btn-circle btn-outline btn-outline-1x edit-expense-type" data-toggle="tooltip" title="<?php echo $lang['common']['text_edit']; ?>" data-name="<?php echo $value['name'] ?>" data-description="<?php echo $value['description'] ?>" data-id="<?php echo $value['id'] ?>" data-status="<?php echo $value['status'] ?>">
                                    <i class="icon-pencil"></i>
                                </a>
                                <p class="btn btn-danger btn-circle btn-outline btn-outline-1x table-delete" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['common']['text_delete']; ?>"><i class="icon-trash"></i><input type="hidden" value="<?php echo $value['id']; ?>"></p>
                            </td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div id="delete-card" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $lang['common']['text_confirm_delete']; ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="delete-card-ttl"><?php echo $lang['common']['text_are_you_sure_you_want_to_delete?']; ?></p>
            </div>
            <div class="modal-footer">
                <form action="<?php echo URL.DIR_ROUTE.'expensetype/delete'; ?>" class="delete-card-button" method="post">
                    <input type="hidden" value="" name="id">
                    <button type="submit" class="btn btn-danger btn-gradient btn-pill" name="delete"><?php echo $lang['common']['text_delete']; ?></button>
                </form>
                <button type="button" class="btn btn-default btn-gradient btn-pill" data-dismiss="modal"><?php echo $lang['common']['text_close']; ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ADD EDIT MODAL -->
<div class="modal fade" id="addExpenseModel" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $lang['settings']['text_new_expense_type']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo $action; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['settings']['text_expense_type_name']; ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?php echo $lang['settings']['text_expense_type_name']; ?>">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['common']['text_description']; ?></label>
                        <textarea name="description" class="form-control" rows="3" placeholder="<?php echo $lang['common']['text_description']; ?>"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['common']['text_status']; ?></label>
                        <select name="status" class="custom-select">
                            <option value="1"><?php echo $lang['settings']['text_active']; ?></option>
                            <option value="0"><?php echo $lang['settings']['text_inactive']; ?></option>
                        </select>
                    </div>
                    <input type="hidden" name="id">
                    <input type="hidden" name="_token" value="<?php echo $token; ?>">
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn btn-primary btn-gradient btn-pill"><?php echo $lang['common']['text_save']; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        //New or Edit Payment type Modal *************
        $('body').on('click', '.edit-expense-type', function () {
            var ele = $(this);
            $('#addExpenseModel input[name="name"]').val(ele.data("name"));
            $('#addExpenseModel textarea[name="description"]').val(ele.data("description"));
            $('#addExpenseModel input[name="id"]').val(ele.data("id"));
            $('#addExpenseModel select[name="status"]').val(ele.data("status"));
            $('#addExpenseModel .modal-title').text('<?php echo $lang['settings']['text_edit_expense_type']; ?>');
            $('#addExpenseModel').modal('show');
        });

        $('#addExpenseModel').on('hidden.bs.modal', function (e) {
            $('#addExpenseModel .modal-title').text('<?php echo $lang['settings']['text_new_expense_type']; ?>');
            $('#addExpenseModel input').not( "[name='_token']" ).val('');
            $('#addExpenseModel textarea').val('');
        });

    });
</script>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>