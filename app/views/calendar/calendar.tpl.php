<?php include (DIR.'app/views/common/header.tpl.php'); ?>
<script>$('#calendar-li').addClass('active');</script>
<!-- Items list page start -->
<div class="content">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-event panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <a class="btn btn-primary btn-outline btn-gradient btn-pill btn-sm" data-toggle="modal" data-target="#event-modal"><i class="icon-plus mr-1"></i> <?php echo $lang['calendar']['text_new_event']; ?></a>
            </div>
        </div>
        <div class="panel-wrapper">
            <div class="panel-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<!-- Event Modal -->
<div id="event-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $lang['calendar']['text_calendar_event']; ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?php echo $action; ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['calendar']['text_event_title']; ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-user"></i></span>
                            </div>
                            <input type="text" class="form-control event-title" name="event[title]" value="" placeholder="<?php echo $lang['calendar']['text_event_title']; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label"><?php echo $lang['calendar']['text_start_date']; ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-clock"></i></span>
                                    </div>
                                    <input type="text" class="form-control datetime event-start" name="event[start]" value="" placeholder="<?php echo $lang['calendar']['text_start_date']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label"><?php echo $lang['calendar']['text_end_date']; ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-clock"></i></span>
                                    </div>
                                    <input type="text" class="form-control datetime event-end" name="event[end]" value="" placeholder="<?php echo $lang['calendar']['text_end_date']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label><?php echo $lang['calendar']['text_all_day_event_(Select_if_all_day_event)']; ?></label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="event[allday]" class="custom-control-input event-allday" id="allday">
                                <label class="custom-control-label" for="allday"><?php echo $lang['calendar']['text_all_day_event']; ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $lang['common']['text_description']; ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-note"></i></span>
                            </div>
                            <textarea class="form-control event-descr" name="event[description]" placeholder="<?php echo $lang['common']['text_description']; ?>"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-gradient btn-pill font-12" name="submit"><?php echo $lang['common']['text_save']; ?></button>
                    <a class="btn btn-danger btn-gradient btn-pill table-delete font-12"><input type="hidden" name="id" class="event-id"> <?php echo $lang['common']['text_delete']; ?></a>
                    <button type="button" class="btn btn-default btn-gradient btn-pill font-12" data-dismiss="modal"><?php echo $lang['common']['text_close']; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div id="delete-card" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $lang['common']['text_confirm_delete']; ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="delete-card-ttl"><?php echo $lang['common']['text_are_you_sure_you_want_to_delete?']; ?></p>
            </div>
            <div class="modal-footer">
                <form action="<?php echo URL.DIR_ROUTE.'calendar/delete'; ?>" class="delete-card-button" method="post">
                    <input type="hidden" value="" name="id">
                    <button type="submit" class="btn btn-danger btn-gradient btn-pill" name="delete"><?php echo $lang['common']['text_delete']; ?></button>
                </form>
                <button type="button" class="btn btn-default btn-gradient btn-pill" data-dismiss="modal"><?php echo $lang['common']['text_close']; ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Full Calendar Plugin -->
<link rel="stylesheet" href="public/css/fullcalendar.min.css" />
<script type="text/javascript" src="public/js/fullcalendar.min.js"></script>

<!-- Calendar script -->
<script>
    var obj = <?php echo $result; ?>;
    events = [];
    $.each( obj, function( key, value ) {
        var temp = [];
        temp['id'] = value['id'];
        temp['title'] = value['title'];
        temp['start'] = value['start_date'] + 'T' + value['start_time'];
        temp['end'] = value['end_date'] + 'T' + value['end_time'];
        if (value['allDay'] == "1") {
            temp['allday'] = true;
            temp['full'] = 1;
        } else {
            temp['allday'] = false;
            temp['full'] = 0;
        }
        temp['description'] = value['description'];
        events.push(temp);
    });
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        editable: true,
        eventLimit: true,
        navLinks: true,
        events: events,
        eventClick: function(event, jsEvent, view) {
            $('.event-title').val(event.title);
            $('.event-start').val(event.start.format('DD-MM-YYYY hh:mm A'));
            $('.event-descr').val(event.description);
            $('.event-id').val(event.id);
            if (event.full === 1) {
                $('.event-allday').prop('checked', true);
                $('.event-end').parents('.form-group').hide();
            } else if (event.end !== null) {
                $('.event-end').val(event.end.format('DD-MM-YYYY hh:mm A'));
            }
            $('#event-modal').modal('show');
        },
        eventDrop: function (event, delta, revertFunc) {
            if (!confirm("Are you sure about this change?")) {
                revertFunc();
            } else {
                $.ajax({
                    method: "POST",
                    url: 'index.php?route=calendar/drop',
                    data: { id: event.id, start: moment(event.start).format('YYYY-MM-DD H:mm') },
                    error: function () {
                        alert('Sorry Try Again!');
                    },
                    success: function (response) {
                        toastr.success('<?php echo $lang['calendar']['text_event_updated_successfully']; ?>');
                    }
                });
            }
        }
    });

    $('#event-modal').on('hidden.bs.modal', function (e) {
        $('#event-modal input, #event-modal textarea').val('');
        $('.event-allday').prop('checked', false);
        $('.event-end').parents('.form-group').show();
    });

    $('#event-modal').on('click', '.event-allday',function(){
        var ele = $(this); 
        $('.event-end').val(moment(Date()).format('DD-MM-YYYY h:mm A'));
        $('.event-end').val('');
        if(ele.prop("checked") === true){
            $('.event-end').parents('.form-group').hide();
        }
        else if(ele.prop("checked") === false){
            $('.event-end').parents('.form-group').show();
        }
    });
</script>

<!-- Footer -->
<?php include (DIR.'app/views/common/footer.tpl.php'); ?>