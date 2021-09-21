<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#utilities').show();$('#utilities-li').addClass('active');</script>
<!-- User list page start -->
<div class="content">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-compass panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
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
                            <th><?php echo $lang['utilities']['text_message']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result) { foreach ($result as $key => $value) { $data = json_decode($value['logs'], true) ?>
                        <tr>
                            <td class="table-srno"><?php echo $key+1; ?></td>
                            <td><a class="font-14">
                                <p>==================<?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y H:m:s'); ?>================</p>
                                <p class="mb-1"><?php echo $lang['utilities']['text_creating_recurring_invoice']; ?></p>
                                <p class="mb-1"><?php echo $data['count'].' '.$lang['utilities']['text_invoice_created']; ?></p>
                                <p>
                                    <?php $inv = json_decode($data['inv']); if (!empty($inv)) { echo $lang['utilities']['text_recurring_invoice_ID_s_are']; ?> 
                                    <?php foreach ($inv as $inv_key => $inv_value) { ?>
                                    <a href="<?php echo URL.DIR_ROUTE.'recurring/edit&id='.$inv_value; ?> " class="text-info mr-2">RINV-<?php echo str_pad($inv_value, 4, '0', STR_PAD_LEFT); ?></a>
                                    <?php } } ?>
                                </p>
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
                <form action="<?php echo URL.DIR_ROUTE . 'emaillog/delete'; ?>" class="delete-card-button" method="post">
                    <input type="hidden" value="" name="id">
                    <button type="submit" class="btn btn-danger" name="delete"><?php echo $lang['common']['text_delete']; ?></button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['common']['text_close']; ?></button>
            </div>
        </div>
    </div>
</div>
<!-- Email Message Modal -->
<div id="messageModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $lang['utilities']['text_message']; ?></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="log-message" style="padding: 10px; border: 5px solid #ddd;">

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#messageModal').on('show.bs.modal', function () {
        $('#messageModal .log-message').append('<div class="message">'+$('#logview').data("message")+'</div>');
    })

    $('#messageModal').on('hidden.bs.modal', function (e) {
        $('#messageModal .log-message .message').remove();
    })

</script>

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>