<?php include (DIR_CLIENTS.'app/views/common/header.tpl.php'); ?>
<!-- Invoice list page start -->

<div class="content">
    <div class="panel panel-default">
        <div class="panel-head">
            <div class="panel-title">
                <i class="icon-docs panel-head-icon"></i>
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
                            <th><?php echo $lang['common']['text_customer']; ?></th>
                            <th><?php echo $lang['common']['text_status']; ?></th>
                            <th><?php echo $lang['invoices']['text_amount']; ?></th>
                            <th><?php echo $lang['invoices']['text_due']; ?></th>
                            <th><?php echo $lang['invoices']['text_due_date']; ?></th>
                            <th><?php echo $lang['common']['text_created_date']; ?></th>
                            <th><?php echo $lang['common']['text_action']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($result)) { foreach ($result as $key => $value) { ?>
                        <tr class="text-center">
                            <td><a href="<?php echo URL_CLIENTS.DIR_ROUTE . 'invoice/view&id=' .$value['id']; ?>" class="text-primary">INV-<?php echo str_pad($value['id'], 4, '0', STR_PAD_LEFT); ?></a></td>
                            <td><?php echo $value['company']; ?></td>
                            <td>
                                <?php if ($value['status'] == "Paid") { ?>
                                <span class="badge badge-Paid badge-pill badge-sm"><?php echo $lang['invoices']['text_paid']; ?></span>
                                <?php } elseif ($value['status'] == "Unpaid") { ?>
                                <span class="badge badge-Unpaid badge-pill badge-sm"><?php echo $lang['invoices']['text_unpaid']; ?></span>
                                <?php } elseif ($value['status'] == "Pending") { ?>
                                <span class="badge badge-Pending badge-pill badge-sm"><?php echo $lang['invoices']['text_pending']; ?></span>
                                <?php } elseif ($value['status'] == "In Process") { ?>
                                <span class="badge badge-In-Process badge-pill badge-sm"><?php echo $lang['invoices']['text_in_process']; ?></span>
                                <?php } elseif ($value['status'] == "Cancelled") { ?>
                                <span class="badge badge-Cancelled badge-pill badge-sm"><?php echo $lang['invoices']['text_cancelled']; ?></span>
                                <?php } elseif ($value['status'] == "Other") { ?>
                                <span class="badge badge-Other badge-pill badge-sm"><?php echo $lang['invoices']['text_other']; ?></span>
                                <?php } elseif ($value['status'] == "Partially Paid") { ?>
                                <span class="badge badge-Partially-Paid badge-pill badge-sm"><?php echo $lang['invoices']['text_partially_paid']; ?></span>
                                <?php } else { ?>
                                <span class="badge badge-Unknown badge-pill badge-sm"><?php echo $lang['invoices']['text_unknown']; ?></span>
                                <?php } ?>
                            </td>
                            <td><?php echo $value['abbr'].' '.$value['amount']; ?></td>
                            <td><?php echo $value['abbr'].' '.$value['due']; ?></td>
                            <td><?php echo date_format(date_create($value['duedate']), 'd-m-Y'); ?></td>
                            <td><?php echo date_format(date_create($value['date_of_joining']), 'd-m-Y'); ?></td>
                            <td class="table-action">
                                <?php if ($value['due'] > "0") { ?>
                                <a href="<?php echo URL_CLIENTS.DIR_ROUTE . 'makepayment&invoice=' .$value['id']; ?>" class="btn btn-warning btn-pill btn-sm"><?php echo $lang['invoices']['text_pay_now']; ?></a>
                                <?php } ?>
                                <a href="<?php echo URL_CLIENTS.DIR_ROUTE . 'invoice/view&id=' .$value['id']; ?>" class="btn btn-info btn-pill btn-sm"><?php echo $lang['common']['text_view']; ?></a>
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