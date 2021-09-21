<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#contact').show();$('#contact-li').addClass('active');</script>
<!-- User list page start -->
<div class="content">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-emotsmile panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?> <small class="text-muted ml-1">(<?php echo $lang['contact']['text_user_registered_on_client_portal']; ?>)</small></span>
            </div>
            <div class="panel-action">
            </div>
        </div>
        <div class="panel-wrapper">
            <div class="table-container">
                <table class="table table-bordered table-striped datatable-table" width="100%">
                    <thead>
                        <tr class="table-heading">
                            <th class="table-srno">#</th>
                            <th><?php echo $lang['common']['text_name']; ?></th>
                            <th><?php echo $lang['common']['text_email_address']; ?></th>
                            <th><?php echo $lang['common']['text_mobile_number']; ?></th>
                            <th><?php echo $lang['common']['text_created_date']; ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result) { foreach ($result as $key => $value) { ?>
                        <tr>
                            <td class="table-srno"><?php echo $key+1; ?></td>
                            <td><a class="font-14"><?php echo $value['name']; ?></a></td>
                            <td><?php echo $value['email']; ?></td>
                            <td><?php echo $value['mobile']; ?></td>
                            <td><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></td>
                            <td class="table-action">
                                <a href="<?php echo URL.DIR_ROUTE . 'client/edit&id=' .$value['id']; ?>" class="btn btn-info btn-circle btn-outline btn-outline-1x" data-toggle="tooltip" title="<?php echo $lang['common']['text_edit']; ?>"><i class="icon-pencil"></i></a>
                                <p class="btn btn-danger btn-circle btn-outline btn-outline-1x table-delete" data-toggle="tooltip" title="<?php echo $lang['common']['text_delete']; ?>"><i class="icon-trash"></i><input type="hidden" value="<?php echo $value['id']; ?>"></p>
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
                <form action="<?php echo URL.DIR_ROUTE . 'client/delete'; ?>" class="delete-card-button" method="post">
                    <input type="hidden" value="" name="id">
                    <button type="submit" class="btn btn-danger" name="delete"><?php echo $lang['common']['text_delete']; ?></button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['common']['text_close']; ?></button>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>