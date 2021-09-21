<?php include (DIR_CLIENTS.'app/views/common/header.tpl.php'); ?>
<!-- Project list page start -->
<div class="content">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-calculator panel-head-icon"></i>
                <span class="panel-title-text"><?php echo $page_title; ?></span>
            </div>
            <div class="panel-action"></div>
        </div>
        <div class="panel-wrapper">
            <div class="table-container">
                <table class="table table-bordered table-striped datatable-table">
                    <thead>
                        <tr class="table-heading">
                            <th>#</th>
                            <th><?php echo $lang['quotes']['text_project_name']; ?></th>
                            <th><?php echo $lang['common']['text_customer']; ?></th>
                            <th><?php echo $lang['quotes']['text_quote_date']; ?></th>
                            <th><?php echo $lang['quotes']['text_expiry_date']; ?></th>
                            <th><?php echo $lang['common']['text_action']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result) { foreach ($result as $key => $value) { ?>
                        <tr>
                            <td><a href="<?php echo URL_CLIENTS.DIR_ROUTE . 'quote/view&id=' .$value['id']; ?>" class="text-primary font-14">QTN-<?php echo str_pad($value['id'], 4, '0', STR_PAD_LEFT); ?></a></td>
                            <td><?php echo $value['project_name']; ?></td>
                            <td><?php echo $value['company']; ?></td>
                            <td><?php echo date_format(date_create($value['date']), 'd-m-Y'); ?></td>
                            <td><?php echo date_format(date_create($value['expiry']), 'd-m-Y'); ?></td>
                            <td class="table-action">
                                <a href="<?php echo URL_CLIENTS.DIR_ROUTE . 'quote/view&id=' .$value['id']; ?>" class="btn btn-info btn-pill btn-sm" data-toggle="tooltip" title="View Quotation"><?php echo $lang['common']['text_view']; ?></a>
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