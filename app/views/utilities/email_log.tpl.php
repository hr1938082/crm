<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#utilities').show();$('#utilities-li').addClass('active');</script>
<!-- User list page start -->
<div class="content">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-envelope-letter panel-head-icon"></i>
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
                            <th><?php echo $lang['utilities']['text_email_to_and_bcc']; ?></th>
                            <th><?php echo $lang['utilities']['text_subject']; ?></th>
                            <th><?php echo $lang['utilities']['text_mail_of']; ?></th>
                            <th><?php echo $lang['common']['text_created_date']; ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result) { foreach ($result as $key => $value) { ?>
                        <tr>
                            <td class="table-srno"><?php echo $key+1; ?></td>
                            <td><a class="font-14">
                                <p class="m-0"><?php echo '<b>'.$lang['utilities']['text_to'].' : </b> '.$value['email_to']; ?></p>
                                <p class="m-0"><?php echo '<b>'.$lang['utilities']['text_bcc'].' : </b> '.$value['email_bcc']; ?></p>
                            </td>
                            <td><?php echo $value['subject']; ?></td>
                            <td><?php echo $value['type']; ?></td>
                            <td><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></td>
                            <td class="table-action">
                                <a id="logview" class="btn btn-dark btn-circle btn-outline btn-outline-1x" data-toggle="modal" data-target="#messageModal" data-message="<?php echo $value['message'] ?>"><i class="fa fa-eye"></i></a>
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