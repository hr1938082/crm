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
                <div class="panel-head">
                    <div class="panel-title">
                        <i class="icon-credit-card panel-head-icon"></i>
                        <span class="panel-title-text"><?php echo $page_title; ?></span>
                    </div>
                    <div class="panel-action">
                        <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#addPaymentType"><i class="icon-plus mr-1"></i> New Payment Status</a>
                    </div>  
                </div>
                <div class="panel-wrapper">
                    <div class="table-container">
                        <table class="table table-bordered table-striped datatable-table" width="100%">
                            <thead>
                                <tr class="table-heading">
                                    <th class="table-srno">#</th>
                                    <th>Payment Status Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result) { foreach ($result as $key => $value) { ?>
                                <tr> 
                                    <td class="table-srno"><?php echo $key+1; ?></td>
                                    <td><?php echo $value['name']; ?></td>
                                    <td>
                                        <?php if ($value['status'] == 1) { echo "Active"; } else { echo "InActive"; } ?>
                                    </td>
                                    <td class="table-action">
                                        <a id="edit-paymenttype" class="btn btn-info btn-circle btn-outline btn-outline-1x" data-toggle="tooltip" title="Edit" data-name="<?php echo $value['name'] ?>" data-id="<?php echo $value['id'] ?>" data-status="<?php echo $value['status'] ?>">
                                            <i class="icon-pencil"></i>
                                        </a>
                                        <p class="btn btn-danger btn-circle btn-outline btn-outline-1x table-delete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="icon-trash"></i><input type="hidden" value="<?php echo $value['id']; ?>"></p>
                                    </td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?php include (DIR.'app/views/common/setting_menu_finance.tpl.php'); ?>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div id="delete-card" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirm Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="delete-card-ttl">Are you sure you want to delete?</p>
            </div>
            <div class="modal-footer">
                <form action="index.php?route=paymentstatus/delete" class="delete-card-button" method="post">
                    <input type="hidden" value="" name="id">
                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- ADD EDIT MODAL -->
<div class="modal fade" id="addPaymentType" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Payment Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo $action; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Payment Status Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Payment Type Name">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Status</label>
                        <select name="status" class="custom-select">
                            <option value="1">Active</option>
                            <option value="0">InActive</option>
                        </select>
                    </div>
                    <input type="hidden" name="id">
                    <input type="hidden" name="_token" value="<?php echo $token; ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary font-12" data-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary font-12">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        //New or Edit Payment type Modal *************
        $('body').on('click', '#edit-paymenttype', function () {
            var ele = $(this);
            $('#addPaymentType input[name="name"]').val(ele.data("name"));
            $('#addPaymentType input[name="id"]').val(ele.data("id"));
            $('#addPaymentType select[name="status"]').val(ele.data("status"));
            $('#addPaymentType .modal-title').text('Edit Payment Status');
            $('#addPaymentType').modal('show');
        });

        $('#addPaymentType').on('hidden.bs.modal', function (e) {
            $('#addPaymentType .modal-title').text('New Payment Status');
            $('#addPaymentType input').not( "[name='_token']" ).val('');
            $('#addPaymentType textarea').val('');
        });
        $('#finance-status').addClass('active');
    });
</script>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>