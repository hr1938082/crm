<?php include (DIR_CLIENTS.'app/views/common/header.tpl.php'); ?>
<!-- Project list page start -->
<div class="content">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-credit-card panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action">
                <a href="<?php echo URL_CLIENTS.DIR_ROUTE . 'ticket/add'; ?>" class="btn btn-success btn-sm"><i class="icon-plus mr-1"></i> <?php echo $lang['tickets']['text_new_ticket']; ?></a>
            </div>
        </div>
        <div class="panel-wrapper">
            <div class="table-container">
                <table class="datatable-table" width="100%">
                    <thead>
                        <tr class="table-heading">
                            <th style="display: none"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
                        <tr>
                            <td>
                                <div class="card-block">
                                    <div class="card card-color-new">
                                        <div class="row card-hdr">
                                            <div class="col-sm-4 card-left text-left">
                                                <span class="text-center">#<?php echo $value['id']; ?></span>
                                            </div>
                                            <div class="col-sm-8 text-right card-right">
                                                <span><?php echo $lang['common']['text_created_date']; ?> - <?php echo $value['date_of_joining']; ?></span>
                                            </div>
                                        </div>
                                        <div class="row card-bdy">
                                            <div class="col-sm-6 col-md-5 text-left">
                                                <div class="card-img">
                                                    <i class="icon-user"></i>
                                                </div>
                                                <div class="card-info">
                                                    <a class="card-name" target="_blank"><?php echo $value['name']; ?></a>
                                                    <div class="card-text"><?php echo $lang['common']['text_department']; ?> - <?php echo $value['department']; ?></div>
                                                    <div class="card-text"><?php echo $lang['tickets']['text_priority']; ?> - <?php if ($value['priority'] == 'Low') { ?>
                                                        <span class="badge badge-Low badge-sm badge-pill"><?php echo $lang['tickets']['text_low']; ?></span>
                                                        <?php } elseif ($value['priority'] == 'Medium') { ?>
                                                        <span class="badge badge-Medium badge-sm badge-pill"><?php echo $lang['tickets']['text_medium']; ?></span>
                                                        <?php } else { ?>
                                                        <span class="badge badge-High badge-sm badge-pill"><?php echo $lang['tickets']['text_high']; ?></span>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-7 card-subject">
                                                <span><?php echo $lang['tickets']['text_subject']; ?></span>
                                                <p><?php echo $value['subject']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row card-ftr align-items-center">
                                            <div class="col-sm-8 text-left">
                                                <span class="badge badge-light badge-pill badge-sm"><?php echo $lang['tickets']['text_last_updated']; ?> - <?php echo $value['last_updated']; ?></span>
                                                <span class="badge badge-default badge-pill badge-sm"><?php if ($value['status'] == "1") { echo $lang['tickets']['text_closed']; } else { echo $lang['tickets']['text_open']; } ?></span> 
                                            </div>
                                            <div class="col-sm-4 text-right card-action">
                                                <a href="<?php echo URL_CLIENTS.DIR_ROUTE.'ticket/edit&id='.$value['id']; ?>" class="btn btn-outline btn-info btn-outline-1x btn-circle" data-toggle="tooltip" title="<?php echo $lang['common']['text_edit']; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include (DIR_CLIENTS.'app/views/common/footer.tpl.php'); ?>