<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>;$('#rinvoice-li').addClass('active');</script>
<!-- Invoice list page start -->

<div class="content">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-docs panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <a href="<?php echo URL.DIR_ROUTE.'recurring/add'; ?>" class="btn btn-primary btn-outline btn-gradient btn-pill btn-sm"><i class="icon-plus mr-1"></i> <?php echo $lang['invoices']['text_new_recurring_invoice']; ?></a>  
            </div>
        </div>
        <div class="panel-wrapper">
            <div class="table-container">
                <table class="table table-bordered table-striped datatable-table" width="100%">
                    <thead>
                        <tr class="table-heading">
                            <th>#</th>
                            <th><?php echo $lang['common']['text_customer']; ?></th>
                            <th><?php echo $lang['invoices']['text_amount']; ?></th>
                            <th><?php echo $lang['common']['text_status']; ?></th>
                            <th><?php echo $lang['common']['text_created_date']; ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
                        <tr>
                            <td><a href="<?php echo URL.DIR_ROUTE . 'recurring/view&id=' .$value['id']; ?>" class="text-primary">RINV-<?php echo str_pad($value['id'], 4, '0', STR_PAD_LEFT); ?></a></td>
                            <td><a href="<?php echo URL.DIR_ROUTE . 'contact/edit&id=' .$value['customer']; ?>" class="text-primary" target="_blank"><?php echo $value['company']; ?></a></td>
                            <td><?php echo $value['abbr'].' '.$value['amount']; ?></td>
                            <td>
                                <?php if ($value['inv_status'] == "0") { ?>
                                <span class="badge badge-light badge-pill badge-sm"><?php echo $lang['invoices']['text_draft'] ?></span>
                                <?php } else { ?>
                                <span class="badge badge-default badge-pill badge-sm"><?php echo $lang['invoices']['text_published'] ?></span>
                                <?php } ?>
                            </td>
                            <td><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></td>
                            <td class="table-action">
                                <a href="<?php echo URL.DIR_ROUTE . 'recurring/view&id=' .$value['id']; ?>" class="btn btn-dark btn-circle btn-outline btn-outline-1x" data-toggle="tooltip" title="<?php echo $lang['common']['text_view']; ?>"><i class="fa fa-eye"></i></a>
                                <a href="<?php echo URL.DIR_ROUTE . 'recurring/edit&id=' .$value['id']; ?>" class="btn btn-primary btn-circle btn-outline btn-outline-1x" data-toggle="tooltip" title="<?php echo $lang['common']['text_edit']; ?>"><i class="icon-pencil"></i></a>
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
                <h5 class="modal-title"><?php echo $lang['common']['text_confirm_delete']; ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="delete-card-ttl"><?php echo $lang['common']['text_are_you_sure_you_want_to_delete?']; ?></p>
            </div>
            <div class="modal-footer">
                <form action="<?php echo URL.DIR_ROUTE.'recurring/delete'; ?>" class="delete-card-button" method="post">
                    <input type="hidden" value="" name="id">
                    <button type="submit" class="btn btn-danger btn-gradient btn-pill" name="delete"><?php echo $lang['common']['text_delete']; ?></button>
                </form>
                <button type="button" class="btn btn-default btn-gradient btn-pill" data-dismiss="modal"><?php echo $lang['common']['text_close']; ?></button>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>