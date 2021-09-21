<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>
    $('#setting').show();
    $('#setting-li').addClass('active');</script>
</script>
<!-- Items list page start -->
<div class="content">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-list panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <a href="<?php echo URL.DIR_ROUTE.'item/add'; ?>" class="btn btn-primary btn-outline btn-gradient btn-pill btn-sm"><i class="icon-plus mr-1"></i> <?php echo $lang['settings']['text_new_item']; ?></a>
            </div>
        </div>
        <div class="panel-wrapper">
            <div class="table-container">
                <table class="table table-bordered table-striped datatable-table" width="100%">
                    <thead>
                        <tr class="table-heading">
                            <th class="table-srno">#</th>
                            <th><?php echo $lang['common']['text_name']; ?></th>
                            <th><?php echo $lang['settings']['text_price']; ?></th>
                            <th><?php echo $lang['common']['text_description']; ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result) { foreach ($result as $key => $value) { ?>
                        <tr>
                            <td class="table-srno"><?php echo $key+1; ?></td>
                            <td><?php echo $value['name']; ?></td>
                            <td><?php echo $value['price']; ?></td>
                            <td><?php echo $value['description']; ?></td>
                            <td class="table-action">
                                <a href="<?php echo URL.DIR_ROUTE.'item/edit&id=' .$value['id']; ?>" class="btn btn-primary btn-circle btn-outline btn-outline-1x" data-toggle="tooltip" data-placement="top" title="<?php echo $lang['common']['text_edit']; ?>"><i class="icon-pencil"></i></a>
                                <p class="btn btn-danger btn-circle btn-outline btn-outline-1x table-delete" data-toggle="tooltip" title="<?php echo $lang['common']['text_delete']; ?>"><i class="icon-trash"></i><input type="hidden" value="<?php echo $value['id'] ?>"></p>
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
                <form action="<?php echo URL.DIR_ROUTE.'item/delete'; ?>" class="delete-card-button" method="post">
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