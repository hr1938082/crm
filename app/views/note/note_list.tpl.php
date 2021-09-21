<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#note-li').addClass('active');</script>
<!-- User list page start -->
<div class="panel panel-default">
    <div class="panel-head">
        <div class="panel-title">
            <i class="icon-note panel-head-icon"></i>
            <span class="panel-title-text"><?php echo $page_title; ?></span>
        </div>
        <div class="panel-action">
            <a href="<?php echo URL.DIR_ROUTE.'note/add'; ?>" class="btn btn-primary btn-outline btn-gradient btn-pill btn-sm"><i class="icon-plus mr-1"></i> <?php echo $lang['notes']['text_new_note']; ?></a>
        </div>
    </div>
    <div class="panel-body pb-0">
        <div class="notes-block">
            <div class="row">
                <?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
                    <div class="col-md-3">
                        <div class="notes-card" style="background: <?php echo $value['background']; ?>;color: <?php echo $value['color']; ?>">
                            <div class="notes">
                                <h2><?php echo $value['title']; ?></h2>
                                <div class="notes-body">
                                    <?php echo html_entity_decode($value['description']); ?>
                                </div>
                            </div>
                            <div class="notes-footer">
                                <div class="row align-items-center">
                                    <div class="col-md-6 text-left">
                                        <p class="font-14 mb-0"><i class="icon-calendar mr-2"></i><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></p> 
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="index.php?route=note/edit&id=<?php echo $value['id']; ?>"><i class="icon-pencil"></i></a>
                                        <a class="table-delete"><i class="icon-trash"></i><input type="hidden" value="<?php echo $value['id']; ?>"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } } else { ?>
                    <div class="col-12 text-center">
                        <p class="mb-0 font-18">No Note Found</p>
                    </div>
                    <div class="col-12 text-center pb-5">
                        <a href="<?php echo URL.DIR_ROUTE.'note/add'; ?>" class="btn btn-success mt-3">Create New Note</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- Note Modal -->
<div id="note-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div id="delete-card" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="delete-card-ttl">Are you sure you want to delete?</p>
            </div>
            <div class="modal-footer">
                <form action="<?php echo URL.DIR_ROUTE.'note/delete'; ?>" class="delete-card-button" method="post">
                    <input type="hidden" value="" name="id">
                    <button type="submit" class="btn btn-danger btn-gradient btn-pill" name="delete">Delete</button>
                </form>
                <button type="button" class="btn btn-default btn-gradient btn-pill" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('body').on('click', '.notes-card', function (e) {
        var notes = $(this).parent('.col-md-3').html();
        $('#note-modal .modal-content').append(notes);
        $('#note-modal').modal('show');
        $('#note-modal').on('hide.bs.modal', function (event) {
            $('#note-modal .modal-content .notes-card').remove();
        });
    });
</script>
<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>